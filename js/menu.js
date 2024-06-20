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