import httpRequest from './../utils/httpRequest.js'

const SERVER_URL = 'http://127.0.0.1:8000'

export function render() {
    document.querySelector('#content').classList.add('w-100','d-flex','justify-content-end')
    document.querySelector('#content').innerHTML = `
    <!--div group slide barre-->
    <div class="d-flex flex-column align-items-stretch flex-shrink-0 w-25 bg-logo">
        <div class="d-flex align-items-center flex-shrink-0 p-3 link-dark text-decoration-none border-bottom">
            <img class="me-2" src="./assets/icons/envelope-solid.svg" height=20 width=20 />
            <span class="fs-5 fw-semibold text-white">Messages</span>
        </div>
        <div class="list-group list-group-flush scrollarea m-2 mb-0 rounded">
            <!-- Début d'une preview de message -->
            <a href="#" class="list-group-item list-group-item-action py-3 lh-tight bg-logo text-white"
                aria-current="true">
                <div class="d-flex w-100 align-items-center justify-content-between">
                    <strong class="mb-1">User1</strong>
                    <small>Wed</small>
                </div>
                <div class="col-10 mb-1 small">Preview Message</div>
            </a>
            <!-- Fin d'une preview de message -->
        </div>

        <div class="list-group list-group-flush scrollarea m-2 mb-0 rounded">
            <!-- Début d'une preview de message -->
            <a href="#" class="list-group-item list-group-item-action active py-3 lh-tight bg-logo text-white"
                aria-current="true">
                <div class="d-flex w-100 align-items-center justify-content-between">
                    <strong class="mb-1">User2</strong>
                    <small>Wed</small>
                </div>
                <div class="col-10 mb-1 small">Preview Message</div>
            </a>
            <!-- Fin d'une preview de message -->
        </div>
    </div>
    `
}

export function addEvent() {

}

export default {
    render,
    addEvent
}