<?php

class mainAjax {

  /**
   * Initialize Global Properties
   */
  public $ajaxFilter;
  public $introArticle;
  public $readingList;

  public function __construct() {
    $this->ajaxFilter = new ajaxFilter();
    $this->introArticle = new introArticle();
    $this->readingList = new readingList();
  }
}

/**
 * Loads All Ajax Filters including (Search & Category filter)
 */
include_once( 'includes/ajax-filter.php' );

/**
 * Loads Changing Ajax Page
 */
include_once( 'includes/intro-article.php' );

/**
 * Loads Reading List Module
 */
include_once( 'includes/reading-list.php' );

/**
 * Instantiates the main class
 */
function startAjax() {
  $ajaxObject = new mainAjax;
}
startAjax();
?>
