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

var ativarMenu = document.querySelector(".usuario-info");
var usuarioDropdown = document.querySelector(".usuario-logado-dropdown");
var icon = document.querySelector(".ico-icodown");

ativarMenu.addEventListener('click', function(){
    console.log('clicado!!');
    
    if(usuarioDropdown.style.display === 'block'){
        usuarioDropdown.style.display = 'none';
        icon.style.rotate = '0deg';
    } else {
        usuarioDropdown.style.display = 'block';
        icon.style.rotate = '180deg';
    }
})


const linksSubHeader = document.querySelectorAll('.container-header-itens li a');
    function ativarLinkSubMenu(link){
        const url = window.location.href;
        const href = link.href;

        if (url.includes(href)){
            link.classList.add('link-ativo-sub-menu');
        }
    }

linksSubHeader.forEach(ativarLinkSubMenu);
