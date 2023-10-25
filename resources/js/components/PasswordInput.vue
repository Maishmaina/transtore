<template>
    <div class="input-group">
        <input 
            :type="passwordVisible ? 'text' : 'password'" 
            class="form-control bg-transparent" 
            :class="{'is-invalid': errors[fieldName]}" 
            :placeholder="placeholder" 
            v-model="password" 
        />
        <span class="input-group-text" @click="togglePasswordVisibility">
            <i class="ki-outline" :class="passwordVisible ? 'ki-eye-slash' : 'ki-eye'"></i>
        </span>
        <div class="invalid-feedback" v-if="errors[fieldName]">
            {{ errors[fieldName][0] }}
        </div>
    </div>
</template>

<script setup>
import { ref, watch } from 'vue'

defineProps({
    errors: Object,
    placeholder: {
        type: String,
        default: 'Password'
    },
    fieldName: {
        type: String,
        default: 'password'
    }
})

const emit = defineEmits(['input-changed'])

const password = ref('')

const passwordVisible = ref(false)

const togglePasswordVisibility = () => {
    passwordVisible.value = !passwordVisible.value
}

watch(() => password.value, (value) => {
    emit('input-changed', value)
})

</script>

<style scoped>
.input-group-text {
    cursor: pointer;
}
</style>