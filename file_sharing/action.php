<!DOCTYPE html>
<html lang = 'en'>
    <head style = "text-align : CENTER">
       <title>File-sharing Site Ver 0.1: action!</title> 
       <style>
            body{
                width: 760px; /* how wide to make your web page */
                background-color:rgb(253, 196, 196); /* what color to make the background */
                margin: 0 auto;
                font:12px/16px Verdana, sans-serif; /* default font */
            }
            div#main{
                background-color: #FFF;
                margin: 0;
                padding: 10px;
            }
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
$action = $_POST['perform'];
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


if($action=="view"){



$full_path = sprintf("/home/%s/%s", $username, $filename);

// Now we need to get the MIME type (e.g., image/jpeg).  PHP provides a neat little interface to do this called finfo.
$finfo = new finfo(FILEINFO_MIME_TYPE);
$mime = $finfo->file($full_path);

// Finally, set the Content-Type header to the MIME type of the file, and display the file.
header("Content-Type: ".$mime);
readfile($full_path);




}elseif($action=="upload"){




}elseif($action=="delete"){



}else{
printf("Sorry, but you are supposed to choose sth.");
echo '<a href="sharing_site.html">Click here to go back</a>';
    exit;
}



/* Unfinished */


/* Unfinished */




?>
<!--PHP ends here-->
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