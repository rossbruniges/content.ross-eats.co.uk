<?php
// BRING THE LIST, BRING THE WORLD
if (isset($_POST['SubmitGARList'])) {
	if (function_exists('current_user_can') && !current_user_can('manage_options')) {
		die(__('Cheatin&#8217; uh?'));
	}

	if (!isset($_POST['GARs_email']) || trim($_POST['GARs_email']) == '') {
		$error_message = "Email is required";
	}
	else if( !isset($_POST['GARs_password']) || $_POST['GARs_password'] == '' ) {
		$error_message = "Password is required";
	}
	else {
		
		try {
		$ga = new gapi($_POST['GARs_email'],$_POST['GARs_password']);
		$ga->requestAccountData(1,999);
		$profileList = array();
		foreach($ga->getResults() as $result) {
			$profileList[$result->getTitle()] = $result->getProfileId();
		}
		ksort($profileList);
		$thelist = createSelect($profileList,"GARs_tableid","GARs_tabletitle");
		}
		catch(Exception $e) {
			$error_message = $e->getMessage();
		}
	}
}
else if (isset($_POST['SubmitGARSave'])) {
// SAVE THE LIST SAVE THE WORLD
	delete_option('GARs_email', $_POST['GARs_email']);
	add_option('GARs_email', $_POST['GARs_email']);
	delete_option('GARs_password', $_POST['GARs_password']);
	add_option('GARs_password', enkrypt($_POST['GARs_password']));
	delete_option('GARs_tableid', $_POST['GARs_tableid']);
	add_option('GARs_tableid', $_POST['GARs_tableid']);
	delete_option('GARs_tabletitle', $_POST['GARs_tabletitle']);
	add_option('GARs_tabletitle', $_POST['GARs_tabletitle']);
	$info_message = "Google Analytics information is now saved to database. Thanks.<br/>Now relax and enjoy the reports for: <em>".$_POST['GARs_tabletitle']."</em>.<br/>Loading reports in 5 seconds...<script>setTimeout(\"window.location='".$_SERVER['HTTP_REFERER']."'\",5000);</script>";
}
?>
<?php if( isset($info_message) && trim($info_message) != '' ) : ?>
<div id="message" class="updated fade"><p><strong><?php echo $info_message ?></strong></p></div>
<?php endif; ?>

<?php if( isset($error_message) ) : ?>
<div id="message" class="error fade"><p><strong><?php echo $error_message ?></strong></p></div>
<?php endif; ?>

<?php if (!isset($_POST['SubmitGARSave'])) { ?>
<div class="settings mumbojumbo">
<form action="" method="POST" class="form">
	<h6>Please set your Google Analytics email and password to get the list of available reports:</h6>
	<label for="GARs_email"><span class="title">Google Analytics Email </span><input name="GARs_email" type="text" class="text" id="GARs_email" value="<?php echo isset($_POST['GARs_email']) ? $_POST['GARs_email'] : $GLOBALS['em']; ?>" /></label>
	<label for="GARs_password"><span class="title">Google Analytics Password </span><input name="GARs_password" type="password" class="text" id="GARs_password" value="<?php echo isset($_POST['GARs_password']) ? $_POST['GARs_password'] : $GLOBALS['pw']; ?>" /></label>
<?php 
if (!isset($_POST['SubmitGARList']) || isset($error_message)) { 
?>
	<input name="SubmitGARList" type="submit" value="Get Profile List" class="button" />
<?php 
}

else {
?>
	<label for="GARs_tableid"><span class="title">Available Reports </span>
	<?php echo $thelist; ?>
	</label>
	<input name="SubmitGARSave" type="submit" value="Get Reports" class="button" />
<?php 
}
?>
</form>
</div>
<?php 
} 
?>