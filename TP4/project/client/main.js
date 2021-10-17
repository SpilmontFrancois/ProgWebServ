import connection from './pages/connection.js'
import profile from './pages/profile.js'
import message from './pages/message.js'


function init() {
    connection.renderConnexion()
    connection.addEvent()

    document.querySelector('#a_home').addEventListener('click', (e) => {
        // TODO
        initMap()
    })

    document.querySelector('#a_profil').addEventListener('click', (e) => {
        profile.render()
        profile.addEvent()
    })

    document.querySelector('#a_message').addEventListener('click', (e) => {
        message.render()
        message.addEvent()
    })
}

window.onload = () => {
    init()
}