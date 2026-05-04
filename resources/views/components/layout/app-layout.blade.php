<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>{{ $title ?? 'TaskManager' }}</title>
    {{-- Com Vite: @vite(['resources/css/app.css', 'resources/js/app.js']) --}}
    <link rel="stylesheet" href="{{ asset('css/app.css') }}" />
</head>
<body>

<div id="toast"></div>

{{ $slot }}

<script src="{{ asset('js/app.js') }}"></script>
</body>
</html>
