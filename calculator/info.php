<!DOCTYPE html>
<head><title>The result of Andy's calculator</title></head>
<body>
<?php
$first = (float)$_POST['firstnumber'];
$last = (float)$_POST['lastnumber'];
$perform = $_POST['perform'];
$result = 0.0;

if($last==0 && $perform==="division"){
	echo "The divisor should not be zero";

}
else{
 $result = 0.0;
 $flag = 0;
        if($perform=="addition"){
                $result = $first + $last;
        }elseif($perform=="substraction"){
                $result = $first - $last;
        }elseif($perform=="multiplication"){
                $result = $first * $last;
        }elseif($perform=="division"){
                $result = $first / $last;
        }else{
        printf("Sorry, but you are supposed to choose sth on the radio button.");
        $flag = 1;
        }
        if($flag==0){
        printf("Hello there!  The first number is %f, and the second number is %f. The result is %f. \n",
        htmlentities($first),
        htmlentities($last),
	htmlentities($result)
	);
}
}
?>
</body>
</html>