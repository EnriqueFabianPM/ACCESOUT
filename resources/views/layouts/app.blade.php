<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title', 'Default Title') - SAIIUT</title>
    <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <!-- Custom Styles -->
    <style>
        body {
            background-color: #25b725; /* Main body background color */
        }
        .container {
            background-color: #ffffff; /* Container background color */
            border-radius: 10px;
            margin-top: 50px; /* Adjust top margin for spacing */
        }
        /* Add your custom styles here */
    </style>
    @stack('styles') <!-- For additional page-specific styles -->
</head>
<body>
    <header>
        <!-- Include navigation if needed -->
    </header>
    <div class="container">
        @yield('content')
    </div>
    <footer>
        <!-- Include footer content if needed -->
    </footer>
    <!-- Bootstrap Bundle (JS included) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-+lK3I/nv9BaN7jOSp+1JfLLv9x9fq+KRQxkWhOqJ4MzFQcPVi5AqFQ1N8x6jI5Wk" crossorigin="anonymous"></script>
    @stack('scripts') <!-- For additional page-specific scripts -->
</body>
</html>