import httpRequest from '../utils/httpRequest.js'

const SERVER_URL = 'http://127.0.0.1:8000'

document.querySelector('#button_file').addEventListener('click', () => {
    document.querySelector('#input_file').click()
    console.log(document.querySelector('#input_file'))
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

document.querySelector('#send').addEventListener('click', () => {
    // TODO : display messages received in the good color
    addMessage(document.querySelector('#messageContent').value, 'Me')
    document.querySelector('#messageContent').value = ''
})

function addMessage(txt, user) {
    document.querySelector('#messageList').innerHTML += `
    <div class="card m-2 p-2 bg-me">
        <h4>${user}</h4>
        <p>${txt}</p>
    </div>
    `
}