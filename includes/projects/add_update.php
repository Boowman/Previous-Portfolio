<?php
$desc = $_POST['description'];
$pro = $_POST['project_name'];
$date = $_POST['date'];
$vid = $_POST['video'];
$nam = $_POST['title'];
$projectName = "";

$project = "SELECT * FROM Project";
$project_result = mysqli_query($dbconnection,$project);	  
	 
if(!$project_result)
{
	echo "Error getting info from table.";
}		

echo '<div id="add_project_outerDiv">
		<div id="div_separator">
		  <div id="div_separator_text">Add new update</div>
		</div>
	<form action="" method="post" enctype="multipart/form-data" id="news_form">
		<label><div id="project_Add_Text">Select Project</div></label>
		<select name="project_name" id="project_Select">
			<option value="NONE" selected>NONE</option>';	                   
		while($row = mysqli_fetch_array($project_result))
		{
			$nameOut = str_replace("<","&lt;",$row['Name']);
			
			$projectID = $row['ID'];
			echo '<option value="'.$projectID.'">'.$nameOut.'</option>';
			echo 'Name: '.$nameOut;
		}      
		echo'</select>';
		echo'<label><div id="project_Add_Text">Enter Title</div></label>
		<input type="text" name="title" id="project_Text_Input"/>
		<label><div id="project_Add_Text">YouTube Video ID</div></label>
		<input type="text" name="video" id="project_Text_Input"/>
		<label><div id="project_Add_Text">1. Image</div></label>
		<input type="file" name="file[]" id="project_ImageUpload"/>
		<label><div id="project_Add_Text">2. Image</div></label>
		<input type="file" name="file[]" id="project_ImageUpload"/>
		<label><div id="project_Add_Text">3. Image</div></label>
		<input type="file" name="file[]" id="project_ImageUpload"/>
		<input type="hidden" name="date" value="'.date('M d o h:i').'" />
		<div id="description_text">
			<label><div id="project_Add_Text">Description</div></label>
			<textarea cols="45" rows="10" name="description" id="project_TextArea" maxlenght="1000" >Max 1000 Characters</textarea>
			<div id="description_help">
					Paragraph 		&lt;p&gt;&lt;/p&gt;
					<br/> Next Line &lt;br /&gt;
					<br/> Center	&lt;center&gt;&lt;/center&gt;
					<br/> Line		&lt;hr/&gt;
					<br/> Italic	&lt;i&gt;&lt;/i&gt;
					<br/> Bold		&lt;b&gt;&lt;/b&gt;
			</div>
		</div>	
		<input name="add_updates" type="submit" value="Submit" id="submit" />
	</form>
	</div>';


if(isset($_POST['add_updates']))
{
	if(isset($_FILES['file']) && !empty($desc) && !empty($nam) and !empty($date) && !empty($pro))
	{	
		$file = $_FILES['file'];
		
		$errors = array();
		$fileNames = array();
		
		foreach($file['tmp_name'] as $key => $tmp_name)
		{
			//File properties
			$file_name = $file['name'][$key];
			$file_temp = $file['tmp_name'][$key];
			$file_size = $file['size'][$key];
			$file_error = $file['error'][$key];
						
			//File extensions
			$file_ext = explode('.', $file_name);
			$file_ext = strtolower(end($file_ext));
			
			$allowed = array("jpeg","jpg");
	
			if(in_array($file_ext, $allowed) == false)
			{
				$errors[] = "Extension not allowed";
			}
			
			if($file_size <= 5000000)
			{
				$errors[] = "File size must be less than 500Kb";
			}
			
			$file_name_new = uniqid('', true) . '.' . $file_ext;
			$file_destination = "images/project/projects/" . $file_name_new;
			
			
			if(move_uploaded_file($file_temp, $file_destination))
			{	
				$fileNames[] = "http://{$_SERVER['SERVER_NAME']}/".$file_destination;
			}	
		}
			
			$name = mysqli_real_escape_string($dbconnection,$nam);	
			$image = mysqli_real_escape_string($dbconnection,$fileNames[0]);		
			$image2 = mysqli_real_escape_string($dbconnection,$fileNames[1]);	
			$image3 = mysqli_real_escape_string($dbconnection,$fileNames[2]);	
			$video = mysqli_real_escape_string($dbconnection,$vid);				
			$description = mysqli_real_escape_string($dbconnection,$desc);
			$project = mysqli_real_escape_string($dbconnection,$pro);
	
			$add_projects = "INSERT INTO Updates ( ";
			$add_projects .= "Title, ";
			$add_projects .= "Image, ";
			$add_projects .= "Image2, ";
			$add_projects .= "Image3, ";
			$add_projects .= "Video, ";
			$add_projects .= "Date, ";
			$add_projects .= "Description, ";
			$add_projects .= "Project_ID ";
			$add_projects .= ") ";
		
			$add_projects .= "VALUES ";
			{
				$add_projects .= "(";	
				$add_projects .= "'$name', ";
				$add_projects .= "'$image', ";
				$add_projects .= "'$image2', ";
				$add_projects .= "'$image3', ";
				$add_projects .= "'$video', ";
				$add_projects .= "'$date', ";
				$add_projects .= "'$description', ";
				$add_projects .= "'$project' ";
				$add_projects .= ") ";		
			}
			
			$project_added = mysqli_query($dbconnection,$add_projects);
			
			if($project_added)
			{
				$selectUpdate = "SELECT ID FROM Updates WHERE Project_ID = '$project'";
				$updatesQuery = mysqli_query($dbconnection,$selectUpdate);
				
				$updatesID = array();
				
				while($row = mysqli_fetch_assoc($updatesQuery))
				{
					$updatesID[] = $row['ID'];
				}	
								
				$updateProject = "UPDATE Project SET Update_ID = '".implode(", ", $updatesID)."' WHERE ID = '".$project."'";
				$projectQuery = mysqli_query($dbconnection,$updateProject);	
					
				if($projectQuery)
				{								
					echo '<div class="message">Update has been added.</div>';
				}
				else
				{
					echo '<div class="message">There was a problem.</div><br/>';
					echo mysqli_error($dbconnection);
				}
			}
			else
			{
				echo '<div class="message">There was a problem.</div><br/>';
				echo mysqli_error($dbconnection);
			}	
	}
	else
	{
		echo '<div class="message">Please fill in all the fields.</div><br/>';
	}
}
?>