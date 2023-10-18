<template>
    <div class="menu-item me-0 me-lg-2">
        <router-link :to="route" class="menu-link">
            <span :class="iconClass ? 'menu-icon' : 'menu-bullet' ">
                <i :class="iconClass ?? 'bullet bullet-dot'"></i>
            </span>
            <span class="menu-title">{{ title }}</span>
        </router-link>
    </div>
</template>

<script setup>
defineProps({
    title: String,
    route: Object,
    iconClass: String
})
</script>

<style scoped></style>