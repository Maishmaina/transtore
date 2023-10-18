import { createRouter, createWebHistory } from "vue-router";
import { useAuthStore } from "@/stores/authStore";

import Auth from "@/components/Auth.vue";
import Main from "@/components/Main.vue";
import Home from "@/pages/Home.vue";
import Login from "@/pages/Login.vue";
import ForgotPassword from "@/pages/ForgotPassword.vue";
import ResetPassword from "@/pages/ResetPassword.vue";
import NotFound from "@/pages/NotFound.vue";

const checkGuest = (to, from) => {
    const { authUser } = useAuthStore();

    if (authUser) {
        return {
            name: "home",
        };
    } else {
        return true;
    }
};

const router = createRouter({
    history: createWebHistory(import.meta.env.BASE_URL),
    routes: [
        {
            path: "/",
            component: Main,
            children: [
                {
                    path: "",
                    name: "home",
                    component: Home,
                    meta: {
                        requiresAuth: true,
                        title: "Dashboard",
                    },
                },
                {
                    path: "/user-management",
                    children: [
                        {
                            path: "customers",
                            name: "users-list",
                            component: () => import("@/pages/Users.vue"),
                            meta: {
                                requiresAuth: true,
                                title: "Customers List",
                            },
                        },
                        {
                            path: "operators",
                            name: "admins-list",
                            component: () => import("@/pages/Admins.vue"),
                            meta: {
                                requiresAuth: true,
                                title: "Operators List",
                            },
                        },
                    ],
                },
            ],
        },
        {
            path: "/auth",
            component: Auth,
            children: [
                {
                    path: "login",
                    name: "login",
                    component: Login,
                    beforeEnter: checkGuest,
                },
                {
                    path: "forgot-password",
                    name: "forgot-password",
                    component: ForgotPassword,
                    beforeEnter: checkGuest,
                },
                {
                    path: "reset-password",
                    name: "reset-password",
                    component: ResetPassword,
                    beforeEnter: checkGuest,
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
