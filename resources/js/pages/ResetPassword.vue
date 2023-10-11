<template>
    <Auth>
        <form class="form w-100" @submit.prevent="">
            <div class="text-center mb-10">
                <h1 class="text-dark fw-bolder mb-3">Setup New Password</h1>
                <div class="text-gray-500 fw-semibold fs-6">
                    Have you already reset the password ?
                    <router-link :to="{name: 'login'}" class="link-primary fw-bold">Sign in</router-link>
                </div>
            </div>

            <div class="fv-row mb-8">
                <input type="text" placeholder="Reset Code" name="reset-code" autocomplete="off" class="form-control bg-transparent" />
            </div>

            <div class="fv-row mb-8">
                <input type="password" placeholder="Password" name="password" autocomplete="off" class="form-control bg-transparent" />
            </div>

            <div class="fv-row mb-8">
                <input type="password" placeholder="Repeat Password" name="confirm-password" autocomplete="off" class="form-control bg-transparent" />
            </div>
            <div class="d-grid mb-10">
                <button type="button" id="kt_new_password_submit" class="btn btn-primary">
                    <span class="indicator-label">Submit</span>
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