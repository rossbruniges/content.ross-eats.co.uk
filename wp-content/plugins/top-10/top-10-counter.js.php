<?php
//"top-10-counter.js.php" Display number of page views
Header("content-type: application/x-javascript");

if (!function_exists('add_action')) {
	$wp_root = '../../..';
	if (file_exists($wp_root.'/wp-load.php')) {
		require_once($wp_root.'/wp-load.php');
	} else {
		require_once($wp_root.'/wp-config.php');
	}
}

// Display counter using Ajax
function tptn_disp_count() {
	global $wpdb;
	
	$table_name = $wpdb->prefix . "top_ten";
	$table_name_daily = $wpdb->prefix . "top_ten_daily";
	$tptn_settings = tptn_read_options();
	$count_disp_form = stripslashes($tptn_settings[count_disp_form]);
	
	$id = intval($_GET['top_ten_id']);
	if($id > 0) {

		$resultscount = $wpdb->get_row("SELECT postnumber, cntaccess FROM ".$table_name." WHERE postnumber = ".$id);
		$cntaccess = number_format((($resultscount) ? $resultscount->cntaccess : 1));
		$count_disp_form = str_replace("%totalcount%", $cntaccess, $count_disp_form);
		
		// Now process daily count
		$daily_range = $tptn_settings[daily_range];
		$current_time = gmdate( 'Y-m-d', ( time() + ( get_option( 'gmt_offset' ) * 3600 ) ) );
		$current_date = strtotime ( '-'.$daily_range. ' DAY' , strtotime ( $current_time ) );
		$current_date = date ( 'Y-m-j' , $current_date );

		$resultscount = $wpdb->get_row("SELECT postnumber, SUM(cntaccess) as sumCount FROM ".$table_name_daily." WHERE postnumber = ".$id." AND dp_date >= '".$current_date."' GROUP BY postnumber ");
		$cntaccess = number_format((($resultscount) ? $resultscount->sumCount : 1));
		$count_disp_form = str_replace("%dailycount%", $cntaccess, $count_disp_form);
		
		echo 'document.write("'.$count_disp_form.'")';
	}
}
tptn_disp_count();
?>