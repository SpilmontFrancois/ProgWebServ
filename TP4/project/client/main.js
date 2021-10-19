function init() {
    let token = localStorage.getItem('api-access-token')
    if (token && token != undefined && localStorage.getItem('expireToken') > Math.floor(Date.now() / 1000))
        window.location.href = './pages/map.html'
    else
        window.location.href = './pages/login.html'
}

window.onload = () => {
    init()
}