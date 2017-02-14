<?php

// Inserts Custom Meta value of Time on User Login
function add_login_date( $user_login, $user ) {
  $login_log = array();
  $curr_timelog = time();
  array_push($login_log, $curr_timelog);
  update_user_meta( $user->ID, 'last_login', $login_log );
}
add_action('wp_login', 'add_login_date', 10, 2);

// Get All Users
function fb_list_authors() {
  global $wpdb;

  $blogusers = get_users();

  $users = array();
  foreach ($blogusers as $author) {

    $post_meta = get_userdata( $author->ID );
    $name = "$post_meta->first_name $post_meta->last_name";
    $date = $post_meta->last_login;

    $users[] = array(
      'user_last_login' =>  $date,
      'user_firstname' => $post_meta->first_name,
      'user_lastname' => $post_meta->last_name,
      'user_fullname' => $name,
      'ID' => $author->ID
    );
  }

  // $date = date("M d, Y H:i a", $post_meta->last_login);

  array_multisort($users);
  $sorted = val_sort($users, 'user_last_login');

  foreach ($sorted as $authors) {
    $last_login = date("M d, Y H:i a", $authors['user_last_login']);
    if($last_login != null) {
      echo "<li>" .$authors['user_fullname']. " - " . $last_login . "</li>";
    }
  }

  // echo "<pre>";
  // print_r($sorted);
  // echo "</pre>";

}

// Widget last login time
add_action('wp_dashboard_setup', 'last_login_dates');

function last_login_dates() {
	global $wp_meta_boxes;

	wp_add_dashboard_widget('login_data_widget', 'Last 5 Login Dates', 'login_data');
}

function login_data() {
  echo "<ul>";
  fb_list_authors();
  echo "</ul>";

} ?>
