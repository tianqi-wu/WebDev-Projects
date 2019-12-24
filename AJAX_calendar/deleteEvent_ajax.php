<?php
    /* As it is definitely registered, we don't have to do the same thing. */
    header("Content-Type: application/json"); // Since we are sending a JSON response here (not an HTML document), set the MIME Type to application/json

//Because you are posting the data via fetch(), php has to retrieve it elsewhere.
$json_str = file_get_contents('php://input');
//This will store the data into an associative array
$json_obj = json_decode($json_str, true);




//Variables can be accessed as such:
$date = (string) trim($json_obj['date']);
$title = (string) trim($json_obj['title']);
$token = $json_obj['token'];
//Variables can be accessed as such:
        
    session_start();    


    $user_id = $_SESSION['user_id'];
    $username = $_SESSION['username'];

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




    require 'database.php';

    $stmt = $mysqli->prepare("SELECT * FROM events WHERE user_id=? AND event_date=? AND event_title=?");
    if(!$stmt){///////////////
        echo json_encode(array(
            "success" => false,
            "message" => "The query does not work."
        ));
        exit;
    }
    
    $stmt->bind_param('iss', $user_id,$date,$title);
    
    $stmt->execute();

    $stmt->bind_result($a_id, $a_date, $a_title);

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
    
 





require 'database.php';

$stmt = $mysqli->prepare("DELETE FROM events WHERE user_id=? AND event_date=? AND event_title=?");
if(!$stmt){///////////////
	echo json_encode(array(
        "success" => false,
        "message" => "The query does not work."
    ));
    exit;
}

$stmt->bind_param('iss', $user_id,$date,$title);

$stmt->execute();

$stmt->close();



echo json_encode(array(
    "success" => true
));
exit;


//End
    
    
?>