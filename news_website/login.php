<!DOCTYPE HTML>
<html lang = 'en'>
<head>
    <link rel="stylesheet" href="csstemp.css" />
    <title>Login page</title>
</head>
<body>
<form action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method="POST">
        <p>
            <label for="username">Enter your Name:</label>
            <input type="text" name="username" id="username" />
            <label for="password">Enter your password:</label>
            <input type="password" name="password" id="password" />
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

<?php
/* This thing supports the login page.
By any means, it should check whether it's valid.

*/
//Unfinished here
/*Has to check whether it's in the table
 * Then give the correct operations here.
 * If in the table, turn to the next page;
 * If not in the table, ask for signing-up.
 */

$name = $_POST['username'];
$pass = $_POST['password'];
//sanity check
if( !preg_match('/^[\w_\.\-]+$/', $name) ){
	echo "Please enter something reasonable above.";
	exit;
}

if( !preg_match('/^[\w_\.\-]+$/', $pass) ){
	echo "Please enter something reasonable above.";
	exit;
}

//connecting to mySQL && checking:

if(isset($_POST['username'])&&isset($_POST['password'])){
    $username = (string) trim($_POST['username']);
    $password = (string) trim($_POST['password']);


require 'database.php';

$stmt = $mysqli->prepare("select user_id, user_password FROM users WHERE user_name=?");
if(!$stmt){
	printf("Query Prep Failed: %s\n", $mysqli->error);
	exit;
}

$stmt->bind_param('s', $username);

$stmt->execute();

$stmt->bind_result($user_id, $pwd_hash);

$stmt->fetch();

$pwd_guess = (string) trim($_POST['password']);
// Compare the submitted password to the actual password hash

if(password_verify($pwd_guess, $pwd_hash)){
    // Login succeeded!
    session_start();
    $_SESSION['user_id'] = $user_id;
    $_SESSION['username'] = $username;
    $_SESSION['token'] = bin2hex(random_bytes(32));

    // Redirect to your target page
    header("Location: main.php");
} else{
    // Login failed; redirect back to the login screen
    echo "Login failed!";
}
//Not sure whether we have to keep this
//$stmt->close();

}//I don't think any else cases should exist here.s
?>