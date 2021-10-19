function init() {
    let token = localStorage.getItem('api-access-token')
    if (token)
        window.location.href = './pages/map.html'
    else
        window.location.href = './pages/login.html'
}

window.onload = () => {
    init()
}