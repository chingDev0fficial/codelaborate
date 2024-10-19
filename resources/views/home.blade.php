<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>{{ $name }}</h1>
    <img src="{{ asset('storage/' . $profile_picture) }}" alt="Profile" style="height: 100px; width:100px;">
    <form action="{{ route('logout') }}" method="POST">
        @csrf
        <button type="submit" class="btn">
            Logout
        </button>
    </form>
</body>
</html>