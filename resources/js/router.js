import VueRouter from "vue-router";
import Vue from "vue";

Vue.use(VueRouter);


import Index from "./components/MainComponent";
import Login from "./auth/login";

import Register from "./auth/register";
import userIndex from "./components/userIndex";
import Wish from "./components/wishlist";
import axios from "axios";

const routes = [{
        path: "/",
        component: Index,
        name: 'index',


    },

    {
        path: '/logout',
        name: 'logout',
        beforeEnter: (to, from, next) => {

            // axios.post()
            function getCookie(name) {
                let matches = document.cookie.match(new RegExp(
                    "(?:^|; )" + name.replace(/([\.$?*|{}\(\)\[\]\\\/\+^])/g, '\\$1') + "=([^;]*)"
                ));
                return matches ? decodeURIComponent(matches[1]) : undefined;
            };

            if (getCookie('Authorization')) {
                let data = {};
                let token = getCookie('Authorization');
                let config = {
                    headers: {
                        "Access-Control-Allow-Origin": "*",
                        "Content-Type": "application/json",
                        Authorization: token,
                    },
                };
                axios.post("/api/auth/me", data, config).then((res) => {
                    next();

                }).catch((err) => {
                    console.log(err);

                });

            } else next({
                name: 'index'
            });
        }

    },
    {
        path: '/login',
        component: Login,
        name: 'login',
        beforeEnter: (to, from, next) => {

            // axios.post()
            function getCookie(name) {
                let matches = document.cookie.match(new RegExp(
                    "(?:^|; )" + name.replace(/([\.$?*|{}\(\)\[\]\\\/\+^])/g, '\\$1') + "=([^;]*)"
                ));
                return matches ? decodeURIComponent(matches[1]) : undefined;
            };

            if (getCookie('Authorization')) {
                let data = {};
                let token = getCookie('Authorization');
                let config = {
                    headers: {
                        "Access-Control-Allow-Origin": "*",
                        "Content-Type": "application/json",
                        Authorization: token,
                    },
                };
                axios.post("/api/auth/me", data, config).then((res) => {
                    next({
                        name: 'index'
                    });

                }).catch((err) => {
                    console.log(err);

                });

            } else next();
        }
    },
    {
        path: '/register',
        component: Register,
        name: 'register',
    },
    {
        path: '/wish',
        component: Wish,
        name: 'wish',
    },
    {
        path: '/user',
        component: userIndex,
        name: 'user',
    }

];

export default new VueRouter({
    mode: 'history',
    routes
});
