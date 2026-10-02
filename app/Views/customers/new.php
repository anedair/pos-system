<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Customer</title>
</head>
<body>

<?= view('partials/navigation') ?>

<h1>Add New Customer</h1>

<?php if ($errors = session()->getFlashdata('errors')): ?>
    <div style="color: red;">
        <ul>
            <?php foreach ($errors as $error): ?>
                <li><?= esc($error) ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>

<form action="<?= site_url('customers') ?>" method="post">
    <?= csrf_field() ?>

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

    <div>
        <label for="email">Email *</label>
        <input
            type="email"
            id="email"
            name="email"
            maxlength="100"
            value="<?= esc(old('email')) ?>"
            required
        >
    </div>

    <div>
        <label for="phone">Phone</label>
        <input
            type="text"
            id="phone"
            name="phone"
            maxlength="20"
            value="<?= esc(old('phone')) ?>"
        >
    </div>

    <button type="submit">Save Customer</button>
    <a href="<?= site_url('customers') ?>">Cancel</a>
</form>

</body>
</html>