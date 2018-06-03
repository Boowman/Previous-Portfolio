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
<link href="css/projects_1.css" rel="stylesheet" type="text/css" />
</head>
<body>
    <div id="header">
        <?php
            $navigation_bar = "includes/navigation_bar.php";
    
            if(file_exists($navigation_bar))
            {
                include($navigation_bar);
            }
        ?>
    </div>
    <div id="container">
        <?php									
            $social_page = "includes/social_icons.php";
			
			if($loggedIN == 1)
            {
				echo '<div id="new_content_button">
						<a href="project.php?create=project">
                        	<img src="images/home/add.png" width="25" height="25" id="new_content_icon" alt="Image"/>
						</a>
                    </div>';
            }
            
            if(file_exists($social_page))
            {
                include_once($social_page);
            }
        ?>
        
        <div id="content">  
        <?php
		    include("includes/connect.php");
            
			$check_url = $_GET['create'];		
            $check_projectInfo = $_GET['project'];
            $check_moreInfo = $_GET['news'];
            $check_moreInfoID = $_GET['id'];
           
            if(!empty($check_moreInfo) && !empty($check_moreInfoID) && empty($check_url) || !empty($check_projectInfo) && empty($check_url))
            {		
                $add_moreInfo = "includes/projects/project_moreInfo.php";
                $check_url = "notEmpty";
                
                if(file_exists($add_moreInfo))
                {
                    include($add_moreInfo);
                }
            }
                
            if($loggedIN == 1)
            {	
                if($check_url == "project")
                {		
                    $add_projecs = "includes/projects/add_project.php";
                
                    if(file_exists($add_projecs))
                    {
                        include($add_projecs);
                    }
                    
                    $add_update = "includes/projects/add_update.php";
                    $check_moreInfo = "notEmpty";
                    $check_moreInfoID = "notEmpty";
                    
                    if(file_exists($add_update))
                    {
                        include($add_update);
                    }
                }	
            }
            
            if(empty($check_url) || empty($check_moreInfo) && empty($check_moreInfoID))
            {	
                $project_queryL = "SELECT * FROM Project";
                $project_query_resultL = mysqli_query($dbconnection,$project_queryL);
                
                if (!$project_query_resultL) 
				{
                    printf("Error: %s\n", mysqli_error($dbconnection));
                    exit();
                }
								
				echo '<div class="projects_list">';
				while($row = mysqli_fetch_array($project_query_resultL))
				{
					if($row['Align'] == "Left")
					{			
						$linkName = str_replace(" ","%20",$row['Name']);
						
						echo '<a href="project.php?project='.$linkName.'&id='.$row['ID'].'&page=Updates">';
						switch($row['ImgSize'])
						{
							case "1":
								echo '<div class="project_face" style="width: 465px; height:262px; background-image:url('.$row['Image'].')">           
									  <div class="project_hoverBg" style="width: 465px; height:262px; line-height: 232px;">'.$row['Name'].'</div>
								  </div>';
								break;
							case "2":
								echo '<div class="project_face" style="width: 229px; height:129px; background-image:url('.$row['Image'].')">           
									  <div class="project_hoverBg" style="width: 229px; height:129px; line-height: 64px;">'.$row['Name'].'</div>
								  </div>';
								break;
						}
						echo '</a>';
					}
				}
				echo'</div>';
				
				$project_queryR = "SELECT * FROM Project";
                $project_query_resultR = mysqli_query($dbconnection,$project_queryR);
                
                if (!$project_query_resultR) 
				{
                    printf("Error: %s\n", mysqli_error($dbconnection));
                    exit();
                }

				echo '<div class="projects_list">';
				while($row = mysqli_fetch_array($project_query_resultR))
				{	
					if($row['Align'] == "Right")
					{				
						$linkName = str_replace(" ","%20",$row['Name']);

						echo '<a href="project.php?project='.$linkName.'&id='.$row['ID'].'&page=Updates">';
						switch($row['ImgSize'])
						{
							case "1":
								echo '<div class="project_face" style="width: 465px; height:262px; background-image:url('.$row['Image'].')">           
									  <div class="project_hoverBg" style="width: 465px; height:262px; line-height: 232px;">'.$row['Name'].'</div>
								  </div>';
								break;
							case "2":
								echo '<div class="project_face" style="width: 229px; height:129px; background-image:url('.$row['Image'].')">           
									  <div class="project_hoverBg" style="width: 229px; height:129px; line-height: 64px;">'.$row['Name'].'</div>
								  </div>';
								break;
						}
						echo '</a>';
					}
				}
				echo'</div>';
            }
            mysqli_close($dbconnection);
        ?> 
        <div class="float_push"></div>
        </div>   
      <?php
            $footer = "includes/footer.php";
            if(file_exists($footer))
            {
                include_once($footer);
            }
        ?>
    </div>
</body>
</html>