/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue').default;

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component('main-component', require('./components/MainComponent.vue').default);
Vue.component('v-header', require('./components/header.vue').default);
/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */
import router from './router.js';


var store = {
    auth: false,

    checkAuth: async function () {
        let data = {};
        let token = store.getCookie('Authorization');
        let config = {
            headers: {
                "Access-Control-Allow-Origin": "*",
                "Content-Type": "application/json",
                Authorization: token,
            },
        };

        return await axios.post("/api/auth/me", data, config);
        console.log('fisrt');
    },



    setApiToken: function (token) {
        axios.defaults.headers.common['Authorization'] = token;
    },
    deleteCookie: function (name) {
        store.setCookie(name, "", {
            'max-age': -1
        })
    },
    getCookie: function (name) {
        let matches = document.cookie.match(
            new RegExp(
                "(?:^|; )" +
                name.replace(/([\.$?*|{}\(\)\[\]\\\/\+^])/g, "\\$1") +
                "=([^;]*)"
            )
        );
        return matches ? decodeURIComponent(matches[1]) : undefined;
    },
    setCookie: function (name, value, options = {}) {
        options = {
            path: "/",
            // при необходимости добавьте другие значения по умолчанию
            ...options,
        };

        if (options.expires instanceof Date) {
            options.expires = options.expires.toUTCString();
        }

        let updatedCookie =
            encodeURIComponent(name) + "=" + encodeURIComponent(value);

        for (let optionKey in options) {
            updatedCookie += "; " + optionKey;
            let optionValue = options[optionKey];
            if (optionValue !== true) {
                updatedCookie += "=" + optionValue;
            }
        }

        document.cookie = updatedCookie;
    },
};


const app = new Vue({
    el: '#app',
    router,
    data: {
        auth: store.auth,
        apiToken: null,
        getCookie: store.getCookie,
        setCookie: store.setCookie,
        deleteCookie: store.deleteCookie,
        setApiToken: store.setApiToken,
        user: null,
    },
    beforeMount: function () {
        if (store.getCookie('Authorization')) {
            return store.checkAuth()
                .then((res) => {

                    let token = store.getCookie('Authorization');
                    this.auth = true;
                    this.apiToken = token;
                    this.user = res.data;

                    console.log(res.data, 'user');
                    store.setApiToken(token);
                    console.log('beforeMounted');
                }).catch((err) => {
                    alert(err);
                    store.deleteCookie('Authorization');
                });
        } else {
            console.log(store.auth, 'else')
        }
    }
});
