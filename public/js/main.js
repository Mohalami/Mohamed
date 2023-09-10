
document.addEventListener('DOMContentLoaded', function() {
    const menuburger = document.querySelector(".menuburger");
    const navlinks = document.querySelector(".nav-links");

    menuburger.addEventListener('click', () => {
        navlinks.classList.toggle('mobile-menu');
    });
});
