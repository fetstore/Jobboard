const form_display = document.getElementById('form_display')
const form_edit = document.getElementById('form_edit')
const input_content = document.getElementById('input_content')
const btn_delete = document.getElementById('delete')
const btn_edit = document.getElementById('edit')
const btn_validate = document.getElementById('validate')
const btn_back = document.getElementById('back')

btn_back.addEventListener('click', async (e) => {
    e.preventDefault();

    form_edit.parentElement.classList.add("none")
    form_display.parentElement.classList.remove("none")
})

btn_delete.addEventListener('click', async (e) => {
    e.preventDefault();

    let response = await fetch('/api/user', {
        method: 'DELETE'
    })

    let data = await response.json()

    if (data.success) {
        alert(data.message)
        document.cookie = 'token=;expires=' + new Date(0) + ' ; Path=/;'
        window.location.href = "/"
    } else {
        alert(data.message)
    }
})

btn_edit.addEventListener('click', (e) => {
    e.preventDefault();

    form_display.parentElement.classList.add("none")
    form_edit.parentElement.classList.remove("none")
})

btn_validate.addEventListener('click', async (e) => {
    e.preventDefault();

    if (form_edit.new_password.value == form_edit.confirm_password.value) {
        let response = await fetch('/api/user', {
            method: 'PUT',
            body: JSON.stringify({
                name: form_edit.name.value,
                surname: form_edit.surname.value,
                mail: form_edit.mail.value,
                phone: form_edit.phone.value,
                old_password: form_edit.old_password.value,
                new_password: form_edit.new_password.value
            })
        })
        let data = await response.json();
        if (data.success) {
            alert(data.message);
            window.location.reload();
        } else {
            if (data.message) {
                alert(data.message)
            } else {
                alert("Quelque chose c'est mal passé, veuillez réessayé.")
            }
        }
    } else {
        alert("Le mot de passe est différent")
    }
})

window.addEventListener('load', async (e) => {
    let response = await fetch('/api/user');

    let data = await response.json();
    if (data && data.success) {
        input_content.classList.remove("none");
        let user = data.user;

        // on remplie les valeurs à afficher
        form_display.name.value = user.name
        form_display.surname.value = user.prenom
        form_display.mail.value = user.mail
        form_display.phone.value = user.telephone

        // on vide les valeurs à remplir
        form_edit.name.value = "";
        form_edit.surname.value = "";
        form_edit.mail.value = "";
        form_edit.phone.value = "";
    } else {
        window.location.href = "/views/inscription/"
    }
});