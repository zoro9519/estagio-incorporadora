var HTTPClient = {
    post: async function(endpoint, data, headers = []) {

        let dados = {
            method: "POST",
            headers: headers,
            // mode: 'cors',
            // cache: 'default',
            body: data
        };

        return fetch(endpoint, dados).then((response) => { 
            return response.json();
        });
    },
    get: async function(endpoint, headers = []) {

        let dados = {
            method: "GET",
            headers: headers,
            mode: 'cors',
            cache: 'default'
        };

        return fetch(endpoint, dados).then((response) => { 
            return response.json();
        });
    },
    delete: async function(endpoint, headers = []) {

        let dados = {
            method: "DELETE",
            headers: headers,
            mode: 'cors',
            cache: 'default'
        };

        return fetch(endpoint, dados).then((response) => { 
            return response.json();
        });
    }
}
// export default HTTPClient;
