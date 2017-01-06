$(document).ready(function(){

  //Sliding Reading List
  $(".reading-link").click(function(){
    $("#reading-list").removeClass("close");
  });
  $("#close-read-list").click(function(){
    $("#reading-list").addClass("close");
  });

  //Sticking Category Bar
  $("#myNav").affix({
      offset: {
        top: $("#main-header").outerHeight(true)
      }
  });

  //Filter Toggle
  $('#filter-btn').click(function(){
    $('.cat-bar').toggleClass('active');
  });

  //jQuery Media Queries
  if($(window).width() < 767) {
    $(".cat-bar").addClass("mobile-bar");
  } else {
    $(".cat-bar").removeClass("mobile-bar");
  }


});
