var page = 1;
var loading = true;
var $window = $(window);
var $content = $(".load-more");
var load_posts = function(){
  $.ajax({
    type       : "GET",
    data       : {numPosts : 3, pageNumber: page},
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
            page++;
        } else  {
            $content.html('No more post to load.');
        }
    },
    error     : function(jqXHR, textStatus, errorThrown) {
        alert(jqXHR + " :: " + textStatus + " :: " + errorThrown);
    }
  });
};

$window.scroll(function() {
  var content_offset = $content.offset();
  if(!loading && ($window.scrollTop() +
    $window.height()) > ($content.scrollTop() +
    $content.height() + content_offset.top)) {
      loading = true;
      load_posts();
  }
});

load_posts();

$(document).delegate(".load-more", "click", function(){
  // alert("clicked");
  load_posts();
});
$("body").on("click",".ajax-link",function(){
  page = 1;
  //alert('Page changed! The page is now reset to'+ page);
});
