import httpRequest from '../utils/httpRequest.js'

const SERVER_URL = 'http://127.0.0.1:8000/api'

if (localStorage.getItem('expireToken') <= Math.floor(Date.now() / 1000))
    window.location.href = './login.html'

let messages = 'init'
if (localStorage.getItem('messages') && localStorage.getItem('messages') !== 'init')
    messages = JSON.parse(localStorage.getItem('messages'))

if (messages === 'init') {
    const { data } = await httpRequest.get(SERVER_URL + '/messages')
    messages = data.filter((el) => el.user1 === localStorage.getItem('currentUser') || el.user2 === localStorage.getItem('currentUser'))
    messages.reverse()
    localStorage.setItem('messages', JSON.stringify(messages))
}

// faire en sorte d'update les messages tous les x temps

let convos = []
const unique = [...new Set(messages.map(item => item.user1 || item.user2))];
unique.forEach((el) => {
    if (el !== localStorage.getItem('currentUser'))
        convos.push(messages[messages.findIndex((elem) => elem.user1 === el || elem.user2 === el)])
})

let user
convos.forEach((el) => {
    if (el.user1 === localStorage.getItem('currentUser'))
        user = el.user2
    else
        user = el.user1

    if (user.length > 10)
        user = user.substr(0, 10) + '...'

    addConvRightPanel(user, el.content, new Date(Date.parse(el.date)).toLocaleDateString())
})

convos.forEach((el) => {
    if (el.user1 === localStorage.getItem('currentUser'))
        user = el.user2
    else
        user = el.user1

    document.querySelector('#' + user).addEventListener('click', () => {
        console.log(user);
        document.querySelector('#userName').innerHTML = user
        document.querySelector('#messageList').innerHTML = ''
    })
})

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
    let userConv = ''
    // TODO : display messages received in the good color
    if (document.querySelector('#messageContent').value !== '') {
        // add other parameter to the function -> user 1 and user 2
        //addMessage(document.querySelector('#messageContent').value, 'Me', user1, user2)
        document.querySelector('#messageContent').value = ''
        document.querySelector('#messageList').innerHTML += `
        <div class="card m-2 p-2 bg-me">
            <h4>${userConv}</h4>
            <p>Bla Bla Bla</p>
        </div>
        `
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
    let user1 = localStorage.getItem('userData').id
    let user2 = document.querySelector('#username').value
    let content = document.querySelector('#message').value
    addMessage(content, 'Me', user1, user2)
})

document.querySelector('#joinGroup').addEventListener('click', async (e) => {
    e.preventDefault()
    let groupID = document.querySelector('#groupID').value
    let json = { user_id: parseInt(JSON.parse(localStorage.getItem('userData')).id), group_id: parseInt(groupID), isAdmin: 0 }
    const { data } = await httpRequest.post(SERVER_URL + '/users2group', JSON.stringify(json))
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
    document.querySelector('#convoList').innerHTML += `
    <div id=${username} class="list-group list-group-flush scrollarea m-2 mb-0 rounded">
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