import { render as renderInscription } from "./inscription.js"
import { addEvent as eventInscription } from "./inscription.js"
import httpRequest from './../utils/httpRequest.js'

const SERVER_URL = 'http://127.0.0.1:8000'

export function render() {
    let res = document.getElementsByTagName('body')[0]
    res.innerHTML = `
    <div class="card center-component shadow align-items-center w-25">
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
    return res.innerHTML;
}

export function addEvent() {
    document.querySelector('#registerButton').addEventListener('click', (e) => {
        e.preventDefault()
        document.querySelector('body').innerHTML = renderInscription()
        eventInscription()
    })

    document.querySelector('#loginbutton').addEventListener('click', async (e) => {
        e.preventDefault()
        let login = document.querySelector('#login').value
        let password = document.querySelector('#password').value
        const data = await httpRequest.post(SERVER_URL + '/login', JSON.stringify({ login, password }))
        console.log(data)
    })
}

export default {
    render,
    addEvent
}