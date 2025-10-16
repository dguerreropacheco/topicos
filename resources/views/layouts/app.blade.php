<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <title>@yield('title','RSU - Vehículos')</title>
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
  <div class="container">
    <a class="navbar-brand" href="{{ route('vehicles.index') }}">RSU Reciclaje</a>
  </div>
</nav>
<div class="container">
  @if(session('ok')) <div class="alert alert-success">{{ session('ok') }}</div> @endif
  @yield('content')
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
@stack('scripts')
</body>
</html>
