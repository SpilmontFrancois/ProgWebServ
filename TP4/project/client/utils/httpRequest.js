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

//TODO utiliser promise : const ... = await...
async function request(url, method, body = null) {
    const promise = await fetch(url, {
        method,
        headers: {
            'Content-Type': 'application/json'
        },
        body
    })
    //console.log(promise.text());
    //.then(function (response) {
    //    if (!response.ok)
    //        throw new Error(response.text())
    //    response.then(function (data) {
    //        console.log(data);
    //        return data
    //    })
    //}).catch(function (error) {
    //    console.log(error)
    //})
}

export default {
    get,
    post,
    put,
    del
}