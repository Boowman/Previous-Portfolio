<?php

$post_btn = $_POST["add_post"];
			
$desc = $_POST['description'];
$tit = $_POST['title'];
$img = $_POST['image'];
	
if(isset($post_btn))
{
	if($_POST['title'] and $_POST['image'] and $_POST['description'] and $_POST['date'])
	{
		$description = mysqli_real_escape_string($dbconnection,$desc);
		$title = mysqli_real_escape_string($dbconnection,$tit);
		$image = mysqli_real_escape_string($dbconnection,$img);
		
		$add_post = "INSERT INTO Home ( ";
		$add_post .= "Title, ";
		$add_post .= "Image, ";
		$add_post .= "Date, ";
		$add_post .= "Description ";
		$add_post .= ") ";
	
		$add_post .= "VALUES ";
		{
			$add_post .= "(";	
			$add_post .= "'$title', ";
			$add_post .= "'$image', ";
			$add_post .= "'$_POST[date]', ";
			$add_post .= "'$description' ";
			$add_post .= ") ";		
		}
		if(mysqli_query($dbconnection,$add_post))
		{
			echo '<div class="message">Record with Title: "'.$_POST['title'].'" has been added.</div>';
			echo header("refresh:1; url=index.php");
		}else
		{
			echo '<div class="message">There is a problem.</div><br/>';
			echo mysqli_error($dbconnection);
		}
	}else
	{
		echo '<div class="message">Please fill in all the fields.</div><br/>';
	}
}
echo '<div id="home_add_information">
<div id="home_title_bg">
	<img src="images/home/home_title_bar.png" width="831" height="45" alt="title_bar">
	<div id="home_title">Create New Post</div>
</div>
	<form action="" method="post" id="news_form">
	<label>Title:</label>
	<input type="text" name="title" />
	<label>Image Link:</label>
	<input type="text" name="image" />
	<input type="hidden" name="date" value="'.date('F j, Y,').'" />
	<div id="description_text">
		<label>Description:</label>
		<textarea cols="45" rows="10" name="description" id="description" ></textarea>
	</div>	
	<input name="add_post" type="submit" value="Submit" id="submit" />
	</form>
</div>';
?>