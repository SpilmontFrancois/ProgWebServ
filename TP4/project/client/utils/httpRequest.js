async function get(url) {
    return request(url, 'GET')
}

async function post(url, body) {
    return request(url, 'POST', body)
}

async function del(url) {
    return request(url, 'DELETE')
}

async function put(url, body) {
    return request(url, 'PUT', body)
}

async function request(url, method, body = null) {
    fetch(url, {
        method,
        headers: {
            'Content-Type': 'application/json'
        },
        body
    }).then(function (response) {
        if (!response.ok)
            throw new Error(response.text())
        response.then(function (data) {
            return data
        })
    }).catch(function (error) {
        console.log(error)
    })
}

export default {
    get,
    post,
    put,
    del
}