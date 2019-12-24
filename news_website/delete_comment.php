<!DOCTYPE html>
	<html>
		<head>
			<title>delete current comment:</title>
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
		<body>
            <h1>Delete current comment:</h1>
            <h4>This helps to check that you are not a robot, or some stupid hackers. </h4>

			<form action="delete_comment_1.php" method="POST">
				<input type="hidden" name="news_user_id" value="<?php echo $_GET['news_user_id']?>" />
				<input type="hidden" name="comment_id" value="<?php echo $_GET['comment_id']?>" />
				<input type="hidden" name="token" value="<?php session_start(); echo $_SESSION['token'];?>" />
				<input type="submit" value="Submit">
			</form>
		</body>
	</html>