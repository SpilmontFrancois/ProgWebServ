import connection from './pages/connection.js'


function init() {
    document.querySelector('body').innerHTML = connection.renderConnexion()
    connection.addEvent()
}

window.onload = () => {
    init()
}