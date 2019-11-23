
function menuDrop() {
    var menu = document.getElementById("my-nav-menu");
    if (menu.className === "nav-menu") {
        menu.className += " nav-menu-mobile";
        menu.style.width = "70%";
    } else {
        menu.className = "nav-menu";
    }

}


function lgDrop() {
    document.getElementById("myDropdown").classList.toggle("show");
}



window.onscroll = function() { scrollFunc() };

function scrollFunc() {
    if (document.body.scrollTop > 120 || document.documentElement.scrollTop > 120) {
        document.getElementById("scroll-header").style.top = "0";
    } else {
        document.getElementById("scroll-header").style.top = "-200px";
    }
}
