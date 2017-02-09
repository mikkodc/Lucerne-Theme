clientID = 0;

jQuery("body").on("click",".select-users a",function(){
  clientID = jQuery(this).data('id');

  change_values();
});
// var articleId;
// var currId;
// var pageHistory = [0];
// var pageType = "";
// var buttonType = "";
//
// jQuery("body").on("click",".btn-view-download",function(){
//   buttonType = "view-download";
//   load_introArticle();
// });
//
// jQuery("body").on("click",".ajax-link",function(){
//
//   if(jQuery(this).hasClass('btn-view-download')) {
//     buttonType = "view-download";
//   }
//
//   //If view article button click
//   if(jQuery(this).hasClass('linked-link')) {
//
//     jQuery('.header-type').addClass('linked-article');
//     jQuery(".back-linked").fadeIn(500).css('display', 'block');
//
//     pageType = "linked";
//
//     currId = currId;
//
//     articleId = articleId;
//
//   } else {
//
//     if(jQuery.isEmptyObject(pageHistory)) {
//       pageHistory.push(0);
//     }
//
//     articleId = jQuery(this).data('id');
//
//     currId = jQuery(this).data('id');
//
//     jQuery(".back-ajax").fadeIn(500).css('display', 'block');
//
//   }
//
//   load_introArticle();
//
//   pageHistory.push(articleId);
//
//   // alert('Current page ID is '+ currId +' Article ID is '+ articleId +' Page history now contains '+ pageHistory);
//
// });
//
// jQuery("body").on("click",".back",function(){
//
//   //Reset Button Type
//   buttonType = "";
//
//   //Changed the header back to its normal state
//   if(jQuery('.header-type').hasClass('linked-article')) {
//     jQuery('.header-type').removeClass('linked-article');
//     jQuery(".back-linked").fadeOut(500);
//     pageType = "";
//   } else {
//     //Remove the current value if equals to current page id
//     if(currId == articleId) {
//       pageHistory.pop();
//
//     }
//   }
//
//   if(articleId == 0) {
//     articleId = pageHistory.push(0);
//     jQuery(".back").fadeOut(500);
//
//   } else {
//     articleId = pageHistory.pop();
//     if(articleId == 0) {
//       jQuery(".back").fadeOut(500);
//     }
//   }
//
//   load_introArticle();
//
//   // alert('Current page ID is '+ currId +' Article ID is '+ articleId +' Page history now contains '+ pageHistory);
//
// });
//
function change_values() {
  jQuery.ajax({
    type: "get",
    data: {
      'action': 'my_action',
      client: clientID,
    },
    dataType: "html",
    beforeSend : function(){

      //Slide to Top
      jQuery("html, body").animate({ scrollTop: 0 }, "slow");

      //Empty the container and append loading gif
      jQuery('#ajax-container').empty();
      // jQuery('#ajax-container').append('<img src="'+ templateDir +'/library/src/img/ajax-loader.gif" class="preload-gif" alt="preloader">');

    },
    success:function(data) {

      //Append data and remove the loading gif
      // jQuery(data).hide().appendTo('#ajax-container').fadeIn(500).css('display', 'block');
      // jQuery('#ajax-container .preload-gif').fadeOut(500).remove();

      console.log(data);
    },
    error: function(errorThrown){
      console.log(errorThrown);
    }
  });
};
