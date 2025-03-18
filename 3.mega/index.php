

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</head>
<body>
    <form action="insert.php" method="post">
        <label for="username">username:</label>
        <input type="text" name="username" id="username" class="form-control" placeholder="Enter username ...">
        <br>
        <label for="email">Email :</label>
        <input type="email" name="email" id="email" class="form-control" placeholder="Enter email">
        <br>
        <label for="password">Password:</label>
        <input type="password" name="password" id="password" class="form-control" placeholder="Enter password...">
        <br>
        <label for="phone">phone</label>
        <input type="text" id="phone" name="phone" class="form-control" placeholder="Enter phone ....">
        <br>
        <button type="submit" class="btn btn-dark">Save</button>

    </form>
</body>
</html>