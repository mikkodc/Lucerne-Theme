<?php get_header();
$login  = (isset($_GET['login']) ) ? $_GET['login'] : 0;
?>

<div class="site-form login-form">
  <div class="center-content">
    <?php
    if ( $login === "failed" ) {
      echo '<p class="login-msg"><strong>ERROR:</strong> Invalid username and/or password.</p>';
    } elseif ( $login === "empty" ) {
      echo '<p class="login-msg"><strong>ERROR:</strong> Username and/or Password is empty.</p>';
    } elseif ( $login === "false" ) {
      echo '<p class="login-msg">You are now logged out.</p>';
    } elseif ( $_GET['action'] == 'reset_success' ) {
      echo '<p class="login-msg">Your password is reset. Check your email for your new password.</p>';
    }
    ?>
    <h4 class="form-title">Please log in:</h4>
    <?php $args = array(
      'redirect' => home_url(),
      'remember' => false,
      'id_username' => 'user',
      'id_password' => 'pass',
      'label_username' => __( 'Email Address' ),
      'label_log_in' => __( 'Login >' ),
    );
    wp_login_form( $args ); ?>
  </div>
</div>

<?php get_footer();
