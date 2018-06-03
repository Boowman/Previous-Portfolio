<?php
	session_start();
	
	$loggedIN = $_SESSION['accountVerified'];
?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="icon" href="images/webIcon.jpg">
<title>Denisz's Portofolio</title>
<style type="text/css">
body {
	min-width: 1100px;
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
	background-image: url(images/bg.png);
	background-repeat: repeat;
	color: #FFF;
	text-align: center;
}
</style>
<link href="css/common_1.css" rel="stylesheet" type="text/css" />
<link href="css/about_1.css" rel="stylesheet" type="text/css" />
<link href="css/contact_content_1.css" rel="stylesheet" type="text/css" />
</head>
<body>
    <div id="header">
        <?php
            $navigation_bar = "includes/navigation_bar.php";
            if(file_exists($navigation_bar))
            {
                include_once($navigation_bar);
            }
        ?>
    </div>
    <div id="container">
        <?php	
		    $social_page = "includes/social_icons.php";
			
		    if($loggedIN == 1)
            {
                echo '<div id="new_content_button">
						<a href="index.php?aboutPage=edit">
                        	<img src="images/home/edit.png" width="25" height="25" id="new_content_icon" alt="Image"/>
						</a>
                    </div>';
            }
			
            if(file_exists($social_page))
            {
                include_once($social_page);
            }
        ?>
    <div id="content">
        <div class="div_separator">
              <div class="div_separator_text">ABOUT MYSELF</div>
        </div>
        <?php
            include_once("includes/connect.php");
		
			$query = "SELECT * FROM About";
			$quety_result = mysqli_query($dbconnection,$query);			

			while($row = mysqli_fetch_array($quety_result))
			{
				$description = $row['Description'];
				$story_id = $row['ID'];
			}

			$get_url = $_GET['aboutPage'];

			if($get_url == "edit" && $loggedIN == 1)
			{
				$desc = $_POST['description'];
				$edited_description = mysqli_real_escape_string($dbconnection,$desc);
				
				$descriptionID = $_POST['story_id'];
				
				if(isset($descriptionID))
				{
					$update_news = "UPDATE About SET ";
					$update_news .= "Description = '".$edited_description."' ";
					$update_news .= "WHERE ID = '".$descriptionID."'";

					if(mysqli_query($dbconnection,$update_news))
					{
						echo '<div class="message">Story has been edited and saved.</div>';
						echo header("refresh:1; url=index.php");
					}
					else
					{
						echo '<div class="message">There is a problem.</div><br/>';
						echo mysqli_error($dbconnection);
					}
				}
				
			echo'<div id="about_outerDiv">';		
				echo'<div id="about_descriptionDiv">
					<form name="update_description" action="" method="post">
						<label><div id="about_edit_Text">Edit Description</div></label>
						<textarea name="description" cols="20" rows="20" id="about_description_board" >'.$description.'</textarea>
						<input name="story_id" type="hidden" value="'.$story_id.'" />
						<input name="submit_edit" type="submit" value="Submit" />
					</form>
				</div>';
				
				$skill = 		$_POST['skillName'];
				$knowledge = 	$_POST['percentageValue'];								
				$submitButton = $_POST['submit_Skill'];
				
				if(isset($submitButton))
				{	
					$skillName = mysqli_real_escape_string($dbconnection,$skill);
					$knowledgeValue = mysqli_real_escape_string($dbconnection,$knowledge);
				
					if($skillName && $knowledgeValue)
					{
						$add_skill = "INSERT INTO Skills ( ";
						$add_skill .= "Skills, ";
						$add_skill .= "Percentage ";
						$add_skill .= ") ";
				
						$add_skill .= "VALUES ";
						{
							$add_skill .= "(";	
							$add_skill .= "'$skillName', ";
							$add_skill .= "'$knowledgeValue' ";
							$add_skill .= ") ";		
						}
							
						$skill_added = mysqli_query($dbconnection,$add_skill);
							
						if($skill_added)
						{		
							echo '<div class="message">Skill has been added.</div>';
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
				
				echo '<div id="about_skillsDiv">
						<form name="add_skills" method="post">
							<label><div id="about_edit_Text">Enter Skill Name</div></label>
							<input name="skillName" type="text" id="about_skill_Input"/>
							<label><div id="about_edit_Text">Enter Knowledge Percentage</div></label>
							<input name="percentageValue" type="text" id="about_skill_Input"/>
							<input name="submit_Skill" type="submit" value="Submit" />
						</form>
					</div>';
			echo '</div>';
			}

			if(!$get_url || $loggedIN == 0)
			{	
				echo '<div id="about_image"><img id="profile_picture" src="images/about/ProfilePicture.png" width="128" height="150" alt="avatar" /></div>';
				echo '<div id="about_intro">';
					echo $description;
				echo '</div>';
			}
		?>        
		<div class="div_separator">
			<div class="div_separator_text">SKILLS</div>
		</div>
		<div id="programming_outerDiv">
		<?php 
			$skill_Query = mysqli_query($dbconnection,"SELECT * FROM Skills ORDER BY Percentage DESC");	
			
			$lSelected = "N/A";
			
			while($row = mysqli_fetch_array($skill_Query))
			{
				$rowID = $row['ID'];
				$sName = $row['Skills'];
				$pKnowledge = $row['Percentage'];
				
				if($pKnowledge > 0 && $pKnowledge < 35)
					$lSelected = "Basic";
				if($pKnowledge >= 35 && $pKnowledge < 60)
					$lSelected = "Intermediate";
				if($pKnowledge >= 60 && $pKnowledge < 90)
					$lSelected = "Advanced";
				if($pKnowledge >= 90 && $pKnowledge <= 100)
					$lSelected = "Master";
	
				echo ' <!--Language-->
					<form method="post">
						<div class="programming_innerDiv">            
							<div class="programming_language">'.$sName.'</div><div class="programming_value">'.$pKnowledge.'%</div><div class="programming_level">'.$lSelected.'</div>
							<progress max="100" value="'.$pKnowledge.'"></progress>';					
						if($loggedIN == 1)
						{		
							echo'<div class="programming_increasePercentage">
									<input type="hidden" name="increasePercentageID" value="'.$rowID.'"/>
									<input type="submit" name="increasePercentage'.$rowID.'" value=""  style="border: 0; background: transparent"/>
								</div>
								 <div class="programming_decreasePercentage">
									<input type="hidden" name="decreasePercentageID" value="'.$rowID.'"/>
									<input type="submit" name="decreasePercentage'.$rowID.'" value=""  style="border: 0; background: transparent"/>
								</div>';
						}
						echo'</div>
					</form>';
				
				if($loggedIN == 1)
				{	
					if(isset($_POST['increasePercentage'.$rowID.'']))
					{
						if($pKnowledge <= 100)
						{
							$update_skillsAdd = "UPDATE Skills SET ";
							$update_skillsAdd .= "Percentage = '".($pKnowledge + 2)."' ";
							$update_skillsAdd .= "WHERE ID = '".$rowID."'";
			
							if(mysqli_query($dbconnection,$update_skillsAdd))
							{
							}
							else
							{
								echo '<div class="message">There is a problem.</div><br/>';
								echo mysqli_error($dbconnection);
							}
						}
					}
					
					if(isset($_POST['decreasePercentage'.$rowID.'']))
					{
						if($pKnowledge >= 0)
						{
							$update_skillsAdd = "UPDATE Skills SET ";
							$update_skillsAdd .= "Percentage = '".($pKnowledge - 2)."' ";
							$update_skillsAdd .= "WHERE ID = '".$rowID."'";
			
							if(mysqli_query($dbconnection,$update_skillsAdd))
							{
							}
							else
							{
								echo '<div class="message">There is a problem.</div><br/>';
								echo mysqli_error($dbconnection);
							}
						}
					}
				}
			}	
		?>
      </div>
      </div> 
    </div>
    <?php
        $footer = "includes/footer.php";
        if(file_exists($footer))
        {
            include_once($footer);
        }
    ?>
</body>
</html>