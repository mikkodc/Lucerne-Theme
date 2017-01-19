//Live Search Filter
$(document).on( 'submit', '.search-form', function() {
    var $form = $(this);
    var $input = $form.find('input[name="s"]');
    var query = $input.val();
    var $content = $('.other-articles')

    $.ajax({
        type : 'post',
        url : ajax_object.ajax_url,
        data : {
          action : 'load_search_results',
          query : query
        },
        beforeSend: function() {
          $input.prop('disabled', true);
          $('#preloader').show();
        },
        success : function( response ) {
          $input.prop('disabled', false);
          $content.html( response );
          $('#preloader').fadeOut();
          // console.log( response );
        },
        error: function(errorThrown){
          console.log(errorThrown);
        }
    });

    return false;
});

//Category Filter
$("body").on("click",".cat-bar ul li a",function(){
	var filter = $(this).data('term');

  $.ajax({
    type : 'get',
    url:ajax_object.ajax_url,
    data: {
      action : 'category_filter_function',
      filter: filter
    },
		beforeSend:function(data){
      $('#preloader').show();
		},
		success:function(data){
			$('.other-articles').html(data);
      $('#preloader').fadeOut();
		}
	});
	return false;
});
