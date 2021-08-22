const account = {
    namespaced: true,
    state: {
        create_account: []
    },
    getters: {},
    actions: {
        //Create an account
        createAnAccount(NULL, data){
            return new Promise((resolve, reject) => {
                axios.post('http://192.168.1.114:8000/register', data, {
                    headers:{
                        'Content-Type': 'application/json'
                    }
                })
                .then(res => {
                    resolve(res);
                })
                .catch(error => {
                    reject(error);
                })
            })
        },
        //Log the user in
        logTheUserIn(NULL, data){
            return new Promise((resolve, reject) => {
                axios.post('http://192.168.1.114:8000/login', data, {
                    headers:{
                        'Content-Type': 'application/json'
                    }
                })
                .then(res => {
                    resolve(res);
                })
                .catch(error => {
                    reject(error);
                })
            })
        },
        //Log the user out
        logTheUserOut(){
            return new Promise((resolve, reject) => {
                axios.post('http://192.168.1.114:8000/logout')
                .then(res => {
                    resolve(res);
                })
                .catch(error => {
                    reject(error);
                })
            });
        }
    },
    mutations: {}
};

export default account;