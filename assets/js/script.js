function openBurgerMenu() {
    var burger = document.querySelector('.burger__item');
    var modal = document.querySelector('.menu-modal');
    var menu = document.querySelector('.menu-container')
    var navbar = document.querySelector('.navbar__inner')
    burger.classList.toggle("open")
    modal.appendChild(menu)
    modal.classList.toggle("visible")
    if (!modal.classList.contains("visible")) {
        navbar.appendChild(menu)
    }
}

