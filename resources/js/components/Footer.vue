<template>
    <div id="kt_app_footer" class="app-footer d-flex flex-column flex-md-row flex-center flex-md-stack py-3">
        <div class="text-dark order-2 order-md-1">
            <span class="text-muted fw-semibold me-1">&copy; {{ year }}</span>
            <span class="text-gray-800">Transtores. All Rights Reserved</span>
        </div>
    </div>
</template>

<script setup>
const currentTime = new Date()
const year = currentTime.getFullYear()
</script>

<style scoped></style>