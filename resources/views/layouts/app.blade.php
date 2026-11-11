<!DOCTYPE html>
<html lang="vi" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" type="image/svg+xml" href="/logo/planin-logo-board-transparent.svg">
    <title>@yield('title', 'Planin - Quản lý công việc & Kế hoạch trực quan')</title>
    
    <!-- Google Font: Roboto -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700;900&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css'])
</head>
<body class="bg-white text-[#091E42] antialiased selection:bg-[#AA6ADA]/20 selection:text-[#AA6ADA] font-sans">
    @yield('content')
</body>
</html>

