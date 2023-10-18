<template>
    <div data-kt-menu-trigger="{default:'click', lg: 'hover'}" data-kt-menu-placement="right-start" class="menu-item menu-lg-down-accordion">
        <span class="menu-link">
            <span class="menu-icon">
                <i :class="iconClass"></i>
            </span>
            <span class="menu-title">{{ title }}</span>
            <span class="menu-arrow"></span>
        </span>

        <div class="menu-sub menu-sub-lg-down-accordion menu-sub-lg-dropdown menu-active-bg px-lg-2 py-lg-4 w-lg-225px">
            <slot />
        </div>
    </div>
</template>

<script setup>
defineProps({
    title: String,
    iconClass: String,
})
</script>

<style scoped></style>