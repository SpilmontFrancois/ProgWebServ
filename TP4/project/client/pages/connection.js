import httpRequest from '../utils/httpRequest.js'

const SERVER_URL = 'http://127.0.0.1:8000/api'

export function renderConnexion() {
    let res = document.querySelector('#content')
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
            <button id='loginButton' class="btn btn-primary w-100">Connexion</button>
        </div>
    </div>
    `
    renderInscription()
    return res.innerHTML
}


export function renderInscription() {
    let res = document.querySelector('#content')
    res.innerHTML += `
    <div id='register' class="card center-component shadow align-items-center w-25 d-none">
        <img src="./assets/logo.png" class="w-25 rounded mt-2" />
        <div class="card-body text-secondary w-100" id="div_inscription">
            <div class="form-group mb-2">
                <label>Firstname</label>
                <input id='firstname' type="text" class="form-control" placeholder="Type your firstname">
            </div>
            <div class="form-group mb-2">
                <label>Lastname</label>
                <input id='lastname' type="text" class="form-control" placeholder="Type your lastname">
            </div>
            <div class="form-group mb-2">
                <label>Login</label>
                <input id='username' type="text" class="form-control" placeholder="Type your login">
            </div>
            <div class="form-group mb-2">
                <label>Password</label>
                <input id='pass' type="password" class="form-control" placeholder="Type your password">
            </div>
            <div class="form-group mb-2">
                <label>Confirmez votre mot de passe</label>
                <input id='pass2' type="password" class="form-control" placeholder="Confirm your password">
            </div>
            <div class="form-group mb-2">
                <div class="bg-white w-100 rounded d-flex justify-content-between">
                    <label class="m-0">Contaminated ? (NO / YES)</label>
                    <div class="form-check form-switch w-20 d-flex justify-content-end">
                        <input id='contaminated' class="form-check-input h-100 w-rem-3" type="checkbox" />
                    </div>
                </div>
            </div>
            <p>Déjà inscrit ? <button type="button" id="connectionButton" class="btn btn-link btn-sm">Se connecter</button></p>
            <button id='registerButton2' class="btn btn-primary w-100">Inscription</button>
        </div>
    </div>
    `
    return res.innerHTML
}

export function addEvent() {
    let contaminated = false
    //!document.querySelector('#app').classList.contains('d-none') ? document.querySelector('#app').classList.add('d-none') : ''

    document.querySelector('#registerButton').addEventListener('click', (e) => {
        e.preventDefault()
        document.querySelector('#connexion').classList.toggle('d-none')
        document.querySelector('#register').classList.toggle('d-none')
    })

    document.querySelector('#connectionButton').addEventListener('click', (e) => {
        e.preventDefault()
        document.querySelector('#register').classList.toggle('d-none')
        document.querySelector('#connexion').classList.toggle('d-none')
    })

    document.querySelector('#contaminated').addEventListener('click', () => {
        contaminated = !contaminated
    })

    document.querySelector('#loginButton').addEventListener('click', (e) => {
        e.preventDefault()
        let login = document.querySelector('#login').value
        let password = document.querySelector('#password').value
        const data = httpRequest.post(SERVER_URL + '/login', JSON.stringify({ login, password }))
        // Call home page here
    })

    document.querySelector('#registerButton2').addEventListener('click', (e) => {
        e.preventDefault()
        let firstname = document.querySelector('#firstname').value
        let lastname = document.querySelector('#lastname').value
        let username = document.querySelector('#username').value
        let pass = document.querySelector('#pass').value
        let pass2 = document.querySelector('#pass2').value
        let coordinates = JSON.stringify({ lat: 46.727663, lng: -14.410187 })
        if (contaminated)
            contaminated = 1
        else
            contaminated = 0

        let data

        if (pass === pass2) {
            // CHANGE HERE
            data = httpRequest.post(SERVER_URL + '/register', { firstname, lastname, username, pass, coordinates, contaminated })
            console.log(data);
            // Call home page here
        }
        else {
            let div = document.querySelector('#div_inscription')
            let res = document.createElement('small')
            res.innerHTML = `Les mots de passe ne sont pas identiques.`
            div.appendChild(res)
        }

    })
}
// HASH PASSWORDS
export default {
    renderConnexion,
    renderInscription,
    addEvent
}