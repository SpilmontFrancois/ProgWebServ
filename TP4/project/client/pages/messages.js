import httpRequest from '../utils/httpRequest.js'

const SERVER_URL = 'http://127.0.0.1:8001/api'

if (localStorage.getItem('expireToken') <= Math.floor(Date.now() / 1000))
    window.location.href = './login.html'

let messages = 'init'
if (localStorage.getItem('messages') && localStorage.getItem('messages') !== 'init')
    messages = JSON.parse(localStorage.getItem('messages'))
if (messages === 'init') {
    const { data } = httpRequest.get(SERVER_URL + '/messages')
    messages = data.filter((el) => el.user1 === localStorage.getItem('currentUser') || el.user2 === localStorage.getItem('currentUser'))
    messages.reverse()
    localStorage.setItem('messages', JSON.stringify(messages))
}

let today = new Date().getTime()
let lftM = ''
//à la première initialisation la date n'a paas forcèment le même format en fonction
//du language du navigateur
try {
    lftM = JSON.parse(localStorage.getItem('lastFetchedMessages'))
} catch (error) {
    lftM = '2021-10-31T22:05:34.758Z'
}

let lastFetchedMessages = new Date(lftM).getTime()
let diffMs = (today - lastFetchedMessages)
let diffMins = Math.round(((diffMs % 86400000) % 3600000) / 60000)
if (diffMins >= 1) {
    localStorage.setItem('lastFetchedMessages', JSON.stringify(new Date()))
    localStorage.setItem('messages', 'init')
}

let convos = []
const unique = [new Set(messages.map(item => item.user1 || item.user2))]
let lUser = []
messages.forEach(element => {
    let cu = localStorage.getItem('currentUser')
    let cible = ''
    if (element.user1 === cu || element.user2 === cu) {
        if (element.user1 === cu) {
            cible = element.user2
        } else { cible = element.user1 }
        let tmpIndex = convos.findIndex(elem => elem.user1 === cible || elem.user2 === cible)
        if (tmpIndex != -1) {
            convos.splice(tmpIndex, 1)
            convos.push(element)
        } else {
            convos.push(element)
        }
    }
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

let messagesReverse = messages
messagesReverse.reverse()
let activeConv

convos.forEach((el) => {
    let u = el.user1
    if (el.user1 === localStorage.getItem('currentUser'))
        u = el.user2

    document.querySelector('#' + u).addEventListener('click', (e) => {
        e.preventDefault()
        activeConv = messagesReverse.filter((elem) => elem.user1 === u || elem.user2 === u)
        document.querySelector('#userName').innerHTML = u
        document.querySelector('#messageList').innerHTML = ''
        activeConv.forEach((el) => {
            let author = el.user1 === localStorage.getItem('currentUser') ? 'Me' : el.user2
            document.querySelector('#messageList').innerHTML += `
                <div class="card m-2 p-2 ${el.user1 === localStorage.getItem('currentUser') ? 'bg-me' : 'bg-user'}">
                    <h4>${author}</h4>
                    <p>${el.content}</p>
                </div>
            `
        })
        localStorage.setItem('lastFetchedMessages', JSON.stringify(new Date()))
        localStorage.setItem('messages', 'init')
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

    let file = document.getElementById('input_file').files[0]

    document.querySelector('#filename').value = file.name
    document.querySelector('#uploadPreview').src = ''

    if (file.type.includes('image')) {
        let oFReader = new FileReader()
        oFReader.readAsDataURL(file)

        oFReader.onload = function (oFREvent) {
            document.getElementById('uploadPreview').src = oFREvent.target.result
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
    let pic = document.querySelector('#uploadPreview').src
    addMessage(`<img src='${pic}' />`, 'Me', localStorage.getItem('currentUser'), document.querySelector('#userName').innerHTML)

    document.querySelector('#modal').classList.add('d-none')
    document.querySelector('#modal').classList.remove('show')
    localStorage.setItem('messages', 'init')
})

document.querySelector('#send').addEventListener('click', (e) => {
    e.preventDefault()
    if (document.querySelector('#messageContent').value !== '') {
        addMessage(document.querySelector('#messageContent').value, 'Me', localStorage.getItem('currentUser'), document.querySelector('#userName').innerHTML)
        document.querySelector('#messageContent').value = ''
        document.querySelector('#messageList').scrollTop = document.querySelector('#messageList').scrollHeight
        messages.push({ user1: localStorage.getItem('currentUser'), user2: document.querySelector('#userName').innerHTML, content: document.querySelector('#messageContent').value, date: new Date() })
        localStorage.setItem('messages', JSON.stringify(messages))
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
    localStorage.setItem('messages', 'init')
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
    })
})

async function addMessage(content, user, user1, user2) {
    const { data } = await httpRequest.post(SERVER_URL + '/messages', JSON.stringify({ user1, user2, content }))
    document.querySelector('#messageList').innerHTML += `
    <div class="card m-2 p-2 ${user1 === localStorage.getItem('currentUser') ? 'bg-me' : 'bg-user'}">
        <h4>${user}</h4>
        <p>${content}</p>
    </div>
    `
}

function addConvRightPanel(username, lastMessage, date) {
    lastMessage = lastMessage.lenght > 40 ? lastMessage.subStr(0, 40) + '...' : lastMessage
    //affichage d'un dernier message de type image
    if (lastMessage.substr(0, 4) === '<img') {
        lastMessage = 'image'
    }
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