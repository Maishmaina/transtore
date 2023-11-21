<template>
    <form class="form w-100" @submit.prevent="submitForm">
        <div class="text-center mb-11">
            <h1 class="text-dark fw-bolder mb-3">Sign In</h1>
            <div class="text-gray-500 fw-semibold fs-6">Sign In to access the application</div>
        </div>

        <div class="fv-row mb-8">
            <input type="text" placeholder="Email" class="form-control bg-transparent" :class="{'is-invalid': errors.email}" v-model="form.email" />
            <div class="invalid-feedback" v-if="errors.email">
                {{ errors.email[0] }}
            </div>
        </div>
        <div class="fv-row mb-3">
            <PasswordInput :errors="errors" @input-changed="form.password = $event" />
        </div>
        <div class="d-flex flex-stack flex-wrap gap-3 fs-base fw-semibold mb-8">
            <div></div>
            <router-link :to="{name: 'forgot-password'}" class="link-primary">Forgot Password ?</router-link>
        </div>
        <div class="d-grid mb-10">
            <button type="submit" id="kt_sign_in_submit" class="btn btn-primary" :disabled="processing">
                <span class="indicator-label" v-if="!processing">Sign In</span>
                <span class="indicator-progress d-block" v-else>
                    Please wait...
                    <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                </span>
            </button>
        </div>
    </form>
</template>

<script setup>
import { ref, watch } from 'vue'
import { useRoute, useRouter } from 'vue-router';
import { useAuthStore } from '@/stores/authStore';
import { toast } from "vue3-toastify";
import PasswordInput from '@/components/PasswordInput.vue';

const route = useRoute()
const router = useRouter()
let { login } = useAuthStore()



if (route.query.password_changed) {
    toast.success('Password changed successfully. Please login.')
}

const form = ref({
    email: '',
    password: ''
})

const errors = ref({})

const processing = ref(false)

const submitForm = async () => {
    errors.value = {}

    processing.value = true

    let response = await login(form.value)

    processing.value = false

    if (response.status == 200) {
        // router.push({name: 'home'})
        window.location.href = '/admin'
    } else {
        let error = response.data
        toast.error(error.message)
        errors.value = error.errors ?? {}
    }

}

</script>

<style scoped></style>
