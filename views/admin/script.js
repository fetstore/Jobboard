const peoples = document.getElementById('peoples');
const companies = document.getElementById('companies');
const advertisements = document.getElementById('advertisements');
const peoples_advertisements = document.getElementById('peoples_advertisements');


async function generate_peoples() {
    let response = await fetch("/api/peoples/");
    let datas = await response.json();
    if (datas.length > 0) {
        let tr = document.createElement('tr');

        for (let key of Object.keys(datas[0])) {
            if (!Number.isInteger(Number(key))) { // on verifie s'il la colonne n'est pas un nombre
                let th = document.createElement('th');
                th.innerText = key;
                tr.appendChild(th);
            }
        }
        peoples.appendChild(tr)

        for (let data of datas) {
            let tr = document.createElement('tr');

            for (let key of Object.keys(data)) {
                if (!Number.isInteger(Number(key))) { // on fait une vérification ici aussi pour pas doublé les données
                    let td = document.createElement('td');
                    td.innerText = data[key];
                    tr.appendChild(td)
                }
            }
            
            peoples.appendChild(tr);
        }
    }
}

async function generate_companies() {
    let reponse = await fetch("/api/companies/");
    let datas = await reponse.json();
    if (datas.length > 0) {
        let tr = document.createElement('tr');

        for (let keys of Object.keys(datas[0])) {
            if (!Number.isInteger(Number(keys))) { // on verifie s'il la colonne n'est pas un nombre
                let th = document.createElement('th');
                th.innerText = keys;
                tr.appendChild(th);
            }
        }
        companies.appendChild(tr)

        for (let data of datas) {
            let tr = document.createElement('tr');

            for (let key of Object.keys(data)) {
                if (!Number.isInteger(Number(key))) { // on fait une vérification ici aussi pour pas doublé les données
                    let td = document.createElement('td');
                    td.innerText = data[key];
                    tr.appendChild(td)
                }
            }
            companies.appendChild(tr);
        }
    }
}

async function generate_advertisements() {
    let reponse = await fetch("/api/advertisements/");
    let datas = await reponse.json();
    if (datas.length > 0) {
        let tr = document.createElement('tr');

        for (let keys of Object.keys(datas[0])) {
            if (!Number.isInteger(Number(keys))) { // on verifie s'il la colonne n'est pas un nombre
                let th = document.createElement('th');
                th.innerText = keys;
                tr.appendChild(th);
            }
        }
        advertisements.appendChild(tr)

        for (let data of datas) {
            let tr = document.createElement('tr');

            for (let key of Object.keys(data)) {
                if (!Number.isInteger(Number(key))) { // on fait une vérification ici aussi pour pas doublé les données
                    let td = document.createElement('td');
                    td.innerText = data[key];
                    tr.appendChild(td)
                }
            }
            advertisements.appendChild(tr);
        }
    }
}


async function generate_peoples_advertisements() {
    let reponse = await fetch("/api/peoples_advertisements/");
    let datas = await reponse.json();
    if (datas.length > 0) {
        let tr = document.createElement('tr');

        for (let keys of Object.keys(datas[0])) {
            if (!Number.isInteger(Number(keys))) { // on verifie s'il la colonne n'est pas un nombre
                let th = document.createElement('th');
                th.innerText = keys;
                tr.appendChild(th);
            }
        }
        peoples_advertisements.appendChild(tr)

        for (let data of datas) {
            let tr = document.createElement('tr');

            for (let key of Object.keys(data)) {
                if (!Number.isInteger(Number(key))) { // on fait une vérification ici aussi pour pas doublé les données
                    let td = document.createElement('td');
                    td.innerText = data[key];
                    tr.appendChild(td)
                }
            }
            peoples_advertisements.appendChild(tr);
        }
    }
}

window.addEventListener('load', async (e) => {
    let cookies = decodeURIComponent(document.cookie).split("; ")

    let token = "";
    for (let cookie of cookies) {
        if (cookie.startsWith('token=')) {
            token = cookie.replace('token=', "");
        }
    }

    if (token) {
        let response = await fetch("/api/peoples/");
        let datas = await response.json();

        let is_admin = false;
        for (let data of datas) {

            if (data.token == token && data.admin) {
                is_admin = true;
            }
        }

        if (!is_admin) {
            alert("Vous êtes pas autorisé à venir sur cette page");
            window.location.replace("/")
            return; // on empêche d'éxécuter le code suivant
        }

        await generate_peoples();
        await generate_companies();
        await generate_advertisements();
        await generate_peoples_advertisements();
    } else {
        alert("Vous êtes pas autorisé à venir sur cette page");
        window.location.replace("/")
    }
});