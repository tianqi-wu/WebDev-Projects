<!DOCTYPE HTML>
<html lang = 'en'>
<head>
    <link rel="stylesheet" href="csstemp.css" />
    <title>Registeration page</title>
</head>
<body>
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
	echo "Invalid name!";
	exit;
}

if( !preg_match('/^[\w_\.\-]+$/', $pass) ){
	echo "Invalid name!";
	exit;
}


//connecting to mySQL && checking:

if(isset($_POST['username'])&&isset($_POST['password'])){
require 'database.php';

$username = (string) trim($_POST['username']);
$password = (string) trim($_POST['password']);
$confirm = (string) trim($_POST['confirm']);

if(!hash_equals($password, $confirm)){
    printf("<h3><strong>Password does not match the confirmation!</strong></h3>");
    echo("<br>");
    echo "<a href='register.html'><input type='button'value='Go back to registration'></a>";
    exit;
}

$hashed_password = password_hash($password, PASSWORD_BCRYPT);
//Not sure whether this would work. 
$stmt = $mysqli->prepare("insert into users (user_name, user_password) values (?, ?)");
if(!$stmt){
	printf("Query Prep Failed: %s\n", $mysqli->error);
	exit;
}
//From stackoverflow. https://stackoverflow.com/questions/9599163/how-to-prevent-duplicate-usernames-in-php-mysql
/*
$dup = mysql_query("SELECT username FROM users WHERE username='".$_POST['username']."'");
if(mysql_num_rows($dup) >0){
    echo '<b>username Already Used.</b>';
    exit;
}
*/
//From stackoverflow.
$stmt->bind_param('ss', $username, $hashed_password);

$stmt->execute();

$stmt->close();

echo htmlentities("Registration successful!");

}//I don't think any else cases should exist here.s
?>


<form name = "input" action = "main.php">
				<input type="submit" value="Back to the Front Page"/>
    </form>
    
    <img src = "https://upload.kcwiki.org/commons/2/27/Soubi255HD.png" alt = "F6F-5N">
    </body>
</html>
