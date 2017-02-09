<?php
class dashboardReport {

  public function __construct() {
		add_action(
      'wp_ajax_changeReports',
      array($this, 'changeReports')
    );
    add_action(
      'wp_ajax_nopriv_changeReports',
      array($this, 'changeReports')
    );
	}

  public function changeReports() {

    $user = $_GET['client'];

    echo '<li>' . $user->display_name.' ['.$user->user_email.']</li>';
  }

} ?>
