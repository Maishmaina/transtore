import { createRouter, createWebHistory } from "vue-router";
import { useAuthStore } from "@/stores/authStore";

// PARENT COMPONENTS
import Auth from "@/components/Auth.vue";
import Main from "@/components/Main.vue";

// DASHBOARD PAGE COMPONENTS
import Home from "@/pages/Home.vue";
import Users from "@/pages/Users.vue";
import Admins from "@/pages/Admins.vue";
import FacilityOwners from "@/pages/FacilityOwners.vue";
import Facilities from "@/pages/Facilities.vue";
import RolesAndPermissions from "@/pages/RolesAndPermissions.vue";

// AUTH PAGE COMPONENTS
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
                            component: Users,
                            meta: {
                                requiresAuth: true,
                                title: "Customers List",
                                permission: "view customers",
                            },
                        },
                        {
                            path: "operators",
                            name: "admins-list",
                            component: Admins,
                            meta: {
                                requiresAuth: true,
                                title: "Operators List",
                                permission: "view operators",
                            },
                        },
                    ],
                },
                {
                    path: "/facilities",
                    children: [
                        {
                            path: "facility-owners",
                            name: "facility-owners",
                            component: FacilityOwners,
                            meta: {
                                requiresAuth: true,
                                title: "Facilities Owners",
                                permission: "view facility owners",
                            },
                        },
                        {
                            path: "facilities-list",
                            name: "facilities-list",
                            component: Facilities,
                            meta: {
                                requiresAuth: true,
                                title: "Facilities List",
                                permission: "view facilities",
                            },
                        },
                    ],
                },
                {
                    path: "/globals",
                    children: [
                        {
                            path: "roles-and-permissions",
                            name: "roles-and-permissions",
                            component: RolesAndPermissions,
                            meta: {
                                requiresAuth: true,
                                title: "Roles and Permissions",
                                permission: "view roles",
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
    const { authUser, permissions } = useAuthStore();

    if (to.meta.requiresAuth && !authUser) {
        return {
            name: "login",
        };
    }

    if (to.meta.permission && !permissions.includes(to.meta.permission)) {
        return {
            name: "home",
        };
    }
});

export default router;
