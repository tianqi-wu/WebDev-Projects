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
$name = $_SESSION['username'];
$username = $_SESSION['username'];
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

//Start
if($action=="view"){
    header("Location: view.php");    
    
    }elseif($action=="upload"){
    
        header("Location: upload.php");    
    
    
    }elseif($action=="delete"){
    
        header("Location: delete.php");    
    
    }elseif($action=="download"){
    
        header("Location: download.php");    
    
    }else{
    printf("Sorry, but you are supposed to choose sth.");
    echo '<a href="sharing_site.html">Click here to go back</a>';
        exit;
    }



//End
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