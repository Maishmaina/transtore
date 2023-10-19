<template>
    <div class="modal fade" :class="{'modal-lg': size == 'large'}" tabindex="-1">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title">{{ title }}</h3>
                    <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                        <i class="ki-duotone ki-cross fs-1"><span class="path1"></span><span class="path2"></span></i>
                    </div>
                </div>

                <div class="modal-body">
                    <slot name="modal-body" />
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                    <slot name="modal-footer" />
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
defineProps({
    title: String,
    size: {
        type: String,
        default: 'default'
    }
})
</script>

<style scoped></style>