var page = 2;
var loading = true;
var $window = $(window);
var $content = $(".load-more");

function loadPosts() {

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

}

function loadScroll() {
  alert('test');
  $window.scroll(function() {
    var content_offset = $content.offset();
    if(!loading && ($window.scrollTop() +
      $window.height()) > ($content.scrollTop() +
      $content.height() + content_offset.top)) {
        loading = true;
        loadPosts();
    }
  });
}

loadScroll();
loadPosts();

$(document).on(".load-more", "click", function(){
  // alert("clicked");
  loadPosts();
});
$("body").on("click",".ajax-link",function(){
  page = 1;
});
