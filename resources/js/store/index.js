import Vue from "vue";
import Vuex from 'Vuex'

Vue.use(Vuex)

export default new Vuex.Store({
    state: {
        token: localStorage.getItem('access_token') || null,
        credentials: null,
    },

    getters: {
        loggedIn(state){
            return state.token !== null
        }
    },

    mutations: {
        setCredentials(state, message){
            state.credentials = message
        },

        retrieveToken(state, token){
            state.token = token
        },

        destroyToken(state){
            state.token = null
        }
    },

    actions: {
        token(context, credentials){
            return new Promise(( resolve, reject ) => {
                axios.post('api/login', {
                    email: credentials.email,
                    password: credentials.password
                })
                .then(response => {
                    const token = response.data.token;
                    localStorage.setItem('access_token', token)
                    context.commit('retrieveToken', token)

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
                        context.commit('destroyToken');
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
