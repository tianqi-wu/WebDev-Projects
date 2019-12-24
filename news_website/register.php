<!DOCTYPE HTML>
<html lang = 'en'>
<head>
    <link rel="stylesheet" href="csstemp.css" />
    <title>Registration page</title>
</head>
<body>
<form action="register_1.php" method="POST">
        <p>
            <label for="username">Enter your Name:</label>
            <input type="text" name="username" id="username" />
            <label for="password">Enter your password:</label>
            <input type="text" name="password" id="password" />
            <label for="password">Confirm:</label>
            <input type="text" name="confirm" id="confirm" />
        </p>
        <p>
            <input type="submit" value="Send" />
            <input type="reset" />
        </p>
    </form>

    <form name = "input" action = "main.php">
				<input type="submit" value="Back to the Front Page"/>
    </form>

    <img src = "https://upload.kcwiki.org/commons/2/27/Soubi255HD.png" alt = "F6F-5N">
    </body>
</html>