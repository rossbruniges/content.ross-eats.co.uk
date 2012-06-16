<?php
/*
Plugin Name: Reporteur
Plugin URI: http://stild.com/reporteur
Description: Reporteur is a simple reporting tool for your Google Analytics account. It will show you a snapshot of pageviews and visits for different timespans at a glance. And for more, there is also a detailed report including top posts, search keywords, and top sources, and visiting countries for each timespan. That's all folks.
Version: 1.0.2
Author: @stildv
Author URI: http://stild.com/

* This program is distributed in the hope that it will be useful,
* but WITHOUT ANY WARRANTY; without even the implied warranty of
* MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.

*/
require 'gapi.class.php';
require_once(dirname(__FILE__) . '/reporteur-head.php');

$GLOBALS['em'] = get_option('GARs_email');
$GLOBALS['pw'] = dekrypt(get_option('GARs_password'));
$GLOBALS['ti'] = get_option('GARs_tableid');
$GLOBALS['tt'] = get_option('GARs_tabletitle');
$GLOBALS['uv'] = false;
$GLOBALS['pt'] = false;

function createSelect($array,$formid,$formtitle) {
	$temp = '<select id="'.$formid.'" name="'.$formid.'" onclick="document.getElementById(\''.$formtitle.'\').value='.$formid.'.options['.$formid.'.selectedIndex].text;">';
	$temp .= '<option selected>Please select a report</option>';
	foreach ($array as $key => $val) {
		$temp .= '<option value="'.$val.'">'.$key.'</option>';
	}
	$temp .= '</select>';
	$temp .= '<input type="hidden" name="'.$formtitle.'" id="'.$formtitle.'" value="" />';
	return $temp;
}

function set_plugin_meta($links, $file) {
	$plugin = plugin_basename(__FILE__);
	// create link
	if ($file == $plugin) {
		return array_merge(
			$links,
			array( sprintf( '<a href="admin.php?page=%s">%s</a>', $plugin, __('Settings & Reports') ) )
		);
	}
	return $links;
}
add_filter( 'plugin_row_meta', 'set_plugin_meta', 10, 2 );

function GARs_admin_plugin_menu() {
	$hook = add_menu_page(__('Reporteur | Settings and Reports'), __('Reporteur'), 8, __FILE__, 'GARs_admin_plugin_options', plugin_dir_url( __FILE__ ).'/img/chart_bar.png');
	add_action("admin_head-$hook", 'GARs_head_extras');
}
add_action('admin_menu', 'GARs_admin_plugin_menu');

function enkrypt($str) {
	$val = '';
	$salt = 'js6@=9$3$N<n#wFjcx_eGN3/_7JD.y+VS+b[PX+Xr]MNmls!-t[)+d18ZMfd.';
	$val = base64_encode($salt.'||'.$str);
	return $val;
}
function dekrypt($str) {
	$val = '';
	$val = explode('||',base64_decode($str));
	return $val[1];
}

function GARs_admin_plugin_options($info_message = '') {
?>
<div class="GARcontainer">
<div class="header">
	<h3><a href="http://stild.com/reporteur" title="Reporteur | Plugin Homepage" target="_blank">Reporteur</a></h3>
	<h6>v1.0.2 || 
	<a href="http://stild.com/reporteur" target="_blank">plugin home</a> || 
	<a href="http://wordpress.org/extend/plugins/reporteur/" target="_blank">wordpress plugins</a> || 
	<a href="https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=A6MQWR8DK4PFC" target="_blank">donate via paypal</a> || 
	by <a href="https://twitter.com/stildv" target="_blank">@stildv</a> of <a href="http://stild.com" target="_blank">stild.com</a> || 
	<a href="#" class="switch_details">hide details & settings</a></h6>
</div>

<div class="details mumbojumbo">
	<div class="about">
		<h5>About Reporteur?</h5>
		<p>Reporteur is (fake) French for simple and fast Google Analytics Report, brilliant, right?<br/>It analyzes the live data coming from Google Analytics API and shows it to you right in your Wordpress admin, in a convenient way. There may rarely be some inconsistencies or small differences between refreshes, blame Google for it, if it ever happens. If it is slow, blame Google for it (and also your server). If it gives you a timeout, blame Google for it (and also your server's connection). Note that, this report is to give a general and / or quick overview of your data, for every kind of detail and custom reports, please use Google Analytics' wonderful website emporium.</p>
	</div>
	<div class="help">
		<h5>How-to Use?</h5>
		<p>It is not complicated:</p>
		<ul class="square">
			<li><strong>Enter your Google Analytics email and password</strong></li>
			<li><strong>Select the report you want to see</strong></li>
		</ul>
	</div>
</div>


<?php
if (
	(!isset($GLOBALS['em']) || $GLOBALS['em']=='' || !isset($GLOBALS['pw']) || $GLOBALS['pw']=='' || !isset($GLOBALS['ti']) || $GLOBALS['ti']=='') ||
	(isset($_POST['SubmitGARList']) || isset($_POST['SubmitGARSave'])  || isset($_POST['SubmitGAROptions']) )
) {

/****************************************************************************** IF NO OPTIONS ARE SET TO DATABASE OR CHANGE IS SUBMITTED SHOW SETTINGS BOX ****/
	require_once(dirname(__FILE__) . '/reporteur-options.php');
}
else {

/****************************************************************************** IF OPTIONS ARE SET TO DATABASE SHOW CHANGE BOX AND RESULTS ****/
	?>
<div class="settings mumbojumbo">
	<div class="settings-left">
	Great! You've already set Google Analytics login info and you're viewing reports for: 
	<h6><?php echo $GLOBALS['tt']; ?></h6>
	</div>
	<div class="settings-right">	
	No, these are not the reports you're looking for.
	<form action="" method="POST" class="form"><input name="SubmitGAROptions" type="submit" value="Change" class="button" /></form>
	</div>
</div>
	<?php
	require_once(dirname(__FILE__) . '/reporteur-results.php');
}
?>
</div>
<?php
}

/****************************************************************************** MASSIVE FANTASTIC DATA CALLING VIA GAPI ****/
add_action('admin_head', 'get_data_from_gapi');
function get_data_from_gapi() {

$plugins_dir = plugins_url();
?>
<script type="text/javascript">
var containerId = '#atom-tabs-container';
var tabsId = '#atom-tabs';
var loadingDiv = '<span class="loading"><img src="<?php echo $plugins_dir; ?>/reporteur/img/loading.gif"/>Loading. Please Wait...</span>';
var loadingSpan = '<span class="loading"><img src="<?php echo $plugins_dir; ?>/reporteur/img/loading.gif"/></span>';

jQuery(document).ready(function($) {

	if(jQuery(tabsId + ' LI.current A').length > 0){
		jQuery(containerId).html(loadingDiv);
		jQuery(containerId).addClass('loading');	
		get_data(jQuery(tabsId + ' LI.current A').attr('href').replace('#', ''));
	}

	jQuery('.ga-reporter-data').each(function(){
		var curr = jQuery(this).attr('href').replace('#', '');
		get_only_hits(curr);
	});

	jQuery('.ga-reporter-data').click(function(){
		if(jQuery(this).parent().hasClass('current')){ return false; }
    	jQuery(tabsId + ' LI.current').removeClass('current');
    	jQuery(this).parent().addClass('current');
	
		var curr = jQuery(this).attr('href').replace('#', '');
		
		jQuery(containerId).html(loadingDiv);
		jQuery(containerId).addClass('loading');
		
		get_data(curr);
		return false;
	});
});

function get_data(date) {
	var data = {
		action: 'ga_reporter_data',
		getdays: date,
		getmode: 'detailed'		
	}; 
	jQuery(containerId).removeClass('loading');
	
	var cache = jQuery('body').data(date);
	
	if (!cache || !cache.indexOf('<del></del>')) {
		jQuery.post(ajaxurl, data, function(response) {
			jQuery('#atom-tabs-container').html(response);
			jQuery('body').data(date,response);
			
			jQuery('td.d span').each(function(){
				jQuery(this).addClass('ellipsis_text');
				jQuery(this).attr('title',jQuery(this).html());
				jQuery(this).wrap('<div class="ellipsis" />');
			});
			jQuery('.ellipsis').ThreeDots({max_rows:1});			
		});
	}
	else {
		jQuery('#atom-tabs-container').html(cache);
		
		jQuery('td.d span').each(function(){
			jQuery(this).addClass('ellipsis_text');
			jQuery(this).attr('title',jQuery(this).html());
			jQuery(this).wrap('<div class="ellipsis" />');
		});
		jQuery('.ellipsis').ThreeDots({max_rows:1});		
	}
}

function get_only_hits(date) {
	var data = {
		action: 'ga_reporter_data',
		getdays: date,
		getmode: 'hitsonly'
	};
	jQuery('.'+date+'> span.p').html(loadingSpan);	
	jQuery.post(ajaxurl, data, function(response) {
		var splinter = response.split('|');
		jQuery('.'+date+'> span.p').html(splinter[0]);
		jQuery('.'+date+'> span.v').html(splinter[1]);
	});
}
</script>
<?php
}
add_action('wp_ajax_ga_reporter_data', 'ga_reporter_data_callback');
function ga_reporter_data_callback() {
	$getdays = $_POST['getdays'];
	$getmode = $_POST['getmode'];
	$data = array();
	
	if(strtolower($getmode)=='hitsonly') {
		if ($GLOBALS['uv']) {
			$dimensions = array();
		}
		else {
			$dimensions = array('pagePath');
		}
		$metrics    = array('pageviews','visits','visitors');
		$orderby = '-pageviews';
		$data = callDataFromGapi($getmode, $getdays, $dimensions, $metrics, $orderby, $sd, $ed);
		$return = $data['pageviews'] . '|' . $data['visits'] ;
	}
	else {
		$html = '<div class="ga-data-detailed-container">';
		$dimensions = array('pagePath','pageTitle');
		$metrics    = array('pageviews','visits');
		$orderby = '-pageviews';
		$data = callDataFromGapi($getmode, $getdays, $dimensions, $metrics, $orderby, $sd, $ed);
		
		if ($data['start-date'] == $data['end-date']) {
			$html.= '<h5>Date: '.$data['start-date'].'</h5>';
		}
		else {
			$html.= '<h5>From: '.$data['start-date'].'&nbsp;&nbsp;&nbsp;To: '.$data['end-date'].'</h5>';
		}
		
		/************************************************************** TOP PAGES *******/
		$html.= '<div class="gaTopPages"><h6>Top Pages</h6>';
		$html.= '<table><tr><th class="n">No</th><th class="d">Page Path</th><th class="p">Pageviews</th><th class="v">Visits</th></tr>';
		$i=1;
		foreach($data['real-data'] as $result) {
			$html.='<tr><td class="n">'. $i .'</td>';
			if($GLOBALS['pt']){
				$html.='<td class="d"><span>'.$result->getpageTitle().'</span></td>';
			}
			else {
				$html.='<td class="d"><span>'.$result->getpagePath().'</span></td>';
			}
			$html.='<td class="p">'.$result->getPageviews().'</td>';
			$html.='<td class="v">'.$result->getVisits().'</td></tr>';
			$i++;
		}
		$html.='</table>';
		$html.='</div>';
		/************************************************************** TOP COUNTRIES *******/
		$dimensions = array('country');
		$data = callDataFromGapi($getmode, $getdays, $dimensions, $metrics, $orderby, $sd, $ed);
		
		$html.= '<div class="gaTopCountries"><h6>Top Countries</h6>';
		$html.= '<table><tr><th class="n">No</th><th class="d">Country</th><th class="p">Pageviews</th><th class="v">Visits</th></tr>';
		$i=1;
		foreach($data['real-data'] as $result) {
			$html.='<tr><td class="n">'. $i .'</td>';
			$html.='<td class="d"><span>'.$result->getCountry().'</span></td>';
			$html.='<td class="p">'.$result->getPageviews().'</td>';
			$html.='<td class="v">'.$result->getVisits().'</td></tr>';
			$i++;
		}
		$html.='</table>';
		$html.='</div>';
		/************************************************************** TOP SEARCH KEYWORDS *******/
		$dimensions = array('keyword');
		$data = callDataFromGapi($getmode, $getdays, $dimensions, $metrics, $orderby, $sd, $ed);
		
		$html.= '<div class="gaTopSearchKeywords"><h6>Top Search Keywords</h6>';
		$html.= '<table><tr><th class="n">No</th><th class="d">Keyword</th><th class="p">Pageviews</th><th class="v">Visits</th></tr>';				
		$i=1;
		foreach($data['real-data'] as $result) {
			$html.='<tr><td class="n">'. $i .'</td>';
			$html.='<td class="d"><span>'.$result->getKeyword().'</span></td>';
			$html.='<td class="p">'.$result->getPageviews().'</td>';
			$html.='<td class="v">'.$result->getVisits().'</td></tr>';
			$i++;
		}
		$html.='</table>';
		$html.='</div>';
		/************************************************************** TOP REFERRERS *******/
		$dimensions = array('source');
		$data = callDataFromGapi($getmode, $getdays, $dimensions, $metrics, $orderby, $sd, $ed);
		
		$html.= '<div class="gaTopReferrers"><h6>Top Referrers</h6>';
		$html.= '<table><tr><th class="n">No</th><th class="d">Source</th><th class="p">Pageviews</th><th class="v">Visits</th></tr>';		
		$i=1;
		foreach($data['real-data'] as $result) {
			$html.='<tr><td class="n">'. $i .'</td>';
			$html.='<td class="d"><span>'.$result->getSource().'</span></td>';
			$html.='<td class="p">'.$result->getPageviews().'</td>';
			$html.='<td class="v">'.$result->getVisits().'</td></tr>';
			$i++;
		}
		$html.='</table>';
		$html.='</div>';
		
		$html.= '</div>';
		$html.= '<del></del>';
		$return = $html;
	}
	echo($return);
	die(); // this is required to return a proper result
}

function weekday($day="", $now="") {
  $now = $now ? $now : "now";
  $day = $day ? $day : "now";
  $rel = date("N", strtotime($day)) - date("N");
  $time = strtotime("$rel days", strtotime($now));
  return date("Y-m-d", $time);
}

function callDataFromGapi($getmode, $getdays, $dimensions, $metrics, $orderby, $sd, $ed) {
	
	switch(strtolower($getdays)) {
		case "today":
			$data = getDataFromGapi($getmode, $dimensions, $metrics, $orderby, 
				date("Y-m-d"), 
				date("Y-m-d")
			);
			break;
		case "yesterday":
			$data = getDataFromGapi($getmode, $dimensions, $metrics, $orderby, 
				date("Y-m-d", strtotime("-1 day", strtotime(date("Y-m-d")))), 
				date("Y-m-d", strtotime("-1 day", strtotime(date("Y-m-d"))))
			);
			break;
		case "daybefore":
			$data = getDataFromGapi($getmode, $dimensions, $metrics, $orderby, 
				date("Y-m-d", strtotime("-2 day", strtotime(date("Y-m-d")))), 
				date("Y-m-d", strtotime("-2 day", strtotime(date("Y-m-d"))))
			);
			break;
		case "thisweek":
			$data = getDataFromGapi($getmode, $dimensions, $metrics, $orderby, 
				weekday('monday'),
				date("Y-m-d")
			);
			break;
		case "lastweek":
			$data = getDataFromGapi($getmode, $dimensions, $metrics, $orderby, 
				weekday('monday', '-1 week'), 
				weekday('monday')
			);
			break;
		case "weekbefore":
			$data = getDataFromGapi($getmode, $dimensions, $metrics, $orderby, 
				weekday('monday', '-2 week'), 
				weekday('monday', '-1 week')
			);
			break;
		case "thismonth":
			$data = getDataFromGapi($getmode, $dimensions, $metrics, $orderby, 
				date("Y-m-01"), 
				date("Y-m-d")
			);
			break;
		case "lastmonth":
			$data = getDataFromGapi($getmode, $dimensions, $metrics, $orderby, 
				date("Y-m-01", strtotime("-1 day", strtotime(date("Y-m-01")))), 
				date("Y-m-d", strtotime("-1 day", strtotime(date("Y-m-01"))))
			);
			break;
		case "monthbefore":
			$data = getDataFromGapi($getmode, $dimensions, $metrics, $orderby, 
				date("Y-m-01", strtotime("-1 month", strtotime("-1 month", strtotime(date("Y-m-01"))))), 
				date("Y-m-d", strtotime("-1 day", strtotime("-1 month", strtotime(date("Y-m-01")))))
			);
			break;
		default:
			break;
	}
	return $data;
}

function getDataFromGapi($getmode, $dimensions, $metrics, $orderby, $sd, $ed) {
	$values = array();
	
	try {
	$ga = new gapi($GLOBALS['em'],$GLOBALS['pw']);
	$ga->requestReportData($GLOBALS['ti'],
	   $dimensions,
	   $metrics,
	   $orderby, // Sort by 'visits' in descending order
	   '',
	   $sd, // Start Date
	   $ed, // End Date
	   1,  // Start Index
	   10 // Max results
	);
	
	if(strtolower($getmode)=='hitsonly') {
		$values['start-date'] = $sd;
		$values['end-date'] = $ed;
		$values['pageviews'] = $ga->getPageviews();
		if ($GLOBALS['uv']) {
			$values['visits'] = $ga->getVisitors();
		}
		else {
			$values['visits'] = $ga->getVisits();
		}
	}
	else {
		$values['start-date'] = $sd;
		$values['end-date'] = $ed;
		$values['real-data'] = $ga->getResults();
	}
	return $values;
	}
	catch(Exception $e) {
		$error_message = $e->getMessage();
		echo $error_message;
	}
}
?>