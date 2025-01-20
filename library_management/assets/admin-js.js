// Toggle submenus and change the icon
function toggleSubMenu(tab) {
    var submenu = document.getElementById(tab + '-submenu');
    var icon = document.getElementById(tab + '-toggle');

    if (submenu.classList.contains('show')) {
        submenu.classList.remove('show');
        icon.textContent = '+';
    } else {
        submenu.classList.add('show');
        icon.textContent = '-';
    }
}
document.querySelectorAll('.read-more').forEach(function (link) {
    link.addEventListener('click', function (e) {
        e.preventDefault();
        var fullDescription = this.nextElementSibling;
        var shortDescription = this.parentElement;

        shortDescription.innerHTML = fullDescription.innerHTML;
    });
});
