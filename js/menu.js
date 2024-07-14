const links = document.querySelectorAll(".navbar-itens a");

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
    // console.log('clicado!!');
    
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


var dropdownAcomodacoes = document.querySelector(".dropdown-acomodacoes");
var cotainerDropdownAcomodacoes = document.querySelector(".container-dropwdown-acomodacoes");

if (dropdownAcomodacoes) {
    dropdownAcomodacoes.addEventListener('click', function() {

        if(cotainerDropdownAcomodacoes.style.display === 'block'){
            cotainerDropdownAcomodacoes.style.display = 'none';
            icon.style.rotate = '0deg';
        } else {
            cotainerDropdownAcomodacoes.style.display = 'block';
            icon.style.rotate = '180deg';
        }

    })
}

var botaoMinMenu = document.querySelector(".botao-menu");
var menuLateral = document.querySelector(".container-navbar-lateral");
var bodyMin = document.querySelector("body");
var menuPrincipalMin = document.querySelector(".principal-container-header");
var menuTopMin = document.querySelector(".container-header-itens");
var textoNav = document.querySelectorAll(".texto-nav");
var imgLogo = document.querySelector(".img-logo");

botaoMinMenu.addEventListener('click', function() {

    if (botaoMinMenu.style.rotate == '180deg') {
        botaoMinMenu.style.rotate = '0deg'
    } else {
        botaoMinMenu.style.rotate = '180deg'
    }

    menuLateral.classList.toggle("menu-min");
    bodyMin.classList.toggle("min");
    menuPrincipalMin.classList.toggle("header-principal-min");

    if (menuTopMin) {
        menuTopMin.classList.toggle("header-sub-min");
    }
    
    textoNav.forEach(function(element) {

        if (element.style.display == "none") {
            element.style.display = 'block';
        } else {
            element.style.display = 'none';
        }
    });

    var logoMax = imgLogo.getAttribute('data-logoMax');
    var logoMin = imgLogo.getAttribute('data-logoMin');
    
    var currentSrc = imgLogo.src;
    
    if (novaImg = currentSrc.includes('logo-2.svg')) {
        novaImg = logoMin
    } else {
        novaImg = logoMax
    }
    imgLogo.src = novaImg;

})