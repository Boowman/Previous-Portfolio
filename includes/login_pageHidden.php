<?php
	session_start();
	include "connect.php";
	
	$loginUsername = $_POST['username'];
	$loginPassword = md5($_POST['password']);
	$loginSubmit = $_POST['submitBTN'];
	$logoutBTN = $_POST['logoutBTN'];
	
	$query = "SELECT * FROM Login WHERE Username = '$loginUsername'";
	$quety_result = mysqli_query($dbconnection,$query);			

	while($row = mysqli_fetch_array($quety_result))
	{	
		$rowUsername = $row['Username'];
		$rowPassword = $row['Password'];
	}

	if(isset($loginSubmit))
	{
		if(isset($loginUsername) == $rowUsername && $loginPassword == $rowPassword)
		{
			$_SESSION['accountVerified'] = 1;
		}
	}
	
	if(isset($logoutBTN))
	{
		$_SESSION['accountVerified'] = 0;
	}	
?>
    <form action="" method="post">
    Username:<br>
    <input type="text" name="username" value="">
    <br>
    Password:<br>
    <input type="password" name="password" value="">
    <br><br>
    <input type="submit" name="submitBTN" value="Submit">
    <input type="submit" name="logoutBTN" value="LogOut">
    </form> 