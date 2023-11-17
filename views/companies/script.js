const companies_container = document.getElementById('companies_container')

window.addEventListener('load', async (e)=>{
    let response = await fetch('/api/companies')
    let datas = await response.json()
    
    companies_container.innerHTML = "";
    for (let data of datas){
        let tr = document.createElement('tr')
        let td_name = document.createElement('td')
        let td_description = document.createElement('td')

        td_name.innerText = data.name;
        td_description.innerText = data.description;

        tr.appendChild(td_name)
        tr.appendChild(td_description)
        
        companies_container.appendChild(tr)
    }
});