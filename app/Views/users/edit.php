<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User</title>
</head>
<body>

<?= view('partials/navigation') ?>

<h1>Edit User</h1>

<?php if ($errors = session()->getFlashdata('errors')): ?>
    <div style="color: red;">
        <ul>
            <?php foreach ($errors as $error): ?>
                <li><?= esc($error) ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>

<form
    action="<?= site_url('users/' . $user['id']) ?>"
    method="post"
    enctype="multipart/form-data"
>
    <?= csrf_field() ?>

    <div>
        <label for="username">Username *</label>
        <input
            type="text"
            id="username"
            name="username"
            maxlength="50"
            value="<?= esc(old('username', $user['username'])) ?>"
            required
        >
    </div>

    <div>
        <label for="full_name">Full Name *</label>
        <input
            type="text"
            id="full_name"
            name="full_name"
            maxlength="100"
            value="<?= esc(old('full_name', $user['full_name'])) ?>"
            required
        >
    </div>

    <?php
        $hasAvatar = ! empty($user['avatar'])
            && is_file(
                FCPATH
                . 'uploads/avatars/'
                . basename($user['avatar'])
            );

        $avatarUrl = $hasAvatar
            ? base_url(
                'uploads/avatars/'
                . rawurlencode($user['avatar'])
            )
            : base_url('images/default-avatar.svg');
    ?>

    <div>
        <p>Current profile picture:</p>

        <img
            src="<?= esc($avatarUrl) ?>"
            alt="Profile picture"
            width="120"
            height="120"
            style="object-fit: cover; border-radius: 50%;"
        >
    </div>

    <div>
        <label for="avatar">New Profile Picture</label>
        <input
            type="file"
            id="avatar"
            name="avatar"
            accept=".jpg,.jpeg,.png,image/jpeg,image/png"
        >
        <small>JPG or PNG only. Maximum size: 2 MB.</small>
    </div>

    <button type="submit">Update User</button>
    <a href="<?= site_url('users') ?>">Cancel</a>
</form>

</body>
</html>