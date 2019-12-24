<!DOCTYPE html>
<html lang = 'en'>
	<head>
		<title>Viewing files:</title>
		<link rel="stylesheet" href="csstemp.css" />
</head>
<body>
</body>
</html>	
<?php
    /* As it is definitely registered, we don't have to do the same thing. */
session_start();
$name = $_SESSION['username'];

/// OOO Define your function here 
//////
//////
/// OOO
$action = "view";

$username = $_SESSION['username'];

$filename = $_POST['file'];

if( !preg_match('/^[\w_\.\-]+$/', $filename) ){
	echo "Invalid filename";
	exit;
}

$username = $_SESSION['username'];
if( !preg_match('/^[\w_\-]+$/', $username) ){
	echo "Invalid username";
	exit;
}


$full_path = sprintf("/home/%s/%s", $username, $filename);


if (!unlink($full_path)){
  echo htmlentities("Error! Failed to delete $filename");
}else{
  echo htmlentities("Deleted $filename");
}



//End
//End
?>
