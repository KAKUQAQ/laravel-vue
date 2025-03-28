import { createRouter, createWebHistory } from "vue-router";
import Home from "../views/Home.vue";
import Login from "../views/Login.vue";
import Register from "../views/Register.vue";
import Profile from "../views/Profile.vue";
import VerifyEmail from "../views/VerifyEmail.vue"

const routes = [
    { path: "/", component: Home },
    { path: "/login", component: Login },
    { path: "/register", component: Register },
    { path: "/profile", component: Profile },
    { path: "/verify-email", component: VerifyEmail }
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

export default router;
