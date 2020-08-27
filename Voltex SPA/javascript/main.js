//Javascript for Voltex SPAnpm install -g express-generator
//history.back()
//history.forward() for going back and forward in website

// window.onscroll = function() {
// console.log('Scrolling');
//   // Get the header
// var header = document.getElementById("header");
// // Get the offset position of the navbar
// var headeroffset = header.offsetTop;

// // Add the sticky class to the header when you reach its scroll position. Remove "sticky" when you leave the scroll position
//   if (window.pageYOffset > headeroffset) {
//     header.classList.add("sticky");
//   } else {
//     header.classList.remove("sticky");
//   }

// };
$(function () {
   $('[data-toggle="popover"]').popover();
   });

$(document).ready(function(){
   $('#banner').fadeIn('slow');
  
   $('h2').hover(function(){
    $(this).addClass('bigger');
   },function(){
    $(this).removeClass('bigger');
   });

   $('.footImg').hover(function(){
      $(this).addClass('ImgBigger');
     },function(){
      $(this).removeClass('ImgBigger');
     });


}); 



 
 
 
 
 
 