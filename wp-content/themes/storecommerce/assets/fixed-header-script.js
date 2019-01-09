jQuery(document).ready(function($){

    // Here You can type your custom JavaScript...

    window.onscroll = function() {myFunction()};
    var prevScrollPos = window.pageYOffset;
    var aboveHeader = document.getElementById("above-banner-section-wrapper");
    var aboveHeaderHeight = 0;
        if (typeof(element) != 'undefined' && element != null)
            {
              aboveHeaderHeight = aboveHeader.offsetHeight;
            }

    var header = document.getElementById("site-primary-navigation");
    var sticky = header.offsetTop + aboveHeaderHeight + 75;
    //console.log(sticky);

    function myFunction() {

        var currentScrollPos = window.pageYOffset;
         //console.log(currentScrollPos);
        // console.log(prevScrollPos);
        if ( prevScrollPos > currentScrollPos ) {
        if (sticky > currentScrollPos) {
            //console.log('here we go');
            header.classList.remove("aft-sticky-navigation");
        } else {
            header.classList.add("aft-sticky-navigation");
        }
        }else{
            header.classList.remove("aft-sticky-navigation");
        }
        prevScrollPos = currentScrollPos;
    }



});


