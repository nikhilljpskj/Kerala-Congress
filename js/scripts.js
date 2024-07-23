var prevScrollpos = window.pageYOffset;
window.addEventListener("scroll", function () {
  var tag = document.querySelector(".rside-tag");
  var currentScrollPos = window.pageYOffset;
  if (prevScrollpos > currentScrollPos) {
    document.querySelector('.rside-tag').style.right = "0";
  }
  else {
    document.querySelector('.rside-tag').style.right = "-300px";
  }
  prevScrollpos = currentScrollPos;
})