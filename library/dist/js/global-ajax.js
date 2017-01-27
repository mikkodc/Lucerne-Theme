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
