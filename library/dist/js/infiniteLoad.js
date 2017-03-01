function Page () {
  this.pageNum = 1;

  var self = this;

  loading = true;
  $window = $(window);
  $content = $(".load-more");
  argType = "";

  // if($('.cat-bar').click()) {
  //   argType = "Category";
  //   alert(argType);
  // }

  this.loadPosts = function loadPosts(arg) {
    if(typeof arg != "undefined") {
      self.pageNum = arg;
    }

    $.ajax({
      type       : "GET",
      data       : {numPosts : 3, pageNumber: self.pageNum, argType: argType},
      dataType   : "html",
      url        : templateDir+"/loopHandler.php",
      beforeSend : function(){
          $content.html('Loading..');
      },
      success    : function(data){
          $data = $(data);
          if($data.length){
              $data.hide();
              $(".other-articles").append($data);
              $data.fadeIn(500, function(){
                  loading = false;
                  $content.html('Load more');
              });
              self.pageNum++;
          } else  {
              $content.html('No more post to load.');
          }
      },
      error     : function(jqXHR, textStatus, errorThrown) {
          // alert(jqXHR + " :: " + textStatus + " :: " + errorThrown);
      }
    });
  }
}

var init = new Page();
var events = new Events();
init.loadPosts();

function Events () {
  $window.scroll(function() {
    var content_offset = $content.offset();
    if(!loading && ($window.scrollTop() +
      $window.height()) > ($content.scrollTop() +
      $content.height() + content_offset.top)) {
        loading = true;
        init.loadPosts();
    }
  });
}
