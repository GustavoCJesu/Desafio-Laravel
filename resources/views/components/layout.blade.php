<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>EPI CONTROL</title>
    @vite('resources/css/app.css')
</head>

<body class="bg-[#CBDDFF] relative flex flex-col gap-4 min-h-screen max-h-screen">

    @auth
        <header>
            <x-menu />
            <x-header />
        </header>
    @endauth

    <main class="flex flex-col gap-2 bg-white rounded flex-1">
        {{ $slot }}
    </main>
    @auth
        <footer>
        </footer>
    @endauth

</body>

</html>

<script>
    const close_btn_menu = document.getElementById('close_menu_btn')
    const menu = document.getElementById('menu')
    const open_btn_menu = document.getElementById('open-menu-btn')

    close_btn_menu.addEventListener('click', () => {
        menu.classList.toggle('opened-menu')
        console.log('botão fechar')
    })

    open_btn_menu.addEventListener('click', () => {
        menu.classList.toggle('opened-menu')

    })
</script>
