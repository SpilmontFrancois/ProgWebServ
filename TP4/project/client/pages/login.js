import httpRequest from '../utils/httpRequest.js'

const SERVER_URL = 'http://127.0.0.1:8000/api'

localStorage.removeItem('api-access-token')
localStorage.removeItem('expireToken')
localStorage.setItem('messages', 'init')
let contaminated = false

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
    localStorage.setItem('currentUser', login)
    localStorage.setItem('expireToken', data.expires_in)
    localStorage.setItem('userData', 'init')
    window.location.href = './map.html'
})

document.querySelector('#registerButton2').addEventListener('click', async (e) => {
    e.preventDefault()
    document.querySelector('#errorMessage').classList.add('d-none')
    let firstname = document.querySelector('#firstname').value
    let lastname = document.querySelector('#lastname').value
    let login = document.querySelector('#username').value
    let password = document.querySelector('#pass').value
    let pass2 = document.querySelector('#pass2').value
    let coordinates = JSON.stringify({ lat: 46.727663, lng: -14.410187 })
    if (contaminated)
        contaminated = 1
    else
        contaminated = 0

    if (password === pass2) {
        const { data } = await httpRequest.post(SERVER_URL + '/register', JSON.stringify({ firstname, lastname, login, password, coordinates, contaminated }))
        localStorage.setItem('api-access-token', data.token)
        localStorage.setItem('currentUser', login)
        localStorage.setItem('expireToken', data.expires_in)
        localStorage.setItem('userData', 'init')
        window.location.href = './map.html'
    }
    else
        document.querySelector('#errorMessage').classList.remove('d-none')
})