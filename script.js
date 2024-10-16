let show = true;

const menuContent = document.querySelector('.content');
const menuToggle = menuContent.querySelector('.menu-toggle');
menuToggle.addEventListener('click', () => {
    menuContent.classList.toggle('on', show);
    show = !show;
});

function MostrarDiv(el) {
    
    var display = document.getElementById(el).style.display;
    alert(display);
    if(display == "none")
        document.getElementById(el).style.display = 'block';
    else
        document.getElementById(el).style.display = 'none';
}