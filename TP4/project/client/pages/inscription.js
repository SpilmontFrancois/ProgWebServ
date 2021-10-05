import { render as renderConnection } from "./connection.js"
import { addEvent as eventConnection } from "./connection.js"
import httpRequest from '../utils/httpRequest.js'


export function render() {
    let res = document.getElementsByTagName("body")[0]
    res.innerHTML = `
    <div class="card center-component shadow align-items-center w-25">
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
    return res.innerHTML;
}

export function addEvent() {
    document.querySelector('#connectionButton').addEventListener('click', (e) => {
        e.preventDefault()
        document.querySelector('body').innerHTML = renderConnection()
        eventConnection()
    })
}


export default {
    render,
    addEvent
}