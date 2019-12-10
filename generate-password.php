<?php 

function random_password($length) {
	$chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
	$password = substr( str_shuffle( $chars ), 0, $length);
	return $password;
}

//Email Validation 
function sanitize_my_email($field) {
	$field = filter_var($field, FILTER_SANITIZE_EMAIL);
	if (filter_var($field, FILTER_VALIDATE_EMAIL)) {
		return true;
	} else {
		return false;
	}
}


//Login Credentials generate

if(isset($_GET["sr_id"])){
	$investor_id = $_GET["sr_id"];
	$investor_type = $_GET["i_type"];
	$name =  $_GET["name"];
  
  
    //Send to User Email -->
	$user_id = $_GET["user_id"];
	$password  = trim(random_password(12));
	$hashed_pass = hash('sha512',$password);

  //Send mail to user 
	$to = $_GET["to"];
	$subject = 'Login Credentials';
	$message = 'Dear Investor '.$name.', We are happy to inform you,Your  Login Credentials has been Created.Your User ID : '.$user_id.' and Password is : '.$password.' Thank You !!';
	$headers = 'From: test@chandra.com';
	mail($to,$subject,$message,'From: test@chlorusbusiness.com');



	$date = date("Y-m-d");
	include("connection.php");

	$q1 = "INSERT INTO login_credential(
	investor_id,user_id,password,name,i_type,login_created_at)VALUES('$id','$user_id','$hashed_pass','$name','$i_type','$date')";

	$insert = mysqli_query($conn, $q1);
	if($insert){
		$q1 = "UPDATE a_sales_representative SET 
		approval_status = 'approved' WHERE sales_rep_id= '".$id."' ";
    
		$update = mysqli_query($conn, $q1);
		if($update){
			header("location: users.php");
			exit();
		}else {
			echo "Error:" . mysqli_error($conn);
		}
	}

}

?>
