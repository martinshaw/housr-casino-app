<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <meta name="csrf-token" content="{{ csrf_token() }}">

        <meta name="description" content="Why find your ideal student rental when you can spend your rent on our fair and easy Slots?">
        <meta name="keywords" content="student rentals, student housing, student accommodation, casino, slots, slot machine, fair">
        <meta name="author" content="Housr">

        <link rel="icon" href="{{ asset('icons/favicon.ico') }}" type="image/x-icon" />
        <link rel="apple-touch-icon" href="{{ asset('icons/icon.png') }}">
        <link rel="mask-icon" href="{{ asset('icons/icon.png') }}" color="#5bbad5">


        <title>{{ $title ?? 'Housr Casino App' }}</title>

        @livewireStyles
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body>
        {{ $slot }}
        
        @livewireScripts
    </body>
</html>
