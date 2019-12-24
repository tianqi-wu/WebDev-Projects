<!DOCTYPE html>
<html>
    <head style = "text-align : CENTER">
       <title>News-sharing Site Ver 0.0.1: action!</title> 
       <link rel="stylesheet" href="csstemp.css" />
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
    /* As it is definitely registered, we don't have to do the same thing. */
    session_start();
    if(!hash_equals($_SESSION['token'], $_POST['token'])){
        die("Request forgery detected");
    }
    if((!isset($_SESSION['username']))){
    echo "<p><strong>You are not logged in, or you are not allowed to add this.</strong></p>";
    echo "<br><a href='login.php'><input type='button'value='Login'></a>";
    }else{
$username = $_SESSION['username'];
$title = (string)$_POST['title'];
$user_id = $_SESSION['user_id'];
$contents = (string)$_POST['contents'];

require 'database.php';

$stmt = $mysqli->prepare("insert into news (news_user_id, news_topic, news_content) values (?, ?, ?)");
if(!$stmt){
	printf("Query Prep Failed: %s\n", $mysqli->error);
	exit;
}

$stmt->bind_param('iss', $user_id,$title,$contents);

$stmt->execute();

$stmt->close();

printf("<br><strong>News added!</strong><br />");

// New Deal: add link

/////////

require 'database.php';

$stmt = $mysqli->prepare("SELECT news_id from news where news_user_id = ? and news_topic = ? and news_content = ?");
if(!$stmt){
	printf("Query Prep Failed: %s\n", $mysqli->error);
	exit;
}

$stmt->bind_param('iss', $user_id,$title,$contents);

$stmt->bind_result($news_id);

$stmt->execute();

$stmt->fetch();

$stmt->close();

$link = "news_comment.php?news_user_id=$user_id&news_id=$news_id";

/////////

require 'database.php';

$stmt = $mysqli->prepare("UPDATE news SET link=? WHERE news_id=?");
if(!$stmt){
	printf("Query Prep Failed: %s\n", $mysqli->error);
	exit;
}

$stmt->bind_param('si', $link,$news_id);

$stmt->execute();

$stmt->close();

/*Need corresponding sections.*/

/* Step One: validating input. 
* Because of the Session Section, we are 100% sure that it would be passed throughout every layer.
*/

//Start



//End
    }
    
?>
<!--PHP ends here-->

<form name = "input" action = "main.php">
				<input type="submit" value="Back to the Front Page"/>
    </form>

<img src = "https://upload.kcwiki.org/commons/2/27/Soubi255HD.png" alt = "F6F-5N">
    </body>


</html>