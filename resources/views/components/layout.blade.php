<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>EPI CONTROL</title>
    @vite('resources/css/app.css')
</head>

<body class="bg-[#CBDDFF] relative p-3 flex flex-col gap-4 min-h-screen max-h-screen">
    <x-menu />
    <x-header />
    <main class="bg-white p-10 rounded flex-1">
        {{ $slot }}
    </main>
</body>

</html>
