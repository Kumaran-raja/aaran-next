<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @fluxAppearance


</head>
<body
    class="bg-[#FDFDFC] dark:bg-[#0a0a0a] text-[#1b1b18] flex items-center lg:justify-center min-h-screen flex-col">
<div>
    <x-Ui::menu.web.top-menu/>
    {{ $slot }}
    <x-Ui::web.home-new.footer-address/>
    <x-Ui::web.home-new.copyright/>
</div>

@fluxScripts
</body>
</html>
