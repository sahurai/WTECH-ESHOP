<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1.0"/>
  <title>@yield('title','Owl Shop')</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="{{ asset('styles.css') }}" />
</head>
<body class="bg-white-2">
@include('partials.header')

@yield('content')

</body>
</html>