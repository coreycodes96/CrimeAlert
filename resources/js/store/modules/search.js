const search = {
    namespaced: true,
    state: {
        search_results: []
    },
    getters: {
        //Fetch search
        fetchSearch: state => state.search_results
    },
    actions: {
        //Getting search results
        makingASearch({commit}, data){
            return new Promise((resolve, reject) => {
                axios.post('http://192.168.1.114:8000/search/show', data, {
                    headers:{
                        'Content-Type': 'application/json'
                    }
                })
                .then(res => {
                    resolve(res.data);
                    commit('SEARCH_DATA', res.data);
                })
                .catch(e => {
                    reject(e);
                })
            })
        },
    },
    mutations: {
        //Storing search results
        SEARCH_DATA(state, data){
            state.search_results = data;
        }
    }
};

export default search;