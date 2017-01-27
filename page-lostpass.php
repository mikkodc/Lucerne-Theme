<?php
global $wpdb, $user_ID;

function tg_validate_url() {

  global $post;

  $err = '';
  $success = '';

	$page_url = esc_url(get_permalink( $post->ID ));
	$urlget = strpos($page_url, "?");

  if ($urlget === false) {
		$concate = "?";
	} else {
		$concate = "&";
	}
	return $page_url.$concate;
}

	if(isset($_GET['key']) && $_GET['action'] == "reset_pwd") {
		$reset_key = $_GET['key'];
		$user_login = $_GET['login'];
		$user_data = $wpdb->get_row($wpdb->prepare("SELECT ID, user_login, user_email FROM $wpdb->users WHERE user_activation_key = %s AND user_login = %s", $reset_key, $user_login));

		$user_login = $user_data->user_login;
		$user_email = $user_data->user_email;

		if(!empty($reset_key) && !empty($user_data)) {
			$new_password = wp_generate_password(7, false);

			wp_set_password( $new_password, $user_data->ID );

			//mailing reset details to the user
			$message = __('Your new password for the account at:') . "\r\n\r\n";
			$message .= get_option('siteurl') . "\r\n\r\n";
			$message .= sprintf(__('Username: %s'), $user_login) . "\r\n\r\n";
			$message .= sprintf(__('Password: %s'), $new_password) . "\r\n\r\n";
			$message .= __('You can now login with your new password at: ') . get_option('siteurl')."/login" . "\r\n\r\n";

			if ( $message && !wp_mail($user_email, 'Password Reset Request', $message) ) {
				$err = 'Email failed to send for some unknown reason';
			}
			else {
				$redirect_to = get_bloginfo('url')."/login?action=reset_success";
				wp_safe_redirect($redirect_to);
			}
		}
		else {
      $err = 'Not a valid key.';
    }
	}
	//exit();

	if($_POST['action'] == "tg_pwd_reset"){
    //We shall SQL escape the input
    $user_input = $wpdb->escape(trim($_POST['user_input']));

    if(empty($_POST['user_input'])) {
			$err = 'Please enter your Email address';
		} else if ( strpos($user_input, '@') ) {
			$user_data = get_user_by_email($user_input);
			if(empty($user_data) || $user_data->caps[administrator] == 1) { //delete the condition $user_data->caps[administrator] == 1, if you want to allow password reset for admins also
				$err = 'Invalid E-mail address!';
			}
		}
		else {
			$user_data = get_userdatabylogin($user_input);
			if(empty($user_data) || $user_data->caps[administrator] == 1) { //delete the condition $user_data->caps[administrator] == 1, if you want to allow password reset for admins also
				$err = 'Invalid E-mail address!';
			}
		}

		$user_login = $user_data->user_login;
		$user_email = $user_data->user_email;

		$key = $wpdb->get_var($wpdb->prepare("SELECT user_activation_key FROM $wpdb->users WHERE user_login = %s", $user_login));
		if(empty($key)) {
			//generate reset key
			$key = wp_generate_password(20, false);
			$wpdb->update($wpdb->users, array('user_activation_key' => $key), array('user_login' => $user_login));
		}

		//mailing reset details to the user
		$message = __('Someone requested that the password be reset for the following account:') . "\r\n\r\n";
		$message .= get_option('siteurl') . "\r\n\r\n";
		$message .= sprintf(__('Username: %s'), $user_login) . "\r\n\r\n";
		$message .= __('If this was a mistake, just ignore this email and nothing will happen.') . "\r\n\r\n";
		$message .= __('To reset your password, visit the following address:') . "\r\n\r\n";
		$message .= tg_validate_url() . "action=reset_pwd&key=$key&login=" . rawurlencode($user_login) . "\r\n";

		if ( $message && wp_mail($user_email, 'Password Reset Request', $message) ) {
			$success = 'We have just sent you an email with Password reset instructions.';
		}

	}

get_header(); ?>
<div class="site-form login-form">
  <div class="center-content">

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
      <h4 class="form-title">To reset your password, please enter your email address:</h4>
			<form class="user_form" id="wp_pass_reset" action="" method="post">
  			<p>
          <label>Email Address</label>
  			  <input type="text" class="text" name="user_input" value="" />
  			</p>
  			<input type="hidden" name="action" value="tg_pwd_reset" />
  			<input type="hidden" name="tg_pwd_nonce" value="<?php echo wp_create_nonce("tg_pwd_nonce"); ?>" />
  			<input type="submit" id="submitbtn" class="reset_password" name="submit" value="Submit" />
			</form>
      <p>Need help? <a href="#" class="inline-block">Contact us</a>.</p>
    </div><!-- content -->
  </div>
<?php get_footer();
//Source: http://www.tutorialstag.com/wordpress-custom-password-reset-page-template.html#codesyntax_2
?>
