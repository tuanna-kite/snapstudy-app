<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="/css/app.css">
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Material-UI Icons CSS via CDN -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">

    <!-- Include Alpine.js via CDN -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    {{-- Swiper --}}
    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css"/>
    <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
    <title>Reading Document</title>
    <style>
        h1, h2, h3, h4, h5, h6, p, li, a, div {
            font-family: "Inter Tight", sans-serif !important;
        }

        .table_contents h2 {
            display: none;
        }

        .table_contents ul li {
            color: #032482;
        }

        .table_contents ul li ul li {
            padding-left: 20px;
        }

        #document-content ul {
            padding-inline-start: 24px !important;
            list-style: square !important;
        }
        #document-content ul li {
            margin: 0 !important;
        }

        #document-content table {
            display: block;
            overflow: auto;
            white-space: nowrap;
        }


        .container {
            width: 100%;
            padding-left: 16px;
            padding-right: 16px;
        }
    </style>
</head>
<body>
<div>
    {{-- Header --}}
    <x-layouts.navbar/>

    <div class="bg-primary.lighter">
        {{ $slot }}
    </div>
    {{-- Footer --}}
    {{--    <x-layouts.footer/>--}}
</div>
</body>
</html>
