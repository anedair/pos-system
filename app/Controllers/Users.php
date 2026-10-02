<?php

namespace App\Controllers;

use App\Models\UserModel;
use CodeIgniter\Exceptions\PageNotFoundException;
use Throwable;

class Users extends BaseController
{
    public function index()
    {
        $userModel = new UserModel();

        return view('users/index', [
            'users' => $userModel->orderBy('id', 'DESC')->findAll(),
        ]);
    }

    public function new()
    {
        return view('users/new');
    }

    public function create()
    {
        $data = [
            'username'  => trim((string) $this->request->getPost('username')),
            'full_name' => trim((string) $this->request->getPost('full_name')),
        ];

        $rules = [
            'username' => [
                'label' => 'Username',
                'rules' => 'required|max_length[50]|is_unique[users.username]',
                'errors' => [
                    'is_unique' => 'That username is already being used.',
                ],
            ],
            'full_name' => [
                'label' => 'Full name',
                'rules' => 'required|max_length[100]',
            ],
        ];

        if (! $this->validateData($data, $rules)) {
            return redirect()
                ->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        $data['created_at'] = date('Y-m-d H:i:s');

        $userModel = new UserModel();
        $userModel->insert($data);

        return redirect()
            ->to(site_url('users'))
            ->with('success', 'User added successfully.');
    }

    public function edit(int $id)
    {
        $userModel = new UserModel();
        $user = $userModel->find($id);

        if ($user === null) {
            throw PageNotFoundException::forPageNotFound(
                'User record not found.'
            );
        }

        return view('users/edit', [
            'user' => $user,
        ]);
    }

    public function update(int $id)
    {
        $userModel = new UserModel();
        $user = $userModel->find($id);

        if ($user === null) {
            throw PageNotFoundException::forPageNotFound(
                'User record not found.'
            );
        }

        $data = [
            'id'        => $id,
            'username'  => trim((string) $this->request->getPost('username')),
            'full_name' => trim((string) $this->request->getPost('full_name')),
        ];

        $rules = [
            'id' => [
                'rules' => 'required|is_natural_no_zero',
            ],
            'username' => [
                'label' => 'Username',
                'rules' => 'required|max_length[50]'
                    . '|is_unique[users.username,id,{id}]',
                'errors' => [
                    'is_unique' => 'That username is already being used.',
                ],
            ],
            'full_name' => [
                'label' => 'Full name',
                'rules' => 'required|max_length[100]',
            ],
        ];

        if (! $this->validateData($data, $rules)) {
            return redirect()
                ->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        unset($data['id']);

        $avatar = $this->request->getFile('avatar');
        $newAvatarName = null;

        if (
            $avatar !== null
            && $avatar->getError() !== UPLOAD_ERR_NO_FILE
        ) {
            $avatarRules = [
                'avatar' => [
                    'label' => 'Profile picture',
                    'rules' => [
                        'uploaded[avatar]',
                        'is_image[avatar]',
                        'mime_in[avatar,image/jpg,image/jpeg,image/png]',
                        'ext_in[avatar,jpg,jpeg,png]',
                        'max_size[avatar,2048]',
                    ],
                    'errors' => [
                        'is_image' => 'The uploaded file must be an image.',
                        'mime_in'  => 'Only JPG and PNG images are allowed.',
                        'ext_in'   => 'Only JPG and PNG images are allowed.',
                        'max_size' => 'The image must not be larger than 2 MB.',
                    ],
                ],
            ];

            if (! $this->validate($avatarRules)) {
                return redirect()
                    ->back()
                    ->withInput()
                    ->with('errors', $this->validator->getErrors());
            }

            $uploadDirectory = FCPATH . 'uploads/avatars';

            if (
                ! is_dir($uploadDirectory)
                && ! mkdir($uploadDirectory, 0755, true)
                && ! is_dir($uploadDirectory)
            ) {
                return redirect()
                    ->back()
                    ->withInput()
                    ->with('errors', [
                        'avatar' => 'The avatar upload directory could not be created.',
                    ]);
            }

            $extension = strtolower($avatar->getExtension());
            $extension = $extension === 'png' ? 'png' : 'jpg';

            $newAvatarName = bin2hex(random_bytes(16)) . '.' . $extension;
            $destination = $uploadDirectory
                . DIRECTORY_SEPARATOR
                . $newAvatarName;

            try {
                service('image')
                    ->withFile($avatar->getTempName())
                    ->reorient()
                    ->fit(200, 200, 'center')
                    ->save($destination, 85);
            } catch (Throwable $exception) {
                log_message(
                    'error',
                    'Avatar processing failed: {message}',
                    ['message' => $exception->getMessage()]
                );

                return redirect()
                    ->back()
                    ->withInput()
                    ->with('errors', [
                        'avatar' => 'The profile picture could not be processed.',
                    ]);
            }

            $data['avatar'] = $newAvatarName;
        }

        try {
            $userModel->update($id, $data);
        } catch (Throwable $exception) {
            if ($newAvatarName !== null) {
                $newAvatarPath = FCPATH
                    . 'uploads/avatars/'
                    . $newAvatarName;

                if (is_file($newAvatarPath)) {
                    unlink($newAvatarPath);
                }
            }

            throw $exception;
        }

        if ($newAvatarName !== null && ! empty($user['avatar'])) {
            $oldAvatarPath = FCPATH
                . 'uploads/avatars/'
                . basename($user['avatar']);

            if (is_file($oldAvatarPath)) {
                unlink($oldAvatarPath);
            }
        }

        return redirect()
            ->to(site_url('users'))
            ->with('success', 'User updated successfully.');
    }
}