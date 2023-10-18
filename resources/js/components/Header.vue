<template>
    <div id="kt_app_header" class="app-header align-items-stretch">
        <div class="app-container container-fluid d-flex align-items-stretch justify-content-between" id="kt_app_header_container">
            <div class="d-flex align-items-center justify-content-between flex-row-fluid" id="kt_app_header_wrapper">
                <div class="app-header-logo d-flex align-items-center">
                    <div class="d-flex align-items-center d-lg-none ms-n2 me-2" title="Show sidebar menu">
                        <div class="btn btn-icon btn-active-color-primary w-35px h-35px" id="kt_app_header_menu_toggle">
                            <i class="ki-outline ki-abstract-14 fs-2"></i>
                        </div>
                    </div>
                    <router-link :to="{name: 'home'}" class="me-5 me-lg-9">
                        <img alt="Logo" src="/assets/media/logos/demo53.svg" class="h-25px h-lg-30px theme-light-show" />
                        <img alt="Logo" src="/assets/media/logos/demo53-dark.svg" class="h-25px h-lg-30px theme-dark-show" />
                    </router-link>
                </div>

                <div class="d-flex align-items-stretch" id="kt_app_header_menu_wrapper">
                    <div class="app-header-menu app-header-mobile-drawer align-items-stretch" data-kt-drawer="true" data-kt-drawer-name="app-header-menu" data-kt-drawer-activate="{default: true, lg: false}" data-kt-drawer-overlay="true" data-kt-drawer-width="{default:'200px', '300px': '250px'}" data-kt-drawer-direction="start" data-kt-drawer-toggle="#kt_app_header_menu_toggle" data-kt-swapper="true" data-kt-swapper-mode="prepend" data-kt-swapper-parent="{default: '#kt_app_body', lg: '#kt_app_header_menu_wrapper'}">
                        <div class="menu menu-rounded menu-column menu-lg-row menu-active-bg menu-title-gray-600 menu-state-primary menu-arrow-gray-400 fw-semibold fw-semibold fs-6 align-items-stretch my-5 my-lg-0 px-2 px-lg-0" id="#kt_app_header_menu" data-kt-menu="true">
                            <div class="menu-item me-0 me-lg-2">
                                <router-link :to="{name: 'home'}" class="menu-link">
                                    <span class="menu-icon">
                                        <i class="ki-outline ki-abstract-28 fs-3"></i>
                                    </span>
                                    <span class="menu-title">Dashboard</span>
                                </router-link>
                            </div>
                            <div data-kt-menu-trigger="{default: 'click', lg: 'hover'}" data-kt-menu-placement="bottom-start" data-kt-menu-offset="12,0" class="menu-item menu-lg-down-accordion menu-sub-lg-down-indention me-0 me-lg-2">
                                <span class="menu-link">
                                    <span class="menu-icon">
                                        <i class="ki-outline ki-abstract-41 fs-3"></i>
                                    </span>
                                    <span class="menu-title">Operations</span>
                                    <span class="menu-arrow"></span>
                                </span>

                                <div class="menu-sub menu-sub-lg-down-accordion menu-sub-lg-dropdown px-lg-2 py-lg-4 w-lg-250px">
                                    <div data-kt-menu-trigger="{default:'click', lg: 'hover'}" data-kt-menu-placement="right-start" class="menu-item menu-lg-down-accordion">
                                        <span class="menu-link">
                                            <span class="menu-icon">
                                                <i class="ki-outline ki-people fs-2"></i>
                                            </span>
                                            <span class="menu-title">User Management</span>
                                            <span class="menu-arrow"></span>
                                        </span>

                                        <div class="menu-sub menu-sub-lg-down-accordion menu-sub-lg-dropdown menu-active-bg px-lg-2 py-lg-4 w-lg-225px">
                                            <div class="menu-item">
                                                <router-link :to="{name: 'admins-list'}" class="menu-link">
                                                    <span class="menu-bullet">
                                                        <span class="bullet bullet-dot"></span>
                                                    </span>
                                                    <span class="menu-title">Operators</span>
                                                </router-link>
                                            </div>
                                            <div class="menu-item">
                                                <router-link :to="{name: 'users-list'}" class="menu-link">
                                                    <span class="menu-bullet">
                                                        <span class="bullet bullet-dot"></span>
                                                    </span>
                                                    <span class="menu-title">Customers</span>
                                                </router-link>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="app-navbar flex-shrink-0">
                    <div class="app-navbar-item me-2 me-lg-4">
                        <button class="btn btn-icon btn-body position-relative btn btn-icon btn-color-gray-600 btn-active-color-primary w-35px h-35px w-md-40px h-md-40px" data-kt-menu-trigger="{default: 'click', lg: 'hover'}" data-kt-menu-attach="parent" data-kt-menu-placement="bottom-end">
                            <i class="ki-outline ki-notification fs-2"></i>
                            <span class="position-absolute top-0 start-100 translate-middle badge badge-circle badge-sm badge-danger min-w-15px min-h-15px ms-n1 fs-8" style="margin-top: 5px;">5</span>
                        </button>
                        <div class="menu menu-sub menu-sub-dropdown menu-column w-350px w-lg-375px" data-kt-menu="true" id="kt_menu_notifications">
                            <div class="d-flex flex-column bgi-no-repeat rounded-top" style="background-image:url('/assets/media/misc/menu-header-bg.jpg')">
                                <h3 class="text-white fw-semibold px-9 mt-10 mb-6">
                                    Notifications
                                </h3>
                                <ul class="nav nav-line-tabs nav-line-tabs-2x nav-stretch fw-semibold px-9">
                                    <li class="nav-item">
                                        <a class="nav-link text-white opacity-75 opacity-state-100 pb-4 active" data-bs-toggle="tab" href="#kt_topbar_notifications_1">Unread</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link text-white opacity-75 opacity-state-100 pb-4" data-bs-toggle="tab" href="#kt_topbar_notifications_2">Read</a>
                                    </li>
                                </ul>
                            </div>
                            <div class="tab-content">
                                <div class="tab-pane fade show active" id="kt_topbar_notifications_1" role="tabpanel">
                                    <div class="scroll-y mh-325px my-5 px-8">
                                        <div class="d-flex flex-stack py-4">
                                            <div class="d-flex align-items-center">
                                                <div class="symbol symbol-35px me-4">
                                                    <span class="symbol-label bg-light-primary">
                                                        <i class="ki-outline ki-abstract-28 fs-2 text-primary"></i>
                                                    </span>
                                                </div>
                                                <div class="mb-0 me-2">
                                                    <a href="#" class="fs-6 text-gray-800 text-hover-primary fw-bold">Project Alice</a>
                                                    <div class="text-gray-400 fs-7">Phase 1 development</div>
                                                </div>
                                            </div>
                                            <span class="badge badge-light fs-8">1 hr</span>
                                        </div>
                                        <div class="d-flex flex-stack py-4">
                                            <div class="d-flex align-items-center">
                                                <div class="symbol symbol-35px me-4">
                                                    <span class="symbol-label bg-light-danger">
                                                        <i class="ki-outline ki-information fs-2 text-danger"></i>
                                                    </span>
                                                </div>
                                                <div class="mb-0 me-2">
                                                    <a href="#" class="fs-6 text-gray-800 text-hover-primary fw-bold">HR Confidential</a>
                                                    <div class="text-gray-400 fs-7">Confidential staff documents</div>
                                                </div>
                                            </div>
                                            <span class="badge badge-light fs-8">2 hrs</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="kt_topbar_notifications_2" role="tabpanel">
                                    <div class="scroll-y mh-325px my-5 px-8">
                                        <div class="d-flex flex-stack py-4">
                                            <div class="d-flex align-items-center">
                                                <div class="symbol symbol-35px me-4">
                                                    <span class="symbol-label bg-light-warning">
                                                        <i class="ki-outline ki-briefcase fs-2 text-warning"></i>
                                                    </span>
                                                </div>
                                                <div class="mb-0 me-2">
                                                    <a href="#" class="fs-6 text-gray-800 text-hover-primary fw-bold">Company HR</a>
                                                    <div class="text-gray-400 fs-7">Corporeate staff profiles</div>
                                                </div>
                                            </div>
                                            <span class="badge badge-light fs-8">5 hrs</span>
                                        </div>
                                        <div class="d-flex flex-stack py-4">
                                            <div class="d-flex align-items-center">
                                                <div class="symbol symbol-35px me-4">
                                                    <span class="symbol-label bg-light-success">
                                                        <i class="ki-outline ki-abstract-12 fs-2 text-success"></i>
                                                    </span>
                                                </div>
                                                <div class="mb-0 me-2">
                                                    <a href="#" class="fs-6 text-gray-800 text-hover-primary fw-bold">Project Redux</a>
                                                    <div class="text-gray-400 fs-7">New frontend admin theme</div>
                                                </div>
                                            </div>
                                            <span class="badge badge-light fs-8">2 days</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="app-navbar-item me-3" id="kt_header_user_menu_toggle">
                        <div class="btn btn-icon btn-color-gray-600 btn-active-color-primary w-35px h-35px w-md-40px h-md-40px" data-kt-menu-trigger="{default: 'click', lg: 'hover'}" data-kt-menu-attach="parent" data-kt-menu-placement="bottom-end">
                            <i class="ki-outline ki-profile-circle fs-1"></i>
                        </div>
                        <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg menu-state-color fw-semibold py-4 fs-6 w-275px" data-kt-menu="true">
                            <div class="menu-item px-3">
                                <div class="menu-content d-flex align-items-center px-3">
                                    <div class="symbol symbol-50px me-5">
                                        <img alt="Logo" src="/assets/media/avatars/300-5.jpg" />
                                    </div>

                                    <div class="d-flex flex-column">
                                        <div class="fw-bold d-flex align-items-center fs-5">
                                            {{ authUser.full_name }}
                                            <span class="badge badge-light-success fw-bold fs-8 px-2 py-1 ms-2">Admin</span>
                                        </div>
                                        <p class="fw-semibold text-muted fs-7">{{ authUser.email }}</p>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="separator my-2"></div>

                            <div class="menu-item px-5">
                                <span class="menu-link px-5">My Profile</span>
                            </div>

                            <div class="separator my-2"></div>

                            <div class="menu-item px-5" data-kt-menu-trigger="{default: 'click', lg: 'hover'}" data-kt-menu-placement="left-start" data-kt-menu-offset="-15px, 0">
                                <span class="menu-link px-5">
                                    <span class="menu-title position-relative">
                                        Mode
                                        <span class="ms-5 position-absolute translate-middle-y top-50 end-0">
                                            <i class="ki-outline ki-night-day theme-light-show fs-2"></i>
                                            <i class="ki-outline ki-moon theme-dark-show fs-2"></i>
                                        </span>
                                    </span>
                                </span>
                                <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-title-gray-700 menu-icon-gray-500 menu-active-bg menu-state-color fw-semibold py-4 fs-base w-150px" data-kt-menu="true" data-kt-element="theme-mode-menu">
                                    <div class="menu-item px-3 my-0">
                                        <span class="menu-link px-3 py-2" data-kt-element="mode" data-kt-value="light">
                                            <span class="menu-icon" data-kt-element="icon">
                                                <i class="ki-outline ki-night-day fs-2"></i>
                                            </span>
                                            <span class="menu-title">Light</span>
                                        </span>
                                    </div>
                                    <div class="menu-item px-3 my-0">
                                        <span class="menu-link px-3 py-2" data-kt-element="mode" data-kt-value="dark">
                                            <span class="menu-icon" data-kt-element="icon">
                                                <i class="ki-outline ki-moon fs-2"></i>
                                            </span>
                                            <span class="menu-title">Dark</span>
                                        </span>
                                    </div>
                                    <div class="menu-item px-3 my-0">
                                        <span class="menu-link px-3 py-2" data-kt-element="mode" data-kt-value="system">
                                            <span class="menu-icon" data-kt-element="icon">
                                                <i class="ki-outline ki-screen fs-2"></i>
                                            </span>
                                            <span class="menu-title">System</span>
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <div class="menu-item px-5">
                                <span class="menu-link px-5" @click.prevent="signOut">Sign Out</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { useRouter } from 'vue-router';
import { useAuthStore } from '@/stores/authStore';
import { toast } from "vue3-toastify";

const router = useRouter()
const { authUser, logout } = useAuthStore()

const signOut = async () => {
    let response = await logout()

    if (response.status == 200) {
        router.push({name: 'login'})
    } else {
        let err = response.data
        toast.error(err.message)
    }
}

</script>

<style scoped></style>