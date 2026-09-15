<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About | POS System</title>

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
    <h1>About the POS System</h1>

    <p>
        This website is the first version of a basic Point-of-Sale
        system created with CodeIgniter 4.
    </p>

    <p>
        It demonstrates routes, controllers, views, static PHP arrays,
        and foreach loops. A database is not used in this version.
    </p>
</main>

</body>
</html>