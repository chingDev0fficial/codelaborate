<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form action="{{ route('submit.login') }}" method="POST">
        @csrf
        <div>
            <label for="email">Email:</label>
            <input type="email" name="email">
        </div>
        
        <div>
            <label for="password">Passwrod:</label>
            <input type="password" name="password">
        </div>

        <input type="submit">
    </form>
</body>
</html>