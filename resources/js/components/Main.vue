<template>
    <div class="d-flex flex-column flex-root app-root" id="kt_app_root">
        <div class="app-page flex-column flex-column-fluid" id="kt_app_page">
            <Header />

            <div class="app-wrapper flex-column flex-row-fluid" id="kt_app_wrapper">
                <div id="kt_app_toolbar" class="app-toolbar py-7 pt-lg-10 pb-lg-5">
                    <div id="kt_app_toolbar_container" class="app-container container-xxl d-flex align-items-stretch">
                        <div class="app-toolbar-container d-flex flex-column flex-row-fluid">
                            <div class="page-title gap-4 me-3 mb-3 mb-lg-5">
                                <h1 class="text-gray-900 fw-bolder m-0">{{ pageName }}</h1>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="app-container container-xxl">
                    <div class="app-main flex-column flex-row-fluid" id="kt_app_main">
                        <div class="d-flex flex-column flex-column-fluid">
                            <div id="kt_app_content" class="app-content">
                                <slot />
                            </div>
                        </div>

                        <Footer />
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import Header from '@/components/Header.vue'
import Footer from '@/components/Footer.vue'
import { onMounted, onUnmounted } from 'vue'

defineProps({
    pageName: String
})

const body = document.body

onMounted(() => {
    body.setAttribute('id', 'kt_app_body')
    body.setAttribute('data-kt-app-header-fixed', 'true')
    body.setAttribute('data-kt-app-header-fixed-mobile', 'true')
    body.classList.add('app-default')
})

onUnmounted(() => {
    body.removeAttribute('id')
    body.removeAttribute('data-kt-app-header-fixed')
    body.removeAttribute('data-kt-app-header-fixed-mobile')
    body.classList.remove('app-default')

})

</script>

<style scoped></style>