
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register Page</title>
</head>
    <body>

        <form action="controller/register.php" method="POST">
            
            <label>Register</label>

            <br>
            <label for="name">Nickname</label>
            <input id="name" type="text" name="nickname">

            <br>

            <label for="email">Email</label>
            <input id="email" type="text" name="email">

            <br>
            
            <label for="password">Password</label>
            <input id="password" type="password" name="password">

            <br>

            <input type="submit" value="Envoyer">
        </form>

    </body>
</html>
    



