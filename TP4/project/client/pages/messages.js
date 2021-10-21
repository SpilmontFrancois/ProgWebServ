import httpRequest from '../utils/httpRequest.js'

const SERVER_URL = 'http://127.0.0.1:8000/api'

if (localStorage.getItem('expireToken') <= Math.floor(Date.now() / 1000))
    window.location.href = './login.html'

// init list messages on the right side
//const { data } = await httpRequest.get(SERVER_URL + '/messages')
//let messages = []



/*let xhr = new XMLHttpRequest();
xhr.open('GET', SERVER_URL + '/messages', true);
xhr.send();
*/
/*
fetch(SERVER_URL + '/messages')
  .then(function (response) {
    console.log(response.json())
  })
*/
/*
data.forEach((el) => {
    if (el.user1 === localStorage.getItem('currentUser') || el.user2 === localStorage.getItem('currentUser'))
        messages.push(el)
})
//foreach sur le tab messages et call la méthode addConvoRightPanel
*/
// try to display only a few messages
// at first : no convo opened

document.querySelector('#messageList').scrollTop = document.querySelector('#messageList').scrollHeight

document.querySelector('#button_file').addEventListener('click', (e) => {
    e.preventDefault()
    document.querySelector('#input_file').click()
})

document.querySelector('#input_file').addEventListener('change', (e) => {
    e.preventDefault()
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

document.querySelector('#noModal').addEventListener('click', (e) => {
    e.preventDefault()
    document.querySelector('#modal').classList.add('d-none')
    document.querySelector('#modal').classList.remove('show')
})

document.querySelector('#yesModal').addEventListener('click', (e) => {
    e.preventDefault()
    // SAVE MESSAGE IN DATABASE & CALL METHOD TO CONSTRUCT THE MESSAGE

    document.querySelector('#modal').classList.add('d-none')
    document.querySelector('#modal').classList.remove('show')
})

document.querySelector('#send').addEventListener('click', (e) => {
    e.preventDefault()
    let user1 = localStorage.getItem('currentUser')
    // TODO : display messages received in the good color
    if (document.querySelector('#messageContent').value !== '') {
        // add other parameter to the function -> user 1 and user 2
        //addMessage(document.querySelector('#messageContent').value, 'Me', user1, user2)
        document.querySelector('#messageContent').value = ''
        document.querySelector('#messageList').scrollTop = document.querySelector('#messageList').scrollHeight
    }
})

document.querySelector('#createConv').addEventListener('click', (e) => {
    e.preventDefault()
    document.querySelector('#popUpMessage').classList.add('show')
    document.querySelector('#popUpMessage').classList.remove('d-none')
})

document.querySelector('#newConv').addEventListener('click', (e) => {
    e.preventDefault()
    let user1 = localStorage.getItem('currentUser')
    let user2 = document.querySelector('#username').value
    let content = document.querySelector('#message').value
    addMessage(content, 'Me', user1, user2)
})
document.querySelector('#joinGroup').addEventListener('click', (e) => {
    e.preventDefault()
    let groupID = document.querySelector('#groupID').value
    let json = { user_id: localStorage.getItem('currentUser'), group_id: groupID, isAdmin: 0 }
    const { data } = await httpRequest.post(SERVER_URL + '/groups/' + groupID, JSON.stringify(json))
})
document.querySelector('#createGroup').addEventListener('click', (e) => {
    e.preventDefault()
    let lUser = document.querySelector('#lUser').value
    //TODO
})

document.querySelector('#joinConv').addEventListener('click', (e) => {
    e.preventDefault()
    document.querySelector('#popUpConversation').classList.add('show')
    document.querySelector('#popUpConversation').classList.remove('d-none')
})

let close = document.getElementsByClassName('close')
Array.prototype.forEach.call(close, function (el) {
    el.addEventListener('click', (e) => {
        e.preventDefault()
        document.querySelector('#popUpMessage').classList.remove('show')
        document.querySelector('#popUpMessage').classList.add('d-none')
        document.querySelector('#popUpConversation').classList.remove('show')
        document.querySelector('#popUpConversation').classList.add('d-none')
    });
});

async function addMessage(content, user, user1, user2) {
    const { data } = await httpRequest.post(SERVER_URL + '/messages', JSON.stringify({ user1, user2, content }))
    document.querySelector('#messageList').innerHTML += `
    <div class="card m-2 p-2 bg-me">
        <h4>${user}</h4>
        <p>${content}</p>
    </div>
    `
}

function addConvRightPanel(username, lastMessage, date) {
    lastMessage = lastMessage.lenght > 40 ? lastMessage.subStr(0, 40) + '...' : lastMessage
        `
    <div class="list-group list-group-flush scrollarea m-2 mb-0 rounded">
        <a href="#" class="list-group-item list-group-item-action py-3 lh-tight bg-logo text-white">
            <div class="d-flex w-100 align-items-center justify-content-between">
                <strong class="mb-1">${username}</strong>
                    <small>${date}</small>
            </div>
        <div class="col-10 mb-1 small">${lastMessage}</div>
        </a>
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