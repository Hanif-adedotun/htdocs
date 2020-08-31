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
$(document).ready(function(){
   
   logoFadeIn();
   footer_text();

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

function logoFadeIn(){
   $('#head-logo')
   .hide('slow')
   .show('slow');
    
}

$(function () {
   $('[data-toggle="popover"]').popover();
   });

function footer_text(){
   // Display the footer text with current year
   var text_element = document.getElementById('footer-text');
   var current_year = new Date().getFullYear();
   console.log(current_year);
   text_element.innerHTML = '&copy;' + ' Voltex Designs ' + current_year;
   }






 
 
 
 
 
 