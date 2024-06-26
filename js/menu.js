const links = document.querySelectorAll(".navbar-itens a");
console.log(links);

function ativarLink(link) {
    const url = window.location.href;
    const href = link.href;

    if (url.includes(href)){
        link.classList.add('link-ativo');
    }
}

links.forEach(ativarLink);

var ativarMenu = document.querySelector(".usuario-logado-foto");
var usuarioDropdown = document.querySelector(".usuario-logado-dropdown");

ativarMenu.addEventListener('click', function(){
    console.log('clicado!!');
    
    if(usuarioDropdown.style.display === 'block'){
        usuarioDropdown.style.display = 'none';
    } else {
        usuarioDropdown.style.display = 'block';
    }
})