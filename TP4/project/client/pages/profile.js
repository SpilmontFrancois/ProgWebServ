import httpRequest from './../utils/httpRequest.js'

const SERVER_URL = 'http://127.0.0.1:8000'

export function render() {
    document.querySelector('#content').classList.remove('d-flex', 'justify-content-end')
    document.querySelector('#content').innerHTML = `
        <div class="bg-logo w-100 mt-4 p-4 rounded d-flex justify-content-center text-white">
            <label class="fs-1 ">pseudo's Profile</label>
        </div>

        <div class="bg-white w-100 mt-4 p-4 rounded">
            <div class="form-group row w-100">
                <label class="col-sm-3 col-form-label">Firstname</label>
                <div class="col-sm-7">
                    <input id="input_Firstname" type="text" class="form-control" placeholder="Firstname">
                </div>
            </div>
            <div class="form-group row w-100 mt-2">
                <label class="col-sm-3 col-form-label">Lastname</label>
                <div class="col-sm-7">
                    <input id="input_Lastname" type="text" class="form-control" placeholder="Lastname">
                </div>
            </div>
        </div>

        <div class="bg-white w-100 mt-4 p-4 rounded" id="passwordId">
            <label class="m-0">Password</label>
            <div class="d-flex flex-auto">
                <input id="input_OldPass" class="form-control mt-1 me-1" type="password" placeholder="Old password" />
                <input id="input_NewPass" class="form-control mt-1 me-1" type="password" placeholder="New password" />
                <input id="input_ConfirmPass" class="form-control mt-1" type="password" placeholder="Confirm password" />
            </div>
        </div>

        <div class="bg-white w-100 mt-4 p-4 rounded d-flex justify-content-between">
            <label class="m-0">Contaminated</label>
            <div class="form-check form-switch w-20 d-flex justify-content-end">
                <input id="checkbox_Contaminated" class="form-check-input h-100 w-rem-3" type="checkbox" />
            </div>
        </div>
        <div class="w-100 mt-4 d-flex justify-content-center">
            <button id="button_Register" type="button" class="btn btn-primary mx-1">Confirm changes</button>
            <button id="button_Cancel" type="button" class="btn btn-danger mx-1">Cancel changes</button>
        </div>
    `
}

export function addEvent() {

    let contaminated = false; //il faudra reprendre en bdd la valeur du contaminated du profil courant

    document.querySelector('#button_Register').addEventListener('click', (e) => {
        contaminated = !contaminated
    })

    document.querySelector('#button_Register').addEventListener('click', (e) => {
        e.preventDefault()

        let firstname = document.querySelector('#input_Firstname').value
        let lastname = document.querySelector('#input_Lastname').value
        let old_pass = document.querySelector('#input_OldPass').value
        let new_pass = document.querySelector('#input_NewPass').value
        let confirm_pass = document.querySelector('#input_ConfirmPass').value
        if (contaminated) {
            contaminated = 1
        }
        else {
            contaminated = 0
        }

        /**
        * il faut tester que les champs ne soient pas vide et qu'ils aient bien été modifiée (au moins 1 doit être modifié)
        * si un champs est vide => message d'erreur rouge en mode "aucun champs ne doit être vide"
        * si aucun champs n'est modifié => on quitte bien la page mais on evite la modification en bdd (optimisation)
       */

        //vérifier si le old password correspond au mot de passe du profil en bdd



        if (new_pass == confirm_pass) {
            //modification du mot de passe en bdd
        }
        else {
            //message d'erreur en mode "le mot de passe de confirmation ne correspond pas au nouveauu mot de passe"
            let div = document.querySelector('#passwordId')
            let res = document.createElement('small')
            res.innerHTML = `Les mots de passe ne sont pas identiques.`
            console.log(res)
            div.appendChild(res)
        }
    })

    document.querySelector('#button_Cancel').addEventListener('click', (e) => {
        e.preventDefault

        // => quitter la page sans modification // Pas besoin de quiiter juste reset les champs

        document.querySelector('#input_Firstname').value = ''
        document.querySelector('#input_Lastname').value = ''
        document.querySelector('#input_OldPass').value = ''
        document.querySelector('#input_NewPass').value = ''
        document.querySelector('#input_ConfirmPass').value = ''
    })
}

export default {
    render,
    addEvent
}