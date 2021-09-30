function render() {
    return `
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
            <p>Pas encore inscrit ? <a href="" class="inscription">Inscription</a></p>
            <button class="btn btn-primary w-100">Connexion</button>
        </div>
    </div>
    `
}

function login() {
    // TODO
    //const axios = require('axios');
    //axios.post('/login');
}

export default {
    render,
    login
}