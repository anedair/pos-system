<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Accounts | POS System</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 40px;
            background: #f4f4f4;
        }

        nav {
            padding: 15px;
            background: #333;
        }

        nav a {
            color: white;
            margin-right: 20px;
            text-decoration: none;
        }

        main {
            background: white;
            padding: 30px;
            margin-top: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            padding: 12px;
            border: 1px solid #cccccc;
            text-align: left;
        }

        th {
            color: white;
            background: #333;
        }

        tr:nth-child(even) {
            background: #eeeeee;
        }
    </style>
</head>
<body>

<?= view('partials/navigation') ?>

<main>
<h1>User Accounts</h1>

<h1>User Accounts</h1>

<?php if ($success = session()->getFlashdata('success')): ?>
    <p style="color: green;"><?= esc($success) ?></p>
<?php endif; ?>

<p>
    <a href="<?= site_url('users/new') ?>">Add New User</a>
</p>

<table>
    <thead>
        <tr>
            <th>Avatar</th>
            <th>Username</th>
            <th>Full Name</th>
            <th>Actions</th>
        </tr>
    </thead>

    <tbody>
        <?php foreach ($users as $user): ?>
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

            <tr>
                <td>
                    <img
                        src="<?= esc($avatarUrl) ?>"
                        alt="<?= esc($user['full_name']) ?> avatar"
                        width="60"
                        height="60"
                        style="
                            object-fit: cover;
                            border-radius: 50%;
                        "
                    >
                </td>

                <td><?= esc($user['username']) ?></td>
                <td><?= esc($user['full_name']) ?></td>

                <td>
                    <a href="<?= site_url(
                        'users/' . $user['id'] . '/edit'
                    ) ?>">
                        Edit
                    </a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
</main>

</body>
</html>