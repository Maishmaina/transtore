<template>
    <div class="d-flex flex-column flex-root" id="kt_app_root">
        <div class="d-flex flex-column flex-column-fluid flex-lg-row">
            <div class="d-flex flex-center w-lg-50 pt-15 pt-lg-0 px-10">
                <div class="d-flex flex-center flex-lg-start flex-column">
                    <div class="mb-7">
                        <img alt="Logo" src="/assets/media/logos/custom-3.svg" />
                    </div>
                    <h2 class="text-white fw-normal m-0">Welcome Back Customer?</h2>
                </div>
            </div>
            <div class="d-flex flex-column-fluid flex-lg-row-auto justify-content-center justify-content-lg-end p-12 p-lg-20">
                <div class="bg-body d-flex flex-column align-items-stretch flex-center rounded-4 w-md-600px p-20">
                    <div class="d-flex flex-center flex-column flex-column-fluid px-lg-10 pb-15 pb-lg-20">
                        <router-view></router-view>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { onMounted, onUnmounted } from 'vue'

const body = document.body

const isDarkTheme = body.getAttribute('data-bs-theme') == 'dark'

onMounted(() => {
    body.setAttribute('id', 'kt_body')
    body.classList.add('app-blank', 'bgi-size-cover', 'bgi-attachment-fixed', 'bgi-position-center', 'bgi-no-repeat')
    if (isDarkTheme) {
        body.style.backgroundImage = "url('/assets/media/auth/bg4-dark.jpg')"
    } else {
        body.style.backgroundImage = "url('/assets/media/auth/bg4.jpg')"
    }
})

onUnmounted(() => {
    body.removeAttribute('id')
    body.removeAttribute('style')
    body.classList.remove('app-blank', 'bgi-size-cover', 'bgi-attachment-fixed', 'bgi-position-center', 'bgi-no-repeat')
})
</script>

<style scoped></style>
