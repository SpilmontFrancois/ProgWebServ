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
    let config = {
        method,
        headers: {
            'Content-Type': 'application/json'
        },
        body
    }

    const api_token = localStorage.getItem('api-access-token');
    if (api_token)
        config.headers['Authorization'] = 'Bearer ' + api_token

    const response = await fetch(url, config)
    return response.json()
}

export default {
    get,
    post,
    put,
    del
}