<!DOCTYPE HTML>
<html lang = 'en'>
<head  style = "text-align : CENTER">
    <title> Andy's news coverage site</title>
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
    <h1>
        Andy's news sharing site Ver.0.0.1
        </h1>
<?php
/*Ordinary checking session.*/
session_start();
if(!isset($_SESSION['username'])){
echo "<p><strong>You are not logged in.</strong></p>";
echo "<a href='login.php'><input type='button'value='Login'></a>";
echo "<br><p><strong> New user? </strong></p>";
echo "<a href='register.php'><input type='button'value='Register'></a>";
}else{
    $username = $_SESSION['username'];
    $user_id = $_SESSION['user_id'];
    printf("Hello, %s. Your UID is %s",htmlentities($username),htmlentities($user_id));
    echo "<br><a href='logout.php'><input type='button'value='Logout'></a>";
    echo "<a href='add_news.php?user_id=$user_id'><input type='button'value='add some news'></a>";
    echo "<a href='select_news.php?user_id=$user_id'><input type='button'value='see your own news'></a>";
}

//This part is for enumerating the database.
//I would not do this until I finish the login page.

printf("<br><strong>The following are the news present</strong>");

require 'database.php';

$stmt = $mysqli->prepare("select news_id, news_user_id, news_topic, news_content from news");
if(!$stmt){
	printf("Query Prep Failed: %s\n", $mysqli->error);
	exit;
}

$stmt->execute();

$stmt->bind_result($news_id, $news_user_id, $news_topic, $news_content);

while($stmt->fetch()){
	printf("\t<br><strong>%s</strong> <br> %s\n",
		htmlspecialchars($news_topic),
		htmlspecialchars($news_content)
    );
    printf("<br> news by UID %s<br/>",htmlspecialchars($news_user_id));
    echo "<a href='news_comment.php?news_user_id=$news_user_id&news_id=$news_id'><input type='button'value='see the comments'></a>";
    echo "<a href='edit_news.php?news_user_id=$news_user_id&news_id=$news_id'><input type='button'value='edit this news'></a>";
    echo "<a href='delete_news.php?news_user_id=$news_user_id&news_id=$news_id'><input type='button'value='delete this news'></a>";
}



?>





<br>
            <img src = "https://upload.kcwiki.org/commons/2/27/Soubi255HD.png" alt = "F6F-5N">
            <br/>
</body>

</html>

