<?php
$actual_link = "$_SERVER[REQUEST_URI]";

$sqlUpdates = "SELECT * FROM Updates WHERE Project_ID = '$check_moreInfoID'";
$sqlUpdatesResults = mysqli_query($dbconnection,$sqlUpdates);

while($row = mysqli_fetch_array($sqlUpdatesResults))
{
	$id = $row['ID'];
	$title = $row['Title'];
}

$sqlProject = "SELECT * FROM Project WHERE Update_ID LIKE '%{$id}%'";
$sqlProjectResults = mysqli_query($dbconnection,$sqlProject);

while($row = mysqli_fetch_array($sqlProjectResults))
{
	$prj_description = $row['Description'];
	$image 			 = $row['Image'];
	$name 			 =  str_replace("<","&lt;",$row['Name']);
}

if($check_projectInfo == $name)
{
	//Display the project logo
	echo '<div id="projectInfo_outerDiv">
			<div id="projectInfo_title">
				<img src="images/project/MoreInfoTitleBG.png" width="850" height="40" id="projectInfo_title_bg">
					<div id="projectInfo_title_text">'.$name.'</div>
				</img>
			</div> 
			<img src="'.$image.'" id="projectInfo_Image"></img>';
		if(!empty($prj_description))
		{				
			echo'<div id="projectInfo_Description_Div">
					<img src="images/project/MoreInfoTitleBG.png" width="850" height="100" id="projectInfo_Description_Bg">
						<div id="projectInfo_Description_Text">'.$prj_description.'</div>
				</img>
				</div>';  
		}
	echo'</div>';
				
	$page = $_GET['page'];
	$updatesBTN = $_POST['updatesButton'];
	$galleryBTN = $_POST['galleryButton'];
	   
	echo '<div id="project_navigationOuterDiv">
			<form action="" method="post">
				<input type="submit" name="updatesButton" value="Updates" id="project_navigationSubmit" />
				<input type="submit" name="galleryButton" value="Gallery" id="project_navigationSubmit" />
			</form>   	
		</div>';
	
	$sqlUpdates = "SELECT * FROM Updates WHERE Project_ID = '$check_moreInfoID' ORDER BY Date DESC";
	$sqlUpdatesResults = mysqli_query($dbconnection,$sqlUpdates);

	if($page != 'Updates' && isset($updatesBTN))
	{	
		$oldurl = $actual_link;
		$newurl = preg_replace("/Gallery/", "Updates", $oldurl);
		
		header('Location: '.$newurl);
	}
	
	if($page != 'Gallery' && isset($galleryBTN))
	{	
		$oldurl = $actual_link;
		$newurl = preg_replace("/Updates/", "Gallery", $oldurl);
		
		header('Location: '.$newurl);
	}

	
	if($page == 'Updates') 
	{
		//Displaying all the updates to this certain project
		echo '<div id="project_outerDiv">';
			while($row = mysqli_fetch_array($sqlUpdatesResults))
			{
				$id = $row['ID'];
				$title = strtr($row['Title'],Array("<"=>"&lt;","&"=>"&amp;"));
				$date = strtr($row['Date'],Array("<"=>"&lt;","&"=>"&amp;"));
				$image1 = $row['Image'];
				$image2 = $row['Image2'];
				$image3 = $row['Image3'];
				$videoExtension = $row['Video'];
				$description = $row['Description'];

				
		   echo '<div class="project_div">
					<div class="project_video"><iframe width="500" height="294" src="https://www.youtube.com/embed/'.$videoExtension.'" frameborder="0" allowfullscreen></iframe></div>
					<div class="project_title_div">
						<div class="project_date">'.$date.'</div>
						<div class="project_title">'.$title.'</div>
					</div>
				  <div class="project_description">'.$description.'</div>
				  <div class="project_images_list">';
				  
				  if(!empty($image1))
					 echo'<div class="project_image" style="background-image:url('.$image1.')"></div>';
				  if(!empty($image2))
					 echo'<div class="project_image" style="background-image:url('.$image2.')"></div>';
			 	  if(!empty($image3))
			 		 echo'<div class="project_image" style="background-image:url('.$image3.')"></div>';
					 
				echo'</div></div>';
			 echo '<div style="clear:both"></div>';
			}
		echo '</div>';
	}
	
	if($page == 'Gallery') 
	{
		if(mysqli_num_rows($sqlUpdatesResults) > 0)
		{	
			$sqlUpdates2 = "SELECT * FROM Updates WHERE Project_ID = '$check_moreInfoID'";
			$sqlUpdatesResults2 = mysqli_query($dbconnection,$sqlUpdates2);
		
			//Displaying all the images added to that certain project
			echo '<div id="gallery_outerDiv">';				
				while($row = mysqli_fetch_array($sqlUpdatesResults2))
				{
					if(!empty($row['Image']))
						echo '<div class="gallery_images"><a href="'.$row['Image'].'"><img src="'.$row['Image'].'" width="256" height="150"></a></div>';
						
					if(!empty($row['Image2']))	
						echo '<div class="gallery_images"><a href="'.$row['Image2'].'"><img src="'.$row['Image2'].'" width="256" height="150"></a></div>';
						
					if(!empty($row['Image3']))
						echo '<div class="gallery_images"><a href="'.$row['Image3'].'"><img src="'.$row['Image3'].'" width="256" height="150"></a></div>';
				}
			echo'<div id="float_push"></div></div>';
		}
	}
}
else
{
	echo '<div class="message">Project with such a name doesn\'t exist or it is empty.</div><br/>';
}
?>