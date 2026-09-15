<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>POS System</title>

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
    </style>
</head>
<body>

<?= view('partials/navigation') ?>

<main>
    <h1>Point-of-Sale System</h1>

    <p>Welcome to the first version of our basic POS system.</p>

    <p>
        Use the navigation menu to view customer accounts,
        user accounts, and information about the system.
    </p>
</main>

</body>
</html>