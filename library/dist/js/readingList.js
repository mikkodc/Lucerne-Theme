var articleId;
var readingButton;
var readingEmpty = $("#readlist-container").is(':empty');

if(!readingEmpty) {
  $(this).children('is-empty').removeClass('no')
}

$("body").on("click",".add-to-list",function(){

  readingButton = $(this);
  articleId = $(this).data('id');

  add_to_reading_list();
  check_read_list();
});

var add_to_reading_list = function(){
  $.ajax({
    type: "get",
    data: {
      'action': 'insert_reading_list',
      article: articleId
    },
    dataType: "html",
    url: ajax_object.ajax_url,
    beforeSend : function(){

    },
    success:function(data) {
      $(readingButton).removeClass("add-to-list").addClass("remove-to-list");
      $(readingButton).html('<span class="glyphicon glyphicon-minus"></span> Remove from List');
      $("#reading-list").removeClass("close");
      $("#readlist-container").append(data);
      // console.log(data);
    },
    error: function(errorThrown){
      console.log(errorThrown);
    }
  });
};

$("body").on("click",".remove-to-list",function(){

  readingButton = $(this);

  articleId = $(this).data('id');

  var $div = $("#reading-list .item-container").filter(function() {
    return $(this).data("id") == articleId;
  });

  $div.fadeOut();

  remove_to_reading_list();
  check_read_list();
});

var remove_to_reading_list = function(){
  $.ajax({
    type: "get",
    data: {
      'action': 'remove_reading_list',
      article: articleId
    },
    dataType: "html",
    url: ajax_object.ajax_url,
    beforeSend : function(){

    },
    success:function(data) {
      $(readingButton).removeClass("remove-to-list").addClass("add-to-list");
      $(readingButton).html('<span class="glyphicon glyphicon-plus"></span> Reading List');
      $("#reading-list").removeClass("close");
      // console.log(data);
    },
    error: function(errorThrown){
      console.log(errorThrown);
    }
  });
};

$("document").ready(function(){
  init_reading_list();
  check_read_list();
});

function init_reading_list() {
  $.ajax({
    type: "get",
    data: {
      'action': 'init_reading_list',
      // article: articleId
    },
    dataType: "html",
    url: ajax_object.ajax_url,
    beforeSend : function(){

    },
    success:function(data) {
      $("#reading-list").append(data);
      // console.log(data);
    },
    error: function(errorThrown){
      console.log(errorThrown);
    }
  });
};

//Check if Reading List is empty
function check_read_list() {
  if(!readingEmpty) {
    $(this).children('is-empty').removeClass('no-content');
  } else {
    $(this).children('is-empty').addClass('no-content');
  }
}
