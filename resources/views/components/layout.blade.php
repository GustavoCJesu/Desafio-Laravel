<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    @vite('resources/css/app.css')
    <!-- Development version -->
    <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.js"></script>
    <!-- Production version -->
    <script src="https://unpkg.com/lucide@latest"></script>
</head>

<body class="flex flex-col min-h-screen">
    {{ $slot }}
    <script>
        lucide.createIcons();
    </script>
</body>

</html>
