$(document).ready(function() {
  $('#previous').on('click', function(){
    // Change to the previous image
    $('#im_' + currentImage).stop().fadeOut(1);
    decreaseImage();
    $('#im_' + currentImage).stop().fadeIn(1);
  }); 
  $('#next').on('click', function(){
    // Change to the next image
    $('#im_' + currentImage).stop().fadeOut(1);
    increaseImage();
    $('#im_' + currentImage).stop().fadeIn(1);
  }); 

  var currentImage = 1;
  var totalImages = 3;

  function increaseImage() {
    ++currentImage;
    if(currentImage > totalImages) {
      currentImage = 1;
    }
  }
  function decreaseImage() {
    --currentImage;
    if(currentImage < 1) {
      currentImage = totalImages;
    }
  }
});