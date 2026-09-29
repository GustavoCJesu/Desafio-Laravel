@props(['title' => null])

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $title ? $title.' · ' : '' }}Gestão de Funcionários</title>
    <script src="https://unpkg.com/lucide@latest"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body {{ $attributes->merge(['class' => 'flex flex-col min-h-screen relative']) }}>
    <x-ui.toast />
    {{ $slot }}
</body>

</html>
