const defaultPoint = { lat: 46.727663, lng: -14.410187 }
let userPos = defaultPoint

if (localStorage.getItem('expireToken') <= Math.floor(Date.now() / 1000))
    window.location.href = './login.html'

function initMap() {
    const map = new google.maps.Map(document.getElementById('content'), {
        zoom: 15,
        center: userPos,
    })

    const centerControlDiv = document.createElement('div')

    CenterControl(centerControlDiv, map)
    map.controls[google.maps.ControlPosition.TOP_CENTER].push(centerControlDiv)

    const userIcon = {
        path: 'M224 256c70.7 0 128-57.3 128-128S294.7 0 224 0 96 57.3 96 128s57.3 128 128 128zm89.6 32h-16.7c-22.2 10.2-46.9 16-72.9 16s-50.6-5.8-72.9-16h-16.7C60.2 288 0 348.2 0 422.4V464c0 26.5 21.5 48 48 48h352c26.5 0 48-21.5 48-48v-41.6c0-74.2-60.2-134.4-134.4-134.4z',
        fillColor: 'darkcyan',
        fillOpacity: 1,
        strokeWeight: 0,
        rotation: 0,
        scale: .05,
        anchor: new google.maps.Point(225, 250),
    }

    const userMarker = new google.maps.Marker({
        position: map.getCenter(),
        icon: userIcon,
        map: map,
    })

    let contaminatedIcon = { ...userIcon }
    contaminatedIcon.fillColor = 'red'

    let markerTab = []
    let contaminated = JSON.parse(localStorage.getItem('contaminated'))
    contaminated.forEach((el) => {
        markerTab.push(JSON.parse(el.coordinates))
    })

    markerTab.forEach((coo) => {
        const contaminatedMarker = new google.maps.Marker({
            position: coo,
            icon: contaminatedIcon,
            map: map,
        })
    })

    // Try HTML5 geolocation.
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(
            (position) => {
                const pos = {
                    lat: position.coords.latitude,
                    lng: position.coords.longitude,
                }

                map.setCenter(pos)
                userPos = pos
                userMarker.setPosition(pos)
            },
            () => {
                // Browser has geolocation --> fail
                //handleLocationError(true, infoWindow, map.getCenter())
            }
        )
    } else {
        // Browser doesn't support Geolocation
        //handleLocationError(false, infoWindow, map.getCenter())
        // griser map & message -> autoriser localisation
    }

    // Check cercles
    var backgroundCircle = new google.maps.Circle({
        map: map,
        radius: 100200000,
        strokeColor: '#00000000'
    })
    backgroundCircle.bindTo('center', userMarker, 'position')

    var radiusCircle = new google.maps.Circle({
        map: map,
        radius: 1000,
        fillColor: '#FFFFFF',
        strokeColor: '#0000003F'
    })
    radiusCircle.bindTo('center', userMarker, 'position')
}

function CenterControl(controlDiv, map) {
    const controlUI = document.createElement('div')
    controlUI.style.backgroundColor = '#fff'
    controlUI.style.border = '2px solid #fff'
    controlUI.style.borderRadius = '3px'
    controlUI.style.boxShadow = '0 2px 6px rgba(0,0,0,.3)'
    controlUI.style.cursor = 'pointer'
    controlUI.style.marginTop = '8px'
    controlUI.style.marginBottom = '22px'
    controlUI.style.textAlign = 'center'
    controlUI.title = 'Click to recenter the map'
    controlDiv.appendChild(controlUI)

    const controlText = document.createElement('div')
    controlText.style.color = 'rgb(25,25,25)'
    controlText.style.fontFamily = 'Roboto,Arial,sans-serif'
    controlText.style.fontSize = '16px'
    controlText.style.lineHeight = '38px'
    controlText.style.paddingLeft = '5px'
    controlText.style.paddingRight = '5px'
    controlText.innerHTML = 'Center Map'
    controlUI.appendChild(controlText)

    controlUI.addEventListener('click', () => {
        map.setCenter(userPos)
        map.setZoom(15)
    })
}

document.querySelector('#button_logout').addEventListener('click', (e) => {
    e.preventDefault
    localStorage.removeItem('api-access-token')
    localStorage.removeItem('currentUser')
    localStorage.removeItem('userData')
    window.location.href = './../index.html'
})