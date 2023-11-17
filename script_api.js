

window.addEventListener('load', async e => {
    let url = "/api/advertisements";

    let response = await fetch(url);
    let datas = await response.json();

    // on reset tout les elements s'il y en a déjà
    //container.innerHTML = "";
    for (let data of datas) {

        // on crée la carte
        let new_card = document.createElement('div');
        new_card.classList.add("card");

        // on crée son titre
        let new_title = document.createElement('h3');
        new_title.classList.add('title');
        new_title.innerText = data.name;

        // on crée le text du bouton
        let new_cb_text = document.createElement('label');
        new_cb_text.classList.add("readMore");
        new_cb_text.innerText = "voir plus";

        // on crée la description
        let new_p = document.createElement('p');
        new_p.classList.add("description");
        new_p.innerText = data.message;

        // on crée le bouton postuler
        let new_btn = document.createElement('a');
        new_btn.setAttribute('href', '/views/annonce/?id='+data.id);
        new_btn.setAttribute('target', '_blank');
        new_btn.classList.add('postuler');
        new_btn.innerHTML = `<svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M4 7.00005L10.2 11.65C11.2667 12.45 12.7333 12.45 13.8 11.65L20 7"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                        <path
                            d="M12 19H5C3.89543 19 3 18.1046 3 17V7C3 5.89543 3.89543 5 5 5H19C20.1046 5 21 5.89543 21 7V12"
                            stroke-width="2" stroke-linecap="round" />
                        <path d="M16 17.5L18 19.5L21.5 16" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" />
                    </svg>
                    <span>postuler</span>`;

        new_p.appendChild(new_btn)

        new_card.addEventListener('click', () => {
            new_p.classList.toggle('description-open');
            if (new_p.classList.contains('description-open')) {
                new_cb_text.innerText = "voir moins";
            }
            else {
                new_cb_text.innerText = "voir plus";
            }
        })

        // on ajoute tout ensemble (l'ordre est très important)
        new_card.appendChild(new_title)
        new_card.appendChild(new_p)
        new_card.appendChild(new_cb_text)

        // on ajoute notre carte à la liste prévu
        container.appendChild(new_card)
    }
});