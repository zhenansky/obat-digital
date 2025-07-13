<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Aplikasi Resep Obat</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    @vite('resources/css/app.css') {{-- Tailwind CSS --}}

</head>


<body class="bg-gray-100 text-gray-900">

    <div class="container mx-auto p-6">
        @yield('content')
    </div>
    @yield('scripts')
</body>


</html>