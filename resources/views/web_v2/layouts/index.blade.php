<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title')</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">

    <!-- Material-UI Icons CSS via CDN -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <!-- Include Alpine.js via CDN -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    {{-- Swiper --}}
    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css" />
    <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
    <style>
        @media screen and (max-width:640px) {
            .container {
                width: 100%;
                padding-left: 16px;
                padding-right: 16px;
            }
        }

        h1,
        h2,
        h3,
        h4,
        h5,
        h6,
        p,
        li,
        a,
        div {
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
    </style>
</head>

<body>
    @yield('content')

    <script>
        // Function to merge and update query parameters
        function updateQueryParams(formId) {
            console.log(formId)
            const form = document.getElementById(formId);
            const formData = new FormData(form);
            const formParams = new URLSearchParams(formData);

            // Get the existing query parameters
            const existingParams = new URLSearchParams(window.location.search);

            // Merge the existing query parameters with the new form data
            for (const [key, value] of formParams.entries()) {
                existingParams.set(key, value);
            }

            // Redirect to the updated URL with merged query parameters
            window.location.href = '/classes?' + existingParams.toString();
        }

        // Event listener for filter form submission
        document.getElementById('filterForm').addEventListener('submit', function(event) {
            event.preventDefault(); // Prevent default form submission
            updateQueryParams('filterForm');
        });
        // Event listener for search form submission
        document.getElementById('searchForm').addEventListener('submit', function(event) {
            event.preventDefault(); // Prevent default form submission
            updateQueryParams('searchForm');
        });
    </script>
</body>

</html>
