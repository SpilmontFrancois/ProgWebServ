import httpRequest from '../utils/httpRequest.js'

const SERVER_URL = 'http://127.0.0.1:8000/api'

let contaminated = false

// save token in localStorage ?
// need to know when user is authenticated

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

document.querySelector('#loginButton').addEventListener('click', async (e) => {
    e.preventDefault()
    let login = document.querySelector('#login').value
    let password = document.querySelector('#password').value
    const { data } = await httpRequest.post(SERVER_URL + '/login', JSON.stringify({ login, password }))
    localStorage.setItem('api-access-token', data.token)
    
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