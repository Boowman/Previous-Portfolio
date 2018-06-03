<?php
	if (isset($_POST['send'])) 
	{
		if($_POST['name'] || $_POST['email'] || $_POST['message'] || $_POST['messagetitle'] != ''){
			if(isset($_POST['agree']))
			{
				mail($_POST['recipient'], "Message from your webpage",$_POST['name']." ". $_POST['email']." ". $_POST['message']);
				echo '<div id="notification">Message has been sent successfully.</div>'; 
			}else
			{
				echo '<div id="notification">Please agree with our conditions.</div>'; 
			}
		}
		else
		{
			echo '<div id="notification">You got and error, please check all the fields and make sure are correct.</div>'; 
		}
	}
?>
<form method="post" action = "" id="contact_form">
    <input type="hidden" name="recipient" value="boowman.work@gmail.com" />
    <div id="contact_Add_Text">Your Name:</div>
    <input type="text" name="name" id="contact_Text_Input" />
    <div id="contact_Add_Text">Your Email:</div>
    <input type="text" name="email" id="contact_Text_Input" />
    <div id="contact_Add_Text">Message Title:</div>
    <input type="text" name="messagetitle" id="contact_Text_Input" />
    <div id="contact_Add_Text">Message:</div>
    <textarea id="contact_TextArea" name="message" rows="10" cols="50" ></textarea>
    <input type="checkbox" name="agree" id="contact_checkBox" /><div id="contact_Add_Text">I agree to the terms and conditions !!</div>
    <input type="submit" name="send" value="Submit" id="submit" />
</form>