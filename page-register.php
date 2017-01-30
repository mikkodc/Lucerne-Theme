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


		$pwd1 = $wpdb->escape(trim($_POST['pwd1']));
		$pwd2 = $wpdb->escape(trim($_POST['pwd2']));
		$email = $wpdb->escape(trim($_POST['email']));
		$firstname = $wpdb->escape(trim($_POST['first_name']));
		$lastname = $wpdb->escape(trim($_POST['last_name']));
		$username = $wpdb->escape(trim($_POST['username']));

		if( $pwd1 == "" ) {
			$err = 'Please enter a password.';
		} else if($pwd1 <> $pwd2 ){
      $err = 'Password do not match.';
    }  else if(email_exists($email) ) {
			$err = 'Email already exist.';
		} else {

			$user_id = wp_insert_user(
        array (
          'user_pass' => apply_filters('pre_user_user_pass', $pwd1),
          'user_login' => apply_filters('pre_user_user_login', $username),
          'user_email' => apply_filters('pre_user_user_login', $email),
          'first_name' => apply_filters('pre_user_user_login', $firstname),
          'last_name' => apply_filters('pre_user_user_login', $lastname),
          'role' => 'subscriber'
        )
      );

			if( is_wp_error($user_id) ) {
				$err = 'Error on user creation.';
			} else {
        // $url = get_bloginfo('url');
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

  <!-- <script type="text/javascript">
    var jQuery = jQuery.noConflict();
    jQuery(window).load(function(){
      jQuery('#register-form').submit(function() {
        // change visual indicators
        jQuery('.loading').show();
        jQuery('.submit input').attr('disabled', 'disabled');
        // validate and process form here
        var str = jQuery(this).serialize();
           jQuery.ajax({
             type: 'POST',
             url: '<?php echo admin_url( 'admin-ajax.php' ); ?>',
             data: str,
             success: function(msg) {
              jQuery('#invfr_note').ajaxComplete(function(event, request, settings) {
                msg = msg.replace(/(\s+)?.$/, "");
                if( msg == 'sent' ) {
                  result = '<div class="updated"><p><?php _e( 'Your invitation has been sent! Send another?', 'invfr' ); ?></p></div>';
                  jQuery('#invfr_form input[type=text], #invfr_form input[type=email]').val('');
                } else {
                  //loop through the error items to indicate which fields have errors
                  msg = msg.replace(/[\[\]']+/g,'');
                  msg = msg.split(',');
                  jQuery.each( msg, function ( i, id ) {
                    id = id.replace(/["']{1}/g, '');
                    jQuery(id).parent('td').addClass('error');
                  });
                  result = '<div class="error"><p><?php _e( '<strong>ERROR:</strong> Check your form for the errors which are highlighted below.', 'invfr' ); ?></p></div>';
                  //result = msg;
                  msg = '';
                }
                jQuery(this).html(result);
                // visual indicators
                jQuery('.loading').hide();
                jQuery('.submit input').removeAttr('disabled');
              });
            }
          });
        return false;
      });
    });
  </script> -->

  <h2 class="site-title">Welcome</h2>
  <h3 class="sub-title">You have been invited to access the Lucerne Investment Partners Investor Library.</h3>
  <h4 class="form-title">Please choose a password.</h4>
	<form method="post" name="register-form" id="register-form">
		<p>
      <label>Password: </label>
      <input type="password" value="" name="pwd1" id="pwd1" />
    </p>
		<p>
      <label>Repeat Password: </label>
      <input type="password" value="" name="pwd2" id="pwd2" />
    </p>
    <input type="hidden" name="email" value="<?php echo $_GET['email'] ?>" />
    <input type="hidden" name="first_name" value="<?php echo $_GET['first_name'] ?>" />
    <input type="hidden" name="last_name" value="<?php echo $_GET['last_name'] ?>" />
    <input type="hidden" name="username" value="<?php echo $_GET['username'] ?>" />
		<button type="submit" name="btnregister" class="btn btn-default" >Submit ></button>
		<input type="hidden" name="task" value="register" />
	</form>

</div>
</div>
<?php get_footer()
// Source
// } http://www.sutanaryan.com/wordpress-custom-registration-without-using-a-plugin/
?>
