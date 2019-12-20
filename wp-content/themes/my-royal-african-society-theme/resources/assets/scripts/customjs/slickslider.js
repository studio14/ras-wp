/* eslint-disable no-unused-vars */

// eslint-disable-next-line no-unused-vars
function toggleMenuNav() {
  var mySidenav = document.querySelector('#mySidenav');
  var body = document.querySelector('body');
  var nav = document.querySelector('nav');
  mySidenav.classList.toggle('full-width');
  body.classList.toggle('no-scroll');
  nav.classList.toggle('fixed');
  console.log(mySidenav.classList);
}