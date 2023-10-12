import { createRouter, createWebHistory } from "vue-router";
import { useAuthStore } from "@/stores/authStore";

import Home from "@/pages/Home.vue";
import Login from "@/pages/Login.vue";
import ForgotPassword from "@/pages/ForgotPassword.vue";
import ResetPassword from "@/pages/ResetPassword.vue";
import NotFound from "@/pages/NotFound.vue";

const router = createRouter({
    history: createWebHistory(import.meta.env.BASE_URL),
    routes: [
        {
            path: "/",
            name: "home",
            component: Home,
            meta: {
                requiresAuth: true,
            },
        },
        {
            path: "/auth",
            children: [
                {
                    path: "login",
                    name: "login",
                    component: Login,
                },
                {
                    path: "forgot-password",
                    name: "forgot-password",
                    component: ForgotPassword,
                },
                {
                    path: "reset-password",
                    name: "reset-password",
                    component: ResetPassword,
                },
            ],
        },
        {
            path: "/:pathMatch(.*)*",
            name: "NotFound",
            component: NotFound,
        },
    ],
});

router.beforeEach((to, from) => {
    const { authUser } = useAuthStore();

    if (to.meta.requiresAuth && !authUser) {
        return {
            name: "login",
        };
    }
});

export default router;
