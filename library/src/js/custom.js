function toggleFilter() {
  $('#filter-btn').children('span').toggleClass('glyphicon glyphicon-triangle-bottom glyphicon glyphicon-triangle-top');
  $('.cat-bar .row > ul').slideToggle(300);
}

$(document).ready(function(){

  //Back Button
  $('.back-ajax').click(function(){
    goBack();
  });

  function goBack() {
    window.history.go(-1);
  }

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

  //Search Toggle
  $('.search-icon').click(function(){
    $('.toggle-search').slideToggle(300);
  });

  //jQuery Media Queries
  if($(window).width() < 767) {

    //Filter Toggle
    $('#filter-btn').click(function(){
      toggleFilter();
    });

    $('.cat-bar .row > ul > li').each(function(){
      if($(this).children('ul').length > 0) {
        $(this).append('<span class="sidebar-menu-arrow add"></span>');

        $(this).children('span').click(function(e){
          e.preventDefault();

          var $parentli = $(this).closest('li');
          $parentli.siblings('li').find('ul:visible').slideUp();
          $parentli.siblings('li').find('span').removeClass('minus').addClass('add');

          $(this).toggleClass('add minus');
          $(this).siblings('ul').slideToggle(300);
        });
      }
    });

    $('.cat-bar a').click(function(){
      if($(this).siblings('span').hasClass('minus')) {
        $(this).siblings('span').removeClass('minus').addClass('add');
        $(this).siblings('ul').slideToggle(300);
      }

      toggleFilter();
    });

  } else {
    $(".cat-bar").removeClass("mobile-bar");
  }

});
