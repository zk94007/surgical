//CORE JS FUNCTIONALITY
//Contains only the most essential functions for the theme. 

/* ==========================================================================
Mobile Menu Toggle
========================================================================== */
document.addEventListener('DOMContentLoaded', function () {
  var menu_element = document.getElementById('menu-mobile-open')
  var menu_exists = !!menu_element
  if (menu_exists) {
    menu_element.addEventListener('click', function () {
      document.body.classList.add('menu-mobile-active')
    })

    document.getElementById('menu-mobile-close').addEventListener('click', function () {
      document.body.classList.remove('menu-mobile-active')
    })
  }
})