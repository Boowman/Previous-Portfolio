<?php
	include "connect.php";
	
	echo "<h2>Create Your Databases.</h2>";	
	
	if(isset($_POST['home_btn'])){
			$sql ="CREATE TABLE ".$_POST['table1']." (";
			$sql .= "ID INT NOT NULL AUTO_INCREMENT PRIMARY KEY, ";
			$sql .= "Title VARCHAR(30) NOT NULL,";
			$sql .= "Image VARCHAR(200) NOT NULL,";
			$sql .= "Date VARCHAR(25) NOT NULL,";
			$sql .= "Description VARCHAR(500) NOT NULL ";
			$sql .= ")";
	
		if(empty($_POST['table1'])){
			echo 'Home table field is empty, please enter a name before submiting it.';
		}else
		{
			if (mysqli_query($dbconnection,$sql))
			{
			  echo "Database ".$_POST['table1']." created successfully.<br/>";
			  echo $sql."<br/>";
			}else
			{
			  echo "Error creating database: ".$_POST['table1']."". mysqli_error($dbconnection);
			}
		}
	}
	
	if(isset($_POST['updates_btn'])){
				$sql ="CREATE TABLE ".$_POST['table2']." (";
				$sql .= "ID INT NOT NULL AUTO_INCREMENT PRIMARY KEY, ";
				$sql .= "Title VARCHAR(100) NOT NULL, ";
				$sql .= "Image VARCHAR(200) NOT NULL, ";
				$sql .= "Image2 VARCHAR(200) NOT NULL, ";
				$sql .= "Image3 VARCHAR(200) NOT NULL, ";
				$sql .= "Video VARCHAR(50) NOT NULL, ";
				$sql .= "Date VARCHAR(25) NOT NULL, ";
				$sql .= "Description VARCHAR(397) NOT NULL, ";
				$sql .= "Project_ID INT NOT NULL ";
				$sql .= ")";
		
		if(empty($_POST['table2'])){
			echo 'Projects table field is empty, please enter a name before submiting it.';
		}
		else
		{
			if (mysqli_query($dbconnection,$sql))
			{
			  echo "Database ".$_POST['table2']." created successfully.<br/>";
			  echo $sql."<br/>";
			}else
			{
			  echo "Error creating database: ".$_POST['table2']."". mysqli_error($dbconnection);
			}		
		}
	}
	
	if(isset($_POST['about_btn'])){
				$sql ="CREATE TABLE ".$_POST['table3']." (";
				$sql .= "ID INT NOT NULL AUTO_INCREMENT PRIMARY KEY, ";
				$sql .= "Description VARCHAR(1000) NOT NULL ";
				$sql .= "Image VARCHAR(100) NOT NULL ";
				$sql .= ")";
		
		if(empty($_POST['table3'])){
			echo 'About table field is empty, please enter a name before submiting it.';
		}
		else
		{
			if (mysqli_query($dbconnection,$sql))
			{
			  echo "Database ".$_POST['table3']." created successfully.<br/>";
			  echo $sql."<br/>";
			}else
			{
			  echo "Error creating database: ".$_POST['table3']."". mysqli_error($dbconnection);
			}
		}
	}
	
	if(isset($_POST['project_btn'])){
				$sql ="CREATE TABLE ".$_POST['table4']." (";
				$sql .= "ID INT NOT NULL AUTO_INCREMENT PRIMARY KEY, ";
				$sql .= "Name VARCHAR(30) NOT NULL, ";
				$sql .= "Description VARCHAR(380) NOT NULL, ";
				$sql .= "Image VARCHAR(200) NOT NULL, ";
				$sql .= "Update_ID VARCHAR(30) NOT NULL, ";
				$sql .= "Align VARCHAR(5) NOT NULL, ";
				$sql .= "ImgSize INT(1) NOT NULL, ";
				$sql .= "Date VARCHAR(25) NOT NULL";				
				$sql .= ")";
		
		if(empty($_POST['table4'])){
			echo 'Project table field is empty, please enter a name before submiting it.';
		}
		else
		{
			if (mysqli_query($dbconnection,$sql))
			{
			  echo "Database ".$_POST['table4']." created successfully.<br/>";
			  echo $sql."<br/>";
			}else
			{
			  echo "Error creating database: ".$_POST['table4']."". mysqli_error($dbconnection);
			}
		}
	}
	
	if(isset($_POST['skills_btn'])){
				$sql ="CREATE TABLE ".$_POST['table5']." (";
				$sql .= "ID INT NOT NULL AUTO_INCREMENT PRIMARY KEY, ";
				$sql .= "Skills VARCHAR(30) NOT NULL, ";
				$sql .= "Percentage INT(3) NOT NULL ";			
				$sql .= ")";
		
		if(empty($_POST['table5'])){
			echo 'Project table field is empty, please enter a name before submiting it.';
		}
		else
		{
			if (mysqli_query($dbconnection,$sql))
			{
			  echo "Database ".$_POST['table5']." created successfully.<br/>";
			  echo $sql."<br/>";
			}else
			{
			  echo "Error creating database: ".$_POST['table5']."". mysqli_error($dbconnection);
			}
		}
	}
	
	if(isset($_POST['login_btn'])){
				$sql ="CREATE TABLE ".$_POST['table6']." (";
				$sql .= "ID INT NOT NULL AUTO_INCREMENT PRIMARY KEY, ";
				$sql .= "Username VARCHAR(30) NOT NULL, ";
				$sql .= "Password VARCHAR(32) NOT NULL ";			
				$sql .= ")";
		
		if(empty($_POST['table6'])){
			echo 'Project table field is empty, please enter a name before submiting it.';
		}
		else
		{
			if (mysqli_query($dbconnection,$sql))
			{
				echo "Database ".$_POST['table5']." created successfully and values has been inserted.<br/>";
				echo $sql."<br/>";
			}
			else
			{
			  echo "Error creating database: ".$_POST['table5']."". mysqli_error($dbconnection);
			}
		}
	}
	
	if(isset($_POST['login_btnValues']))
	{
		$add_login = "INSERT INTO Login ( ";
		$add_login .= "Username, ";
		$add_login .= "Password ";
		$add_login .= ") ";

		$add_login .= "VALUES ";
		{
			$add_login .= "(";	
			$add_login .= "'$username', ";
			$add_login .= "'".md5($password)."' ";
			$add_login .= ") ";		
		}
			
		$login_added = mysqli_query($dbconnection,$add_login);
			
		if($login_added)
		{		
			echo "Values has been successfully inserted.<br/>";
			echo $add_login."<br/>";		
		}
		else
		{
			echo '<div class="message">There was a problem.</div><br/>';
			echo mysqli_error($dbconnection);
		}
	}
	
	echo '<form action="" method="post" >
			<p>Home Table:
			<input name="table1" type="text" maxlength="30">Do not use spaces.<br/></p>
			<input name="home_btn" type="submit" value="Submit">
		  </form>';
	echo '<form action="" method="post" >
			<p>Updates Table:
			<input name="table2" type="text" maxlength="30">Do not use spaces.<br/></p>
			<input name="updates_btn" type="submit" value="Submit">
		  </form>';
		  
	echo '<form action="" method="post" >
			<p>About Table:
			<input name="table3" type="text" maxlength="30">Do not use spaces.<br/></p>
			<input name="about_btn" type="submit" value="Submit">
		  </form>';
		  
	echo '<form action="" method="post" >
			<p>Project Table:
			<input name="table4" type="text" maxlength="30">Do not use spaces.<br/></p>
			<input name="project_btn" type="submit" value="Submit">
		  </form>';
		  
	echo '<form action="" method="post" >
			<p>Skills Table:
			<input name="table5" type="text" maxlength="30">Do not use spaces.<br/></p>
			<input name="skills_btn" type="submit" value="Submit">
		  </form>';
		  
	echo '<form action="" method="post" >
			<p>Login Table:
			<input name="table6" type="text" maxlength="30">Do not use spaces.<br/></p>
			<input name="login_btn" type="submit" value="Submit">
			<input name="login_btnValues" type="submit" value="Add User">
		  </form>';
		  
	echo '<a href="../database/">Go Back</a>';
	
	mysqli_close($dbconnection);

?>