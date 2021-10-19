import httpRequest from '../utils/httpRequest.js'

const SERVER_URL = 'http://127.0.0.1:8000/api'

if (localStorage.getItem('expireToken') <= Math.floor(Date.now() / 1000))
    window.location.href = './login.html'

document.querySelector('#button_file').addEventListener('click', () => {
    document.querySelector('#input_file').click()
})

document.querySelector('#input_file').addEventListener('change', (e) => {
    document.querySelector('#modal').classList.remove('d-none')
    document.querySelector('#modal').classList.add('show')

    let file = document.getElementById("input_file").files[0]

    document.querySelector('#filename').value = file.name
    document.querySelector('#uploadPreview').src = ''

    if (file.type.includes('image')) {
        let oFReader = new FileReader()
        oFReader.readAsDataURL(file)

        oFReader.onload = function (oFREvent) {
            document.getElementById("uploadPreview").src = oFREvent.target.result
        }
    }
})

document.querySelector('#noModal').addEventListener('click', () => {
    document.querySelector('#modal').classList.add('d-none')
    document.querySelector('#modal').classList.remove('show')
})

document.querySelector('#yesModal').addEventListener('click', () => {
    // SAVE MESSAGE IN DATABASE & CALL METHOD TO CONSTRUCT THE MESSAGE

    document.querySelector('#modal').classList.add('d-none')
    document.querySelector('#modal').classList.remove('show')
})

document.querySelector('#send').addEventListener('click', async () => {
    // TODO : display messages received in the good color
    const { data } = await httpRequest.get(SERVER_URL + '/users')
    console.log(data);
    //addMessage(document.querySelector('#messageContent').value, 'Me')
    //document.querySelector('#messageContent').value = ''
})

document.querySelector('#createConv').addEventListener('click', () => {
    document.querySelector('#popUpMessage').classList.add('show')
    document.querySelector('#popUpMessage').classList.remove('d-none')
})

document.querySelector('#joinConv').addEventListener('click', () => {
    document.querySelector('#popUpConversation').classList.add('show')
    document.querySelector('#popUpConversation').classList.remove('d-none')
})
let close = document.getElementsByClassName('close')
Array.prototype.forEach.call(close, function (el) {
    el.addEventListener('click', () => {
        console.log('close')
        document.querySelector('#popUpMessage').classList.remove('show')
        document.querySelector('#popUpMessage').classList.add('d-none')
        document.querySelector('#popUpConversation').classList.remove('show')
        document.querySelector('#popUpConversation').classList.add('d-none')
    });
});


function addMessage(content, user) {
    // Save message in database
    document.querySelector('#messageList').innerHTML += `
    <div class="card m-2 p-2 bg-me">
        <h4>${user}</h4>
        <p>${content}</p>
    </div>
    `
}

document.querySelector('#button_logout').addEventListener('click', (e) => {
    e.preventDefault
    localStorage.removeItem('api-access-token')
    localStorage.removeItem('currentUser')
    localStorage.removeItem('userData')
    window.location.href = './../index.html'
})