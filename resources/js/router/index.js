import { createRouter, createWebHistory } from "vue-router";
import { useAuthStore } from "@/stores/authStore";
import { useUserStore } from "@/stores/userStore";

// PARENT COMPONENTS
import Auth from "@/components/Auth.vue";
import Main from "@/components/Main.vue";

// DASHBOARD PAGE COMPONENTS
import Home from "@/pages/Home.vue";
import Users from "@/pages/Users.vue";
import Admins from "@/pages/Admins.vue";
import FacilityOwners from "@/pages/FacilityOwners.vue";
import Facilities from "@/pages/Facilities.vue";
import FacilityDetails from "@/pages/facility/FacilityDetails.vue";
import RolesAndPermissions from "@/pages/RolesAndPermissions.vue";
import StorageTypes from "@/pages/StorageTypes.vue";

// AUTH PAGE COMPONENTS
import Login from "@/pages/Login.vue";
import ForgotPassword from "@/pages/ForgotPassword.vue";
import ResetPassword from "@/pages/ResetPassword.vue";

import NotFound from "@/pages/NotFound.vue";

//USER ROUTES
import UserAuth from "@/components/user/UserAuth.vue";
import UserMain from "@/components/user/UserMain.vue";
import UserLogin from "@/pages/user/Login.vue";
import UserRegister from "@/pages/user/Register.vue";
import UserForgotPassword from "@/pages/user/ForgotPassword.vue";
import VerifyUserAccount from "@/pages/user/VerifyUserAccount.vue"
import UserSetPassword from "@/pages/user/ResetPassword.vue";

import Facility from "@/pages/user/Facility.vue";

const checkGuest = (to, from) => {

    const { authUser } = useAuthStore();
    const { user } = useUserStore();

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
            path: "/admin",
            component: Main,
            children: [
                {
                    path: "/admin",
                    name: "home",
                    component: Home,
                    meta: {
                        requiresAuth: true,
                        title: "Dashboard",
                    },
                },
                {
                    path: "/admin/user-management",
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
                    path: "/admin/facilities",
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
                        {
                            path: "facilities-details/:id",
                            name: "facilities-details",
                            component: FacilityDetails,
                            meta: {
                                requiresAuth: true,
                                title: "Facility Details",
                                permission: "edit facilities",
                            },
                        },
                    ],
                },
                {
                    path: "/admin/globals",
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
                        {
                            path: "storage-types",
                            name: "storage-types",
                            component: StorageTypes,
                            meta: {
                                requiresAuth: true,
                                title: "Storage Types",
                                permission: "view storage types",
                            },
                        },
                    ],
                },
            ],
        },
        {
            path: "/admin/auth",
            component: Auth,
            children: [
                {
                    path: "admin_login",
                    name: "admin_login",
                    component: Login,
                    beforeEnter: checkGuest,
                },
                {
                    path: "admin_forgot-password",
                    name: "admin_forgot-password",
                    component: ForgotPassword,
                    beforeEnter: checkGuest,
                },
                {
                    path: "admin_reset-password",
                    name: "admin_reset-password",
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
        {
            // user auth routes
            path: "/auth",
            component: UserAuth,
            children: [
                {
                    path: "login",
                    name: "login",
                    component: UserLogin,
                    beforeEnter: checkGuest,
                },
                {
                    path: "register",
                    name: "register",
                    component: UserRegister,
                    beforeEnter: checkGuest,
                },
                {
                    path: "forgot-password",
                    name: "forgot-password",
                    component: UserForgotPassword,
                    beforeEnter: checkGuest,
                },
                {
                    path: "reset-password",
                    name: "reset-password",
                    component: UserSetPassword,
                    beforeEnter: checkGuest,
                },
                {
                    path: 'verify-user',
                    name: 'verify-user',
                    component: VerifyUserAccount,
                    beforeEnter: checkGuest,
                }
            ],
        },
        //authorized user/customer routes
        {
            path: "/",
            component: UserMain,
            children: [
                {
                    path: "/facility",
                    name: "facility",
                    component: Facility,
                },
            ]
        }
    ],
});
router.beforeEach((to, from) => {

    const { authUser, permissions } = useAuthStore();
    const { user } = useUserStore();
    console.log(authUser);
    if (to.meta.requiresAuth && (!authUser)) {
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
