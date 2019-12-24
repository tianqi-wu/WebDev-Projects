<!DOCTYPE html>
<html lang = 'en'>
    <head style = "text-align : CENTER">
       <title>File-sharing Site Ver 0.1: action!</title> 
       <style>
        </style>
    </head>

    <body style = "text-align : CENTER">
<!-- PHP starts here-->
            <?php
            //To prevent any stupid problems that might occur.
            ?>
<?php
    /* As it is definitely registered, we don't have to do the same thing. */
session_start();
$name = $_SESSION['name'];
$username = $_SESSION['name'];
/// OOO Define your function here 
//////
//////
/// OOO
$action = "view";


$filename = $_POST['file'];

if( !preg_match('/^[\w_\.\-]+$/', $filename) ){
	echo "Invalid filename";
	exit;
}

$username = $_SESSION['username'];
if( !preg_match('/^[\w_\-]+$/', $username) ){
	echo "Invalid username";
	exit;
}

/*Need corresponding sections.*/
if(isset($action)){
	printf("<p><strong>%s for User %s:</strong></p>\n",
        htmlentities($_POST['perform']),
        htmlentities($name)
    );
}
/* Step One: validating input. 
* Because of the Session Section, we are 100% sure that it would be passed throughout every layer.
*/

//Start


//End
?>
<!--PHP ends here-->

<!--
/// OOO Define your function here 
//////
//////
/// OOO
-->

<form action="view_1.php" method="POST">

<p>
		<label for="file">File Name:</label>
		<input type="text" name="file" id="file" />
</p>

</form>

<br>
<a href = "sharing_site.html">Back to the main page</a>
<br>


<form name = "input" action = "logout.php" method = "POST">
        <input type="submit" value="Log Out"/>
<br>
</form>
<img src = "https://upload.kcwiki.org/commons/2/27/Soubi255HD.png" alt = "F6F-5N">
    </body>


</html>