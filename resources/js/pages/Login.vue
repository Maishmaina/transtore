<template>
    <Auth>
        <form class="form w-100" @submit.prevent="">
            <div class="text-center mb-11">
                <h1 class="text-dark fw-bolder mb-3">Sign In</h1>
                <div class="text-gray-500 fw-semibold fs-6">Sign In to access the application</div>
            </div>

            <div class="fv-row mb-8">
                <input type="text" placeholder="Email" name="email" autocomplete="off" class="form-control bg-transparent" />
            </div>
            <div class="fv-row mb-3">
                <input type="password" placeholder="Password" name="password" autocomplete="off" class="form-control bg-transparent" />
            </div>
            <div class="d-flex flex-stack flex-wrap gap-3 fs-base fw-semibold mb-8">
                <div></div>
                <router-link :to="{name: 'forgot-password'}" class="link-primary">Forgot Password ?</router-link>
            </div>
            <div class="d-grid mb-10">
                <button type="submit" id="kt_sign_in_submit" class="btn btn-primary">
                    <span class="indicator-label">Sign In</span>
                    <span class="indicator-progress">
                        Please wait...
                        <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                    </span>
                </button>
            </div>
        </form>
    </Auth>
</template>

<script setup>
import Auth from '@/components/Auth.vue'
</script>

<style scoped></style>