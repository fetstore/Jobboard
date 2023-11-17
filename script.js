// Récupérer des éléments du DOM
const nav = document.getElementsByClassName('nav')[0];
const nav_btn = document.getElementById('nav_button_cb');
const filter = document.getElementById('filter');

const logouts = document.getElementsByClassName('logout')
const container = document.getElementsByClassName('container')[0];

const connexion = document.getElementById('connexion')
const admin = document.getElementById('admin')

window.addEventListener('load', (e)=>{
    let cookies = decodeURIComponent(document.cookie).split("; ")
    for (let logout of logouts){

    logout.addEventListener('click', ()=>{
        // on supprime le cookie
        // (pour le supprime on met ça date d'expiration à maintenant)
        document.cookie = 'token=;expires='+new Date(0)+" ; Path=/"
        document.cookie = 'admin=;expires='+new Date(0)+" ; Path=/"
    });
    let token = "";
    let is_admin = false;
    for(let cookie of cookies) {
        if (cookie.startsWith('token=')) {
            token = cookie;
        } else if (cookie.startsWith("admin=1")) {
            is_admin = true;
        }
    }

    if (token) {
        logout.href = "/"
        logout.innerText = "Déconnexion"
        logout.addEventListener('click', ()=>{
            // on supprime le cookie
            // (pour le supprime on met ça date d'expiration à maintenant)
            document.cookie = 'token=;expires='+new Date(0)+" ; Path=/"
        });

        // si jamais sur la page il n'y a pas de boutton connexion
        if (connexion) {
            connexion.innerText = "mon compte"
            connexion.href = "/views/profil/"
        }
    }

    if (!is_admin){
        admin.style.display = "none";
    } else {
        admin.style.display = "initial";
    }
    }
});

// methode pour alterner entre ourvrir et fermer quand on l'appelle
function toggleNavBar() {
    if (nav_btn.checked){
        openNavBar();
    } else {
        closeNavBar();
    }
}

// method pour fermer la nav barre
function closeNavBar() {
    nav.classList.remove('nav-open')
    filter.style.display = "none"
}

// methode pour ouvrir la nav bar
function openNavBar() {
    nav.classList.add('nav-open')
    filter.style.display = "block"
}

// on ecoute si on appuie sur le bouton pour ourvrir et fermer la nav bar
nav_btn.addEventListener('click', toggleNavBar);

// on ferme la nav bar quand on charge la page
closeNavBar();
nav_btn.checked = false;
