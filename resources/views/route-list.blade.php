<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des Routes</title>
</head>
<body>
    <h1>Liste des Routes</h1>
    <ul>
        @foreach($routes as $route)
            <li>{{ $route->uri() }} - {{ implode(', ', $route->methods()) }}</li>
        @endforeach
    </ul>
</body>
</html>
