<template>
    <Auth>
        <form class="form w-100" @submit.prevent="submitForm">
            <div class="text-center mb-10">
                <h1 class="text-dark fw-bolder mb-3">Setup New Password</h1>
                <div class="text-gray-500 fw-semibold fs-6">
                    Have you already reset the password ?
                    <router-link :to="{name: 'login'}" class="link-primary fw-bold">Sign in</router-link>
                </div>
            </div>

            <div class="fv-row mb-8">
                <input type="text" placeholder="Reset Code" autocomplete="off" class="form-control bg-transparent" :class="{'is-invalid': errors.reset_code}" v-model="form.reset_code" />
                <div class="invalid-feedback" v-if="errors.reset_code">
                    {{ errors.reset_code[0] }}
                </div>
            </div>

            <div class="fv-row mb-8">
                <input type="password" placeholder="Password" autocomplete="off" class="form-control bg-transparent" :class="{'is-invalid': errors.password}" v-model="form.password" />
                <div class="invalid-feedback" v-if="errors.password">
                    {{ errors.password[0] }}
                </div>
            </div>

            <div class="fv-row mb-8">
                <input type="password" placeholder="Repeat Password" autocomplete="off" class="form-control bg-transparent" :class="{'is-invalid': errors.password_confirmation}" v-model="form.password_confirmation" />
                <div class="invalid-feedback" v-if="errors.password_confirmation">
                    {{ errors.password_confirmation[0] }}
                </div>
            </div>
            <div class="d-grid mb-10">
                <button type="submit" id="kt_new_password_submit" class="btn btn-primary">
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
import { ref } from 'vue'
import { useRouter } from 'vue-router';
import Auth from '@/components/Auth.vue'
import { toast } from "vue3-toastify";

const router = useRouter()

const errors = ref({})
const processing = ref(false)

const form = ref({
    reset_code: '',
    password: '',
    password_confirmation: ''
})

const submitForm = async () => {
    errors.value = {}
    processing.value = true

    let response = null
    try {
        response = await axios.post('reset-password', form.value)
    } catch (error) {
        response = error.response
        error = response.data

        toast.error(error.message)
        errors.value = error.errors ?? {}
    }

    processing.value = false

    if (response.status == 200) {
        router.push({name: 'login'})
    }
}

</script>

<style scoped></style>