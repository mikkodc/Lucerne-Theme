var articleId;

var currId;

var prevPage;

var pageHistory = [0];

$("body").on("click",".ajax-link",function(){

  articleId = $(this).data('id');

  currId = $(this).data('id');

  // alert(pageHistory);

  //Slide to Top
  $("html, body").animate({ scrollTop: 0 }, "slow");
  $('#intro-article').empty();

  //Slide Content Left
  $('#ajax-container').delay( 800 ).fadeOut();

  load_introArticle();

  pageHistory.push(articleId);

});

$("body").on("click","#back",function(){

  if(currId == articleId) {
    pageHistory.pop()

  }

  articleId = pageHistory.pop();

  alert(currId);

  if(articleId == 0) {
    $('#intro-article').fadeOut().empty();
    $("#back").css('display', 'none');
    $('#ajax-container').fadeIn();
  } else {
    load_introArticle();
  }

});

var load_introArticle = function(){
  $.ajax({
    type: "get",
    data: {
      'action': 'intro_article',
      article: articleId
      // article: 26
    },
    dataType: "html",
    url: ajax_object.ajax_url,
    beforeSend : function(){

    },
    success:function(data) {

      $('#intro-article').fadeOut().empty();

      $("#intro-article").append(data);

      $('#ajax-container').fadeOut();

      $("#intro-article").fadeIn();

      $("#back").css('display', 'block');

      // $('#back').click(function(){
      //   $('#intro-article').fadeOut().empty();
      //   $("#back").css('display', 'none');
      //   $('#ajax-container').fadeIn();
      // });
      // console.log(data);
    },
    error: function(errorThrown){
      console.log(errorThrown);
    }
  });
};

// load_introArticle();
