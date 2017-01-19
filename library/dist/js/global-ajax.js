function Page () {
  this.page = 1;
  loading = true;
  $window = $(window);
  $content = $(".load-more");
}

Page.prototype = {
  constructor: Page,
  resetPage: function() {
    this.page == 1;
  },

  loadPosts: function() {
    $.ajax({
      type       : "GET",
      data       : {numPosts : 3, pageNumber: this.page},
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
              this.page++;
          } else  {
              $content.html('No more post to load.');
          }
      },
      error     : function(jqXHR, textStatus, errorThrown) {
          alert(jqXHR + " :: " + textStatus + " :: " + errorThrown);
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
