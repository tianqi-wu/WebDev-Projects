<!DOCTYPE html>
	<html>
		<head>
			<title>delete current news:</title>
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
            <h1>Edit current comment:</h1>
            <h4>This helps to check that you are not a robot, or some stupid hackers. </h4>
            <?php

                    
                    printf("<br>");
                    echo htmlentities("The comment is:");


                    $comment_id = $_GET['comment_id'];
                    $news_user_id = $_GET['news_user_id'];
                    
                    require 'database.php';
                    
                    $stmt1 = $mysqli->prepare("select comment_content from comment where comment_id = ?");
                    if(!$stmt1){
                        printf("Query Prep Failed: %s\n", $mysqli->error);
                        exit;
                    }
                    
                    $stmt1->bind_param('i', $comment_id);
                    
                    $stmt1->bind_result($comment_content);
                    
                    $stmt1->execute();
                    //Not sure whether this would be OK
                    $stmt1->fetch();
                    
                    printf("\t%s\n",
                            htmlspecialchars($comment_content)
                        );

                        ?>

			<form action="edit_comment_1.php" method="POST">
            <input type="text" name="contents" id="contents" style="height:200px;width:420px;" maxlength="150"/>
				<input type="hidden" name="news_user_id" value="<?php echo $_GET['news_user_id']?>" />
				<input type="hidden" name="comment_id" value="<?php echo $_GET['comment_id']?>" />
				<input type="hidden" name="token" value="<?php session_start(); echo $_SESSION['token'];?>" />
				<input type="submit" value="Submit">
			</form>
		</body>
	</html>