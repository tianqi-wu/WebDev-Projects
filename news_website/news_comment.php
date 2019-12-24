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
        Andy's news sharing site Ver.0.0.1--Comments!
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
    printf("Hello, %s",htmlentities($username));
    echo "<a href='logout.php'><input type='button'value='Logout'></a>";
    echo "<a href='main.php'><input type='button'value='Go back to the main page'></a>";
}

//This part is for enumerating the database.
//I would not do this until I finish the login page.

printf("<br><strong>The following are the comments presented with the news</strong>");

printf("<br>");

echo htmlentities("The news is:");


$news_id = $_GET['news_id'];
$news_user_id = $_GET['news_user_id'];

require 'database.php';

$stmt1 = $mysqli->prepare("select news_topic, news_content from news where news_id = ?");
if(!$stmt1){
	printf("Query Prep Failed: %s\n", $mysqli->error);
	exit;
}

$stmt1->bind_param('i', $news_id);

$stmt1->bind_result($news_topic, $news_content);

$stmt1->execute();
//Not sure whether this would be OK
$stmt1->fetch();

printf("\t<br><strong>%s</strong> <br> %s\n",
		htmlspecialchars($news_topic),
		htmlspecialchars($news_content)
    );

    mysql_close();

    //mysql_free_result();
    require 'database.php';

    $news_id = $_GET['news_id'];

$stmt = $mysqli->prepare("select comment_id, user_id, comment_content from comment where news_id = ?");
if(!$stmt){
	printf("Query Prep Failed: %s\n", $mysqli->error);
	exit;
}

$stmt->bind_param('i', $news_id);

$stmt->bind_result($comment_id, $user_id, $comment_content);

$stmt->execute();

printf("<br><strong>The following are the comments presented with the news</strong>");

printf("<br>");

echo "<a href='add_comment.php?news_user_id=$news_user_id&news_id=$news_id'><input type='button'value='add new comments'></a>";


while($stmt->fetch()){
    echo "<br>";
	printf("\t%s\n",
		htmlspecialchars($comment_content)
    );
    printf("<br> comment by %s<br/>",htmlspecialchars($username));

    echo "<a href='edit_comment.php?news_user_id=$news_user_id&comment_id=$comment_id'><input type='button'value='edit this comment'></a>";
    echo "<a href='delete_comment.php?news_user_id=$news_user_id&comment_id=$comment_id'><input type='button'value='delete this comment'></a>";
}



?>





<br>
            <img src = "https://upload.kcwiki.org/commons/2/27/Soubi255HD.png" alt = "F6F-5N">
            <br/>
</body>

</html>

