<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Triowash Laundry</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <div class="container">

        <a class="navbar-brand fw-bold" href="/">
            Triowash Laundry
        </a>

        <button class="navbar-toggler"
                type="button"
                data-bs-toggle="collapse"
                data-bs-target="#navbarNav">

            <span class="navbar-toggler-icon"></span>

        </button>

        <div class="collapse navbar-collapse" id="navbarNav">

            <ul class="navbar-nav ms-auto">

                <li class="nav-item">
                    <a href="/" class="nav-link">
                        Home
                    </a>
                </li>

                <li class="nav-item">
                    <a href="/order" class="nav-link">
                        Pesan Laundry
                    </a>
                </li>

                <li class="nav-item">
                    <a href="/tracking" class="nav-link">
                        Tracking
                    </a>
                </li>

            </ul>

        </div>

    </div>
</nav>

<div class="container py-5">
    @yield('content')
</div>

</body>
</html>