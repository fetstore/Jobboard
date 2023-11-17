const title = document.getElementById('title')
const message = document.getElementById('message')
const date = document.getElementById('date')
const salaire = document.getElementById('salaire')
const company_name = document.getElementById('company_name')
const ville = document.getElementById('ville')
const poste = document.getElementById('type_de_poste')
const postuler = document.getElementById('postuler')

function display_error() {
    title.innerText = "";
    message.innerText = "Erreur, cette annonce n'est plus disponible"
    postuler.innerText = "Revenir en arrière";
    postuler.addEventListener('click', () => {
        window.location.replace('/');
    });
}

async function postuler_click(id) {
    let form_data = new FormData();
    form_data.append("id", id)
    let reponse = await fetch("/api/postuler/", {
        method: "POST",
        body: form_data
    });
    let data = await reponse.json();
    if (data.success) {
        window.location.reload();
    } else {
        if (data.message) {
            alert(data.message);
        } else {
            console.log(data.erreur);
        }
    }
}

async function annuler_postuler_click(id) {
    let form_data = new FormData();
    form_data.append("id", id)
    let reponse = await fetch("/api/postuler/", {
        method: "DELETE",
        body: JSON.stringify({
            id: id
        })
    });

    let data = await reponse.json();
    if (data.success) {
        window.location.reload();
    } else {
        if (data.message) {
            alert(data.message);
        } else {
            console.log(data.erreur);
        }
    }
}

window.addEventListener('load', async (e) => {
    let query = window.location.search;

    let urlParams = new URLSearchParams(query);

    let id = 0;
    // on verifie si le parametre de l'url existe et s'il est un nombre
    if (urlParams.has('id')) {
        id = Number.parseInt(urlParams.get("id"));
    }

    if (id != null && id > 0) {
        let response_postuler = await fetch("/api/postuler/?id=" + id)
        let data_postuler = await response_postuler.json();
        
        let response = await fetch("/api/advertisements/" + id)
        let data = await response.json();
        if (data) {
            data = JSON.parse(data)

            let response_company = await fetch("/api/companies/" + data.id_companie);
            let data_company = JSON.parse(await response_company.json());
            
            console.log(data);
            company_name.innerText = data_company.name;
            title.innerText = data.name;
            message.innerText = data.message;
            date.innerText = new Date(data.date_debut).toLocaleDateString("fr-FR", { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' });
            salaire.innerText = data.salaire;
            ville.innerText =  data.ville;
            poste.innerText = data.type_de_poste;

            if (data_postuler.success){
                postuler.innerText = "annuler la condidature"
                postuler.addEventListener('click', () => annuler_postuler_click(id));
            } else {
                postuler.addEventListener('click', () => postuler_click(id));
            }
        } else {
            display_error()
        }
    } else {
        display_error()
    }
});