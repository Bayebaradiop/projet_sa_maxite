<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Maxitsa Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap');

        body {
            font-family: 'Inter', sans-serif;
        }
    </style>
</head>

<body class="bg-gray-100 flex h-screen">

    <?php require_once __DIR__ . '/../../Template/layout/partial/header.html.php'; ?>


    <main class="flex-1 overflow-y-auto p-6 bg-gray-100">

        <?php echo $contentForLayout; ?>

    </main>

</body>

</html>