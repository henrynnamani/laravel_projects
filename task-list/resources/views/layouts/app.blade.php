<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @yield('styles')
    <title>Task List Application</title>
</head>

<body>
    <h1>@yield('title')</h1>
    @if (session()->has('success'))
        <p>{{ session('success') }}</p>
    @endif
    <div>
        @yield('content')
    </div>
</body>

</html>