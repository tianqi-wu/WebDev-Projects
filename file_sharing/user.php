<!DOCTYPE html>
<html lang = 'en'>
<head style = "text-align : CENTER">
<link rel="stylesheet" href="csstemp.css" />
<title>Person Information</title>
<style>

</style>
</head>
<body style = "text-align : CENTER;font-size:16px">


<?php
/* Session I variables */
$h = fopen("/home/user_mgr/users.txt", "r");
$flag = 0;
$linenum = 1;
$name = (string) trim($_POST['username']);
$dir = sprintf('/home/%s', $name);
/* Session II variables */
$password = (string) trim($_POST['password']);

//Password: WUSTL

if($password!="WUSTL"){
    echo "Incorrect username or password! Please go back to the mainpage!\n";
    echo '<a href="sharing_site.html">Click here</a>';
        exit;
}

if( !preg_match('/^[\w_\-]+$/', $name) ){
    echo "Invalid username! Please go back to the mainpage!\n";
    echo '<a href="sharing_site.html">Click here</a>';
        exit;
}
/* Start real functions */
echo "<ul>\n";
while( !feof($h) ){
        if(trim(fgets($h))==$name){
        $flag = 1;
         session_start();
            $_SESSION['username'] = $name;
    }

		$linenum++;

}
echo "</ul>\n";

fclose($h);
if($flag == 1){
/* Second part:greetings */
    echo "<strong>";
    printf("<p>Hello, %s!",
	htmlentities($name)
);
echo "</strong>";


printf("All files are shown below:(if there are any)");
// Reference:https://stackoverflow.com/questions/2922954/getting-the-names-of-all-files-in-a-directory-with-php 
echo "<br>\n";
printf("\n");

if (is_dir($dir)) {
    foreach (glob($dir . '/*.*') as $file) {
        $filename = trim($file, $dir);
        printf("%s\n",$filename);
        echo "<br>\n";
        //This \n does not work for printf. But it works pretty well for <br>.
    }
}else{
    /*header("Location: error.html");*/
    echo "Invalid username! Please go back to the mainpage!";
    echo '<a href="sharing_site.html">Click here</a>';
    exit;   // we call exit here so that the script will stop executing before the connection is broken
}
}else{
    /*header("Location: error.html");*/
    echo "Invalid username! Please go back to the mainpage!";
    echo '<a href="sharing_site.html">Click here</a>';
    exit;   // we call exit here so that the script will stop executing before the connection is broken
}
?>
<br>
<br>
<!-- Test -->
<form action="actions.php" method="POST">
    <h3>
        <strong>What to perform next on your files:</strong>
    </h3>
        <br>
        <br>


        <!--
        <p>
		<label for="file">File Name:</label>
		<input type="text" name="file" id="file" />
        </p>
        -->

        
		<input type="radio" name="perform" value="view" id="view" /> <label for="view">view</label> &nbsp;
        <input type="radio" name="perform" value="upload" id="upload" /> <label for="upload">upload</label> &nbsp;
        <input type="radio" name="perform" value="delete" id="delete" /> <label for="delete">delete</label> &nbsp;
        <input type="radio" name="perform" value="download" id="download" /> <label for="download">download</label> &nbsp;


<p>
		<input type="submit" value="Send" />
		<input type="reset" />
</p>



</form>
<a href = "sharing_site.html">Back to the main page</a>
<br>
<form name = "input" action = "logout.php" method = "POST">
        <input type="submit" value="Log Out"/>
</form>
<br>
<img src = "https://upload.kcwiki.org/commons/2/27/Soubi255HD.png" alt = "F6F-5N">



<!-- Test -->





</body>
</html>
