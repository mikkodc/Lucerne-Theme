var articleId;
var currId;
var pageHistory = [0];
var pageType = "";
var buttonType = "";

$("body").on("click",".btn-view-download",function(){
  articleId = $(this).data('id');
  currId = articleId;

  if($(this).hasClass('ajax-link')) {
    pageType = "linked";
    $('.header-type').addClass('linked-article');
    $(".back-linked").fadeIn(500);
    load_introArticle();
  } else {
    add_view();
  }

});

$("body").on("click",".back",function(){

  //Reset Button Type
  buttonType = "back";
  currId = articleId;

  if($('.header-type').hasClass('linked-article')) {
    $('.header-type').removeClass('linked-article');
    $(".back-linked").fadeOut(500);
    pageType = "";
  }

  // //Changed the header back to its normal state
  // if($('.header-type').hasClass('linked-article')) {
  //   $('.header-type').removeClass('linked-article');
  //   $(".back-linked").fadeOut(500);
  //   pageType = "";
  // } else {
  //   //Remove the current value if equals to current page id
  //   if(currId == articleId) {
  //     pageHistory.pop();
  //
  //   }
  // }
  //
  // if(articleId == 0) {
  //   articleId = pageHistory.push(0);
  //   $(".back").fadeOut(500);
  //
  // } else {
  //   articleId = pageHistory.pop();
  //   if(articleId == 0) {
  //     $(".back").fadeOut(500);
  //   }
  // }

  load_introArticle();

  // alert('Current page ID is '+ currId +' Article ID is '+ articleId +' Page history now contains '+ pageHistory);

});

function load_introArticle() {
  $.ajax({
    type: "get",
    data: {
      'action': 'intro_article',
      article: articleId,
      articleType : pageType,
      button : buttonType,
    },
    dataType: "html",
    url: ajax_object.ajax_url,
    beforeSend : function(){

      //Slide to Top
      $("html, body").animate({ scrollTop: 0 }, "slow");

      //Empty the container and append loading gif
      $('#ajax-container').empty();
      $('#ajax-container').append('<img src="'+ templateDir +'/library/src/img/ajax-loader.gif" class="preload-gif" alt="preloader">');

    },
    success:function(data) {

      //Append data and remove the loading gif
      $(data).hide().appendTo('#ajax-container').fadeIn(500).css('display', 'block');
      $('#ajax-container .preload-gif').fadeOut(500).remove();

      // console.log(data);
    },
    error: function(errorThrown){
      console.log(errorThrown);
    }
  });
};

function add_view() {
  $.ajax({
    type: "get",
    data: {
      'action': 'add_view',
      article: articleId,
      articleType : pageType,
      button : buttonType,
    },
    dataType: "html",
    url: ajax_object.ajax_url,
    success:function(data) {
      console.log(data);
    },
    error: function(errorThrown){
      console.log(errorThrown);
    }
  });
};
