const announcements = {
    namespaced: true,
    state: {
        announcements: []
    },
    getters: {
        //Fetch announcements
        fetchAnnouncements: state => state.announcements
    },
    actions: {
        //Getting the announcements
        getAnnouncements({commit}, data){
            return new Promise((resolve, reject) => {
                axios.get('http://192.168.1.114:8000/announcements/get_announcements', data, {
                    headers:{
                        'Content-Type': 'application/json'
                    }
                })
                .then(res => {
                    resolve(res.data);
                    commit('STORE_ANNOUNCEMENTS', res.data);
                })
                .catch(e => {
                    reject(e);
                })
            })
        },
    },
    mutations: {
        //Storing the announcements
        STORE_ANNOUNCEMENTS(state, data){
            state.announcements = data;
        }
    }
};

export default announcements;