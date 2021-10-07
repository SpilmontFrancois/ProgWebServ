import httpRequest from '../utils/httpRequest.js'

const SERVER_URL = 'http://127.0.0.1:8000'

export function renderConnexion() {
    let res = document.getElementsByTagName('body')[0]
    res.innerHTML += `
    <div id='connexion' class="card center-component shadow align-items-center w-25">
        <img src="./assets/logo.png" class="w-25 rounded mt-2" />
        <div class="card-body text-secondary w-100">
            <div class="form-group mb-2">
                <label>Nom d'utilisateur</label>
                <input id='login' type="text" class="form-control" placeholder="Saisissez votre nom d'utilisateur">
            </div>
            <div class="form-group">
                <label>Mot de passe</label>
                <input id='password' type="password" class="form-control mb-3" placeholder="Saisissez votre mot de passe">
            </div>
            <p>Pas encore inscrit ? <button id="registerButton" class="btn btn-link btn-sm" >Inscription</button></p>
            <button id='loginbutton' class="btn btn-primary w-100">Connexion</button>
        </div>
    </div>
    `
    renderInscription()
    return res.innerHTML
}


export function renderInscription() {
    let res = document.getElementsByTagName("body")[0]
    res.innerHTML += `
    <div id='register' class="card center-component shadow align-items-center w-25 d-none">
        <img src="./assets/logo.png" class="w-25 rounded mt-2" />
        <div class="card-body text-secondary w-100">
            <div class="form-group mb-2">
                <label>Nom d'utilisateur</label>
                <input type="text" class="form-control" placeholder="Saisissez votre nom d'utilisateur">
            </div>
            <div class="form-group">
                <label>Mot de passe</label>
                <input type="password" class="form-control mb-3" placeholder="Saisissez votre mot de passe">
            </div>
            <div class="form-group">
                <label>Confirmez votre mot de passe</label>
                <input type="password" class="form-control mb-3" placeholder="Confirmez votre mot de passe">
            </div>
            <p>Déjà inscrit ? <button type="button" id="connectionButton" class="btn btn-link btn-sm">Se connecter</button></p>
            <button id='registerbutton' class="btn btn-primary w-100">Inscription</button>
        </div>
    </div>
    `
    return res.innerHTML
}

export function addEvent() {
    //!document.querySelector('#app').classList.contains('d-none') ? document.querySelector('#app').classList.add('d-none') : ''
    
    document.querySelector('#registerButton').addEventListener('click', (e) => {
        e.preventDefault()
        document.querySelector('#connexion').classList.toggle('d-none')
        document.querySelector('#register').classList.toggle('d-none')
    })

    // Change to form with post method
    document.querySelector('#loginbutton').addEventListener('click', async (e) => {
        e.preventDefault()
        let login = document.querySelector('#login').value
        let password = document.querySelector('#password').value
        const data = await httpRequest.get(SERVER_URL + '/login'/*, JSON.stringify({ login, password })*/)
        console.log(data)
    })

    document.querySelector('#connectionButton').addEventListener('click', (e) => {
        e.preventDefault()
        document.querySelector('#register').classList.toggle('d-none')
        document.querySelector('#connexion').classList.toggle('d-none')
    })
}

export default {
    renderConnexion,
    renderInscription,
    addEvent
}