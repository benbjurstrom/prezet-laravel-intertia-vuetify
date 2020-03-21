<!DOCTYPE html>
<html class="h-full bg-grey-lighter">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
    <link rel="preload" as="style" href='https://fonts.googleapis.com/css?family=Roboto:100,300,400,500,700,900|Material+Icons' onload="this.rel='stylesheet'">
    <link href="https://cdn.jsdelivr.net/npm/@mdi/font@4.x/css/materialdesignicons.min.css" rel="stylesheet">
    @if (app()->environment('local'))
      <link href="{{ mix('css/app.css') }}" rel="stylesheet">
    @else
      <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    @endif
    @routes
</head>
<body class="font-sans leading-none text-grey-darkest antialiased">

@inertia

@if (app()->environment('local'))
  <script src="{{ mix('/js/app.js') }}"></script>
@else
  <script src="{{ asset('/js/app.js') }}" defer></script>
@endif
</body>
</html>
