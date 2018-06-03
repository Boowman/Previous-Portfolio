<?php
$name 			= $_POST['project_name'];
$description 	= $_POST['project_description'];
$align 			= $_POST['project_align'];
$imgSize 		= $_POST['project_imgSize'];
$date 			= $_POST['date']; 
 
echo '<div id="add_project_outerDiv">
        <div id="div_separator">
       	  <div id="div_separator_text">Add new project</div>
        </div>
		<form action="" method="post" enctype="multipart/form-data" id="news_form">
            <label><div id="project_Add_Text">Project Name</div></label>
            <input type="text" name="project_name" id="project_Text_Input"/>
			<label><div id="project_Add_Text">Display Side Name</div></label>
            <select name="project_align" id="project_Select">
				<option value="Left">Left</option>	    
				<option value="Right">Right</option>	          
			</select>
			<label><div id="project_Add_Text">Game State</div></label>
			<select name="project_imgSize" id="project_Select">
				<option value="1">Medium</option>	    
				<option value="2">Small</option>	          
			</select>
            <label><div id="project_Add_Text">Image 16:9 Ratio</div></label>
            <input type="file" name="file[]" id="project_ImageUpload"/>
            <input type="hidden" name="date" value="'.date('M d o h:i').'" />
			<div id="description_text">
				<label><div id="project_Add_Text">Description</div></label>
				<textarea cols="45" rows="10" name="project_description" id="project_TextArea" maxlenght="1000" >Max 1000 Characters</textarea>
				<div id="description_help">
						Paragraph 		&lt;p&gt;&lt;/p&gt;
						<br/> Next Line &lt;br /&gt;
						<br/> Center	&lt;center&gt;&lt;/center&gt;
						<br/> Line		&lt;hr/&gt;
						<br/> Italic	&lt;i&gt;&lt;/i&gt;
						<br/> Bold		&lt;b&gt;&lt;/b&gt;
				</div>
			</div>	
			<input name="add_project" type="submit" value="Submit" id="submit" />
		</form>
    </div>';

if(isset($_POST['add_project']))
{
	if(!empty($_FILES['file']) && !empty($name) && !empty($date) && !empty($align) && !empty($imgSize))
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
		
		$project_name = mysqli_real_escape_string($dbconnection,$name);	
		$project_image = $fileNames[0];				
		$project_description = mysqli_real_escape_string($dbconnection,$description);	
		
		$add_project = "INSERT INTO Project ( ";
		$add_project .= "Name, ";
		$add_project .= "Description, ";
		$add_project .= "Image, ";
		$add_project .= "Align, ";
		$add_project .= "ImgSize, ";
		$add_project .= "Date ";
		$add_project .= ") ";
	
		$add_project .= "VALUES ";
		{
			$add_project .= "(";	
			$add_project .= "'$project_name', ";
			$add_project .= "'$project_description', ";
			$add_project .= "'$project_image', ";
			$add_project .= "'$align', ";
			$add_project .= "'$imgSize', ";
			$add_project .= "'$date' ";
			$add_project .= ") ";		
		}
				
		if(mysqli_query($dbconnection,$add_project))
		{
			echo '<div class="message">Project has been added.</div>';
			echo header("refresh:1; url=project.php");
		}else
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