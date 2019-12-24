<?php
// login_ajax.php

header("Content-Type: application/json"); // Since we are sending a JSON response here (not an HTML document), set the MIME Type to application/json

//Because you are posting the data via fetch(), php has to retrieve it elsewhere.
$json_str = file_get_contents('php://input');
//This will store the data into an associative array
$json_obj = json_decode($json_str, true);

//Variables can be accessed as such:
$id =  $json_obj['id'];
$date = (string) trim($json_obj['date']);
$time = (string) trim($json_obj['time']);
$title = (string)(string) trim($json_obj['title']);
$content = (string) trim($json_obj['content']);
$token = $json_obj['token'];
//([12]\d{3}-(0[1-9]|1[0-2])-(0[1-9]|[12]\d|3[01]))
// Check to see if the username and password are valid.  (You learned how to do this in Module 3.)

session_start();//Start the session

$previous_ua = @$_SESSION['useragent'];
$current_ua = $_SERVER['HTTP_USER_AGENT'];

if(isset($_SESSION['useragent']) && $previous_ua !== $current_ua){
	die("Session hijack detected");
}else{
	$_SESSION['useragent'] = $current_ua;
}

$user_id = $_SESSION['user_id'];

if((!isset($_SESSION['username']))){
    echo json_encode(array(
		"success" => false,
		"message" => "You are not logged in!"
	));
	exit;
    }

if(!hash_equals($_SESSION['token'], $token)){
    echo json_encode(array(
		"success" => false,
		"message" => "Request forgery detected!"
	));
	exit;
}

if($title==""||$date=="0000-00-00"||$time=="00:00"){
	echo json_encode(array(
		"success" => false,
		"message" => "Don't enter anything null here!"
	));
	exit;
}








require 'database.php';

$stmt = $mysqli->prepare("SELECT * FROM events WHERE user_id=? AND event_id=?");
if(!$stmt){///////////////
    echo json_encode(array(
        "success" => false,
        "message" => "The query does not work."
    ));
    exit;
}

$stmt->bind_param('ii', $user_id,$id );

$stmt->execute();

$stmt->bind_result($a_id, $a_user_id);

$count = 0;

while($stmt->fetch()){
    $count++;
}
if($count==0){
    echo json_encode(array(
        "success" => false,
        "message" => "It does not work..."
    ));
    exit;
}

$stmt->close();










if(isset($id)&&isset($date)&&isset($time)&&isset($title)&&isset($content)){

require 'database.php';



    $stmt = $mysqli->prepare("UPDATE events SET event_date=?, event_time=?, event_title=?, event_content=? WHERE event_id=? and user_id=?");
    if(!$stmt){
    echo json_encode(array(
		"success" => false,
		"message" => "Query Prep Failed."
	));
	exit;
    }
    $stmt->bind_param('ssssii',  $date, $time, $title, $content, $id,$user_id);

    $stmt->execute();

    $stmt->close();



	echo json_encode(array(
		"success" => true
	));
	exit;
}else{
	echo json_encode(array(
		"success" => false,
		"message" => "Invalid entries!"
	));
	exit;
}
?>