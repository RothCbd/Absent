import Vue from "vue";
import Vuex from 'Vuex'

Vue.use(Vuex)

export default new Vuex.Store({
    state: {
        token: localStorage.getItem('access_token') || null,
        credentials: null,
        auth: JSON.parse(localStorage.getItem("auth")) || null,
    },

    getters: {
        loggedIn(state){
            return state.token !== null
        },
    },

    mutations: {
        setCredentials(state, message){
            state.credentials = message
        },

        retrieveToken(state, token){
            state.token = token
        },

        setAuth(state, data){
            state.auth = data
        },

        deleteAuth(state){
            state.auth = null
        },

        destroyToken(state){
            state.token = null
        }
    },

    actions: {

        // ------------------------------------
        updateProfifle(context, data){
            axios.defaults.headers.common['Authorization'] = 'Bearer ' + context.state.token
            return new Promise((resolve, reject) => {
                axios.post('api/update-profile/' + data.id, {
                    name: data.name,
                    email: data.email,
                    profile: data.profile,
                })
                .then(response => {
                    const user = response.data.user;
                    localStorage.setItem("auth", JSON.stringify(user));
                    context.commit('setAuth', user)

                    resolve(response)
                })
                .catch(error => {
                    console.log(error)
                    reject(error)
                })
            })
        },

        // ------------------------------------

        token(context, credentials){
            return new Promise(( resolve, reject ) => {
                axios.post('api/login', {
                    email: credentials.email,
                    password: credentials.password
                })
                .then(response => {
                    const token = response.data.token;
                    const user = response.data.user;

                    localStorage.setItem('access_token', token)
                    context.commit('retrieveToken', token)

                    localStorage.setItem("auth", JSON.stringify(user));
                    context.commit('setAuth', user)

                    resolve(response)
                })
                .catch(error => {
                    context.commit('setCredentials', error.response.data.message);
                    reject(error)
                })
            })
        },

        destroyToken(context){
            if(context.getters.loggedIn){
                return new Promise((resolve, reject) => {
                    axios.post('/api/logout', localStorage.getItem('access_token') ,{ headers: { "Authorization" : 'Bearer ' + localStorage.getItem('access_token')}})
                    .then(response => {
                        localStorage.removeItem('access_token');
                        localStorage.removeItem('auth');
                        context.commit('destroyToken');
                        context.commit('deleteAuth');
                        resolve(response)
                    })
                    .catch(error => {
                        console.log(error)
                        reject(error)
                    })
                })
            }
        }
    }
});
