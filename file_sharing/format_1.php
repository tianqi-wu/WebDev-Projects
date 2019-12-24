<!DOCTYPE html>
<html lang = 'en'>
    <head style = "text-align : CENTER">
    <link rel="stylesheet" href="csstemp.css" />
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

/// OOO Define your function here 
//////
//////
/// OOO
$action = "view";

$username = $_SESSION['name'];

$filename = $_POST['file'];

if( !preg_match('/^[\w_\.\-]+$/', $filename) ){
	echo "Invalid filename";
	exit;
}

$username = $_SESSION['name'];
if( !preg_match('/^[\w_\-]+$/', $username) ){
	echo "Invalid username";
	exit;
}


$full_path = sprintf("/home/%s/%s", $username, $filename);

// Now we need to get the MIME type (e.g., image/jpeg).  PHP provides a neat little interface to do this called finfo.
$finfo = new finfo(FILEINFO_MIME_TYPE);
//$mime = $finfo->file($full_path);
$mime = mime_content_type($full_path);
// Finally, set the Content-Type header to the MIME type of the file, and display the file.
header("Content-Type: ".$mime);
readfile($full_path);


//End
//End
?>
<!--PHP ends here-->

<!--
/// OOO Define your function here 
//////
//////
/// OOO
-->


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