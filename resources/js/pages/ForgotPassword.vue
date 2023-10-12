<template>
    <Auth>
        <form class="form w-100" @submit.prevent="submitForm">
            <div class="text-center mb-10">
                <h1 class="text-dark fw-bolder mb-3">Forgot Password ?</h1>
                <div class="text-gray-500 fw-semibold fs-6">Enter your email to reset your password.</div>
            </div>
            <div class="fv-row mb-8">
                <input type="text" placeholder="Email" autocomplete="off" class="form-control bg-transparent" :class="{'is-invalid': errors.email}" v-model="form.email"/>
                <div class="invalid-feedback" v-if="errors.email">
                    {{ errors.email[0] }}
                </div>
            </div>
            <div class="d-flex flex-wrap justify-content-center pb-lg-0">
                <button type="submit" id="kt_password_reset_submit" class="btn btn-primary me-4" :disabled="processing">
                    <span class="indicator-label" v-if="!processing">Submit</span>
                    <span class="indicator-progress d-block" v-else>
                        Please wait...
                        <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                    </span>
                </button>
                <router-link :to="{name: 'login'}" class="btn btn-light">Cancel</router-link>
            </div>
        </form>
    </Auth>
</template>

<script setup>
import { ref } from 'vue'
import { useRouter } from 'vue-router';
import Auth from '@/components/Auth.vue'
import { toast } from "vue3-toastify";

const router = useRouter()

const errors = ref({})
const processing = ref(false)

const form = ref({
    email: ''
})

const submitForm = async () => {
    errors.value = {}
    processing.value = true

    let response = null
    try {
        response = await axios.post('forgot-password', form.value)
    } catch (error) {
        response = error.response
        error = response.data

        toast.error(error.message)
        errors.value = error.errors ?? {}
    }

    processing.value = false

    if (response.status == 200) {
        router.push({name: 'reset-password'})
    }
}

</script>

<style scoped></style>
