<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Obat Digital</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @vite('resources/css/app.css') {{-- Tailwind CSS --}}

</head>


<body class="bg-gray-100 text-gray-900">

    <div class="container mx-auto p-6">
        @yield('content')
    </div>
    @yield('scripts')
</body>


</html>