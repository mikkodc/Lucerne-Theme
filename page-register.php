<?php
get_header()
?>

<div class="site-form login-form">
  <div class="center-content">
	<?php
	$err = '';
	$success = '';

  $email = $_GET['email'];

  if(email_exists($email)) {
    $err = 'Email already exist.';
  }

	global $wpdb, $PasswordHash, $current_user, $user_ID;

	if(isset($_POST['task']) && $_POST['task'] == 'register' ) {


		$pwd = $wpdb->escape(trim($_POST['pwd']));
		$email = $wpdb->escape(trim($_POST['email']));

		if( $pwd == "" ) {
			$err = 'Please enter a password.';
		} else if(email_exists($email) ) {
			$err = 'Email already exist.';
		} else {

			$user_id = wp_insert_user(
        array (
          'user_pass' => apply_filters('pre_user_user_pass', $pwd),
          'user_login' => apply_filters('pre_user_user_login', $email),
          'user_email' => apply_filters('pre_user_user_login', $email),
          'role' => 'subscriber'
        )
      );

			if( is_wp_error($user_id) ) {
				$err = 'Error on user creation.';
			} else {
        $url = get_bloginfo('url');
				do_action('user_register', $user_id);

				$success = 'You\'ve successfully registered';
			}
      // wp_redirect( $url );
      // exit;
		}
	}
	?>
  <!--display error/success message-->
	<?php
		if(! empty($err) ) :
			echo '<p class="login-msg">'.$err.'';
		endif;
	?>

	<?php
		if(! empty($success) ) :
			echo '<p class="login-msg">'.$success.'';
		endif;
	?>

  <h2 class="site-title">Welcome</h2>
  <h3 class="sub-title">You have been invited to access the Lucerne Investment Partners Investor Library.</h3>
  <h4 class="form-title">Please choose a password.</h4>
	<form method="post">
		<p>
      <label>Password</label>
      <input type="password" value="" name="pwd" id="pwd" />
    </p>
    <input type="hidden" name="email" value="<?php echo $_GET['email'] ?>" />
		<button type="submit" name="btnregister" class="btn btn-default" >Submit ></button>
		<input type="hidden" name="task" value="register" />
	</form>

</div>
</div>
<?php get_footer()
// Source
// } http://www.sutanaryan.com/wordpress-custom-registration-without-using-a-plugin/
?>
