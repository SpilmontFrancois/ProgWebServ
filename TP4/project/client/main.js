import connection from './pages/connection.js'


function init() {
    document.querySelector('body').innerHTML = connection.render()
    connection.addEvent()
}

window.onload = () => {
    init()
}