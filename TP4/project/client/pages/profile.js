import httpRequest from './../utils/httpRequest.js'

const SERVER_URL = 'http://127.0.0.1:8000/api'

// Timer tous les x temps -> push coo
/*if (navigator.geolocation) {
    navigator.geolocation.getCurrentPosition(
        (position) => {
            const pos = {
                lat: position.coords.latitude,
                lng: position.coords.longitude,
            }
            // push les nouvelles coo
            console.log(pos);
        },
        () => {
            // Browser has geolocation --> fail
            // laisser les anciennes values
        }
    )
}*/
if (localStorage.getItem('expireToken') <= Math.floor(Date.now() / 1000))
    window.location.href = './login.html'

let contaminated = false
let userData = 'init'
if (localStorage.getItem('userData') && localStorage.getItem('userData') !== 'init')
    userData = JSON.parse(localStorage.getItem('userData'))

if (userData === 'init') {
    let { data } = await httpRequest.get(SERVER_URL + '/users')
    let index = data.findIndex((el) => el.login === localStorage.getItem('currentUser'))
    localStorage.setItem('userData', JSON.stringify(data[index]))
}

document.querySelector('#header').innerHTML = localStorage.getItem('currentUser') + '\'s Profile'
document.querySelector('#firstname').value = userData.firstname
document.querySelector('#lastname').value = userData.lastname
document.querySelector('#contaminated').checked = userData.contaminated

document.querySelector('#contaminated').addEventListener('click', (e) => {
    contaminated = !contaminated
})

document.querySelector('#confirmButton').addEventListener('click', async (e) => {
    e.preventDefault()
    let firstname = document.querySelector('#firstname').value
    let lastname = document.querySelector('#lastname').value
    let old_pass = document.querySelector('#oldpass').value
    let new_pass = document.querySelector('#newpass').value
    let confirm_pass = document.querySelector('#confirmpass').value

    if (contaminated)
        contaminated = 1
    else
        contaminated = 0

    let json = {}
    if (userData.firstname !== firstname)
        json['firstname'] = firstname

    if (userData.lastname !== lastname)
        json['lastname'] = lastname

    if (userData.contaminated !== contaminated)
        json['contaminated'] = contaminated

    if (new_pass !== confirm_pass)
        document.querySelector('#errorMessage').classList.remove('d-none')
    else if (new_pass !== '')
        json['password'] = new_pass

    if (Object.keys(json).length !== 0 && json.constructor === Object) {
        const { data } = await httpRequest.put(SERVER_URL + '/users/' + userData.id, JSON.stringify(json))
        localStorage.setItem('userData', 'init')
    }
})

document.querySelector('#cancelButton').addEventListener('click', (e) => {
    e.preventDefault
    document.querySelector('#firstname').value = userData.firstname
    document.querySelector('#lastname').value = userData.lastname
    document.querySelector('#contaminated').checked = userData.contaminated
    document.querySelector('#oldpass').value = ''
    document.querySelector('#newpass').value = ''
    document.querySelector('#confirmpass').value = ''
})

document.querySelector('#button_logout').addEventListener('click', (e) => {
    e.preventDefault
    localStorage.removeItem('api-access-token')
    localStorage.removeItem('currentUser')
    localStorage.removeItem('userData')
    window.location.href = './../index.html'
})