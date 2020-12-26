$(document).ready(function () {

   $("#scrollToTop").click(function(){
      $('body,html').animate({scrollTop: 0}, 700);
   });
});



// Toggle between showing and hiding the sidebar, and add overlay effect
function w3_open() {
   var mySidebar = document.getElementById("mySidebar");
   var overlayBg = document.getElementById("myOverlay");

   if (mySidebar.style.display === 'block') {
      mySidebar.style.display = 'none';
      overlayBg.style.display = "none";
   } else {
      mySidebar.style.display = 'block';
      overlayBg.style.display = "block";
   }
}

// Close the sidebar with the close button
function w3_close() {
   var mySidebar = document.getElementById("mySidebar");
   var overlayBg = document.getElementById("myOverlay");

   mySidebar.style.display = "none";
   overlayBg.style.display = "none";
}
