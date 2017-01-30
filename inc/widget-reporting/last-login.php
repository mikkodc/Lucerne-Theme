<?php function add_login_date( $user_login, $user ) {
    update_user_meta( $user->ID, 'last_login', time() );
}
add_action('wp_login', 'add_login_date', 10, 2);

 // Get All Users
 function fb_list_authors($userlevel = 'all', $show_fullname = true) {
	global $wpdb;

  $author_subscriper = $wpdb->get_results("SELECT * from $wpdb->usermeta WHERE meta_key = 'wp_capabilities' AND meta_value = 'a:1:{s:10:\"subscriber\";b:1;}'");
	foreach ( (array) $author_subscriper as $author ) {
		$author    = get_userdata( $author->user_id );
		$userlevel = $author->wp2_user_level;
		$name      = $author->nickname;
		$date      = date("M d, Y H:i a", $author->last_login);
		if ( $show_fullname && ($author->first_name != '' && $author->last_name != '') ) {
			$name = "$author->first_name $author->last_name";
		}
		$link = '<li>' . $name . ' - ' . $date . '</li>';
		echo $link;
	}

	$i = 0;
	while ( $i <= 10 ) {
		$userlevel = $i;
		$authors = $wpdb->get_results("SELECT * from $wpdb->usermeta WHERE meta_key = 'wp_user_level' AND meta_value = '$userlevel'");
    // echo '<pre>';
    // var_dump($authors);
    // echo '</pre>';
		foreach ( (array) $authors as $author ) {
			$author    = get_userdata( $author->user_id );
			$userlevel = $author->wp_user_level;
			$name      = $author->nickname;
      $date      = date("M d, Y H:i a", $author->last_login);
			if ( $show_fullname && ($author->first_name != '' && $author->last_name != '') ) {
				$name = "$author->first_name $author->last_name";
			}
			$link = '<li>' . $name . ' - ' . $date . '</li>';
			echo $link;
		}
		$i++;
	}


/*
 all = Display all user
 1 = subscriber
 2 = editor
 3 = author
 7 = publisher
10 = administrator
*/

// if ( $userlevel == 'all' ) {
// 	$author_subscriper = $wpdb->get_results("SELECT * from $wpdb->usermeta WHERE meta_key = 'wp_capabilities' AND meta_value = 'a:1:{s:10:\"subscriber\";b:1;}'");
// 	foreach ( (array) $author_subscriper as $author ) {
// 		$author    = get_userdata( $author->user_id );
// 		$userlevel = $author->wp2_user_level;
// 		$name      = $author->nickname;
// 		$date      = date("M d, Y H:i a", $author->last_login);
// 		if ( $show_fullname && ($author->first_name != '' && $author->last_name != '') ) {
// 			$name = "$author->first_name $author->last_name";
// 		}
// 		$link = '<li>' . $name . ' - ' . $date . '</li>';
// 		echo $link;
// 	}
//
// 	$i = 0;
// 	while ( $i <= 10 ) {
// 		$userlevel = $i;
// 		$authors = $wpdb->get_results("SELECT * from $wpdb->usermeta WHERE meta_key = 'wp_user_level' AND meta_value = '$userlevel'");
// 		foreach ( (array) $authors as $author ) {
// 			$author    = get_userdata( $author->user_id );
// 			$userlevel = $author->wp2_user_level;
// 			$name      = $author->nickname;
//       $date      = date("M d, Y H:i a", $author->last_login);
// 			if ( $show_fullname && ($author->first_name != '' && $author->last_name != '') ) {
// 				$name = "$author->first_name $author->last_name";
// 			}
// 			$link = '<li>' . $name . ' - ' . $date . '</li>';
// 			echo $link;
// 		}
// 		$i++;
// 	}
// } else {
// 	if ($userlevel == 1) {
// 		$authors = $wpdb->get_results("SELECT * from $wpdb->usermeta WHERE meta_key = 'wp_capabilities' AND meta_value = 'a:1:{s:10:\"subscriber\";b:1;}'");
// 	} else {
// 		$authors = $wpdb->get_results("SELECT * from $wpdb->usermeta WHERE meta_value = '$userlevel'");
// 	}
// 	foreach ( (array) $authors as $author ) {
// 		$author = get_userdata( $author->user_id );
// 		$userlevel = $author->wp2_user_level;
//     $date      = date("M d, Y H:i a", $author->last_login);
// 		$name = $author->nickname;
// 		if ( $show_fullname && ($author->first_name != '' && $author->last_name != '') ) {
// 			$name = "$author->first_name $author->last_name";
// 		}
// 		$link  = '<li><b>' . $userlevelname[$userlevel] . '</b></li>';
// 		$link = '<li>' . $name . ' - ' . $date . '</li>';
// 		echo $link;
// 	}
// }
}

// Widget last login time
add_action('wp_dashboard_setup', 'last_login_dates');

function last_login_dates() {
	global $wp_meta_boxes;

	wp_add_dashboard_widget('login_data_widget', 'Last 5 Login Dates', 'login_data');
}

function login_data() {

  fb_list_authors();

  // $wp_user_search = $wpdb->get_results("SELECT ID, display_name FROM $wpdb->users ORDER BY ID");
  //
  // foreach ( $wp_user_search as $userid ) {
  // 	$user_id       = (int) $userid->ID;
  // 	$user_login    = stripslashes($userid->user_login);
  // 	$display_name  = stripslashes($userid->display_name);
  //
  // 	$return  = '';
  // 	$return .= "\t" . '<li>'. $display_name .'</li>' . "\n";
  //
  // 	print($return);
  // }
} ?>
