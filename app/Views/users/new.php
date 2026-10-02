<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add User</title>
</head>
<body>

<?= view('partials/navigation') ?>

<h1>Add New User</h1>

<?php if ($errors = session()->getFlashdata('errors')): ?>
    <div style="color: red;">
        <ul>
            <?php foreach ($errors as $error): ?>
                <li><?= esc($error) ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>

<form action="<?= site_url('users') ?>" method="post">
    <?= csrf_field() ?>

    <div>
        <label for="username">Username *</label>
        <input
            type="text"
            id="username"
            name="username"
            maxlength="50"
            value="<?= esc(old('username')) ?>"
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
            value="<?= esc(old('full_name')) ?>"
            required
        >
    </div>

    <button type="submit">Save User</button>
    <a href="<?= site_url('users') ?>">Cancel</a>
</form>

</body>
</html>