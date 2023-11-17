const form_login = document.getElementById('login');
const form_signup = document.getElementById('signup');


// partie pour la connexion d'un utilisateur
form_login.addEventListener('submit', async (e)=>{
    e.preventDefault();
    
    let mail = form_login.mail.value;
    let pwd = form_login.password.value;
    
    if (mail != "" && pwd != ""){

        let form_data = new FormData();
        form_data.append('mail', mail);
        form_data.append('mdp', pwd);

        let response = await fetch("/api/connexion/", {
            method: "POST",
            body: form_data
        });

        let data = await response.json();

        if (data.success && data.token) {
            let date = new Date(Date.now()+24*60*60*1000)

            document.cookie = 'token='+data.token+';expires='+date+' ; Path=/;'
            document.cookie = 'admin='+data.admin+';expires='+date+' ; Path=/;'
            window.location.replace("/");
        } else {
            alert("Erreur: "+data.message)
        }
    } else {
        alert("Il manque des informations");
    }
});

// partie pour l'inscription d'un utilisateur
form_signup.addEventListener('submit', async (e)=>{
    e.preventDefault();
    
    let name = form_signup.name.value;
    let mail = form_signup.mail.value;
    let pwd = form_signup.password.value;
    let verif_pwd = form_signup.verif_password.value;
    if (name != "" && mail != "" && pwd != "" && verif_pwd != "") {
          if (pwd == verif_pwd) {

            let form_data = new FormData();
            form_data.append('mail', mail);
            form_data.append('name', name);
            form_data.append('mdp', pwd);

            let response = await fetch("/api/inscription/", {
                method: "POST",
                body: form_data
            })
            if (response.ok){
                let data = await response.json();
                if (data.success) {
                    window.location.replace("/");
                } else {
                    alert(data.message);
                }
            } else {

                console.error(response);

            }
          } else {
            alert("Les mots de passe sont différent")
          }
    } else {
        alert("Il manque des infos");
    }
});