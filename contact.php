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
<link href="css/contact_1.css" rel="stylesheet" type="text/css" />
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
        <div id="div_separator">
              <div id="div_separator_text">Contact</div>
        </div>
        <?php
            include_once("includes/contact_form.php");
		?>
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