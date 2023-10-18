<template>
    <div class="card" v-if="!processing">
        <div class="card-header border-0 pt-6">
            <div class="card-title">
                <div class="d-flex align-items-center position-relative my-1" v-if="fetchedData.data?.length || filter">
                    <i class="ki-outline ki-magnifier fs-3 position-absolute ms-5"></i>
                    <input type="text" class="form-control form-control-solid w-250px ps-12" placeholder="Search" v-model="search" />
                </div>
            </div>
            <div class="card-toolbar">
                <div class="d-flex justify-content-end">
                    <button type="button" class="btn btn-light-danger me-3" @click="$emit('clearFilters')" v-if="filter">
                        <i class="ki-outline ki-filter fs-2"></i>
                        Clear Filters
                    </button>
                    <button type="button" class="btn btn-light-primary me-3" @click="$emit('filterClicked')" v-if="fetchedData.data?.length || filter">
                        <i class="ki-outline ki-filter-search fs-2"></i>
                        Filter
                    </button>
                    <button type="button" class="btn btn-primary" @click="$emit('addClicked')">Add {{ resource }}</button>
                </div>
            </div>
        </div>
        <div class="card-body pt-0">
            <div class="table-responsive">
                <table class="table table-striped align-middle table-row-dashed fs-6 gy-5">
                    <thead>
                        <tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0">
                            <slot name="thead" />
                        </tr>
                    </thead>
                    <tbody class="fw-semibold text-gray-600">
                        <slot name="tbody" />
                    </tbody>
                </table>
                <div class="mt-3 d-flex justify-content-between align-items-center" v-if="fetchedData.data?.length && !filter">
                    <div>{{ `Showing ${fetchedData.meta.from ?? 0} to ${fetchedData.meta.to ?? 0} of ${fetchedData.meta.total} entries` }}</div>
                    <nav>
                        <slot name="pagination" />
                    </nav>
                </div>
            </div>
        </div>
    </div>

    <Spinner v-else />
</template>

<script setup>
import { ref, watch } from 'vue'
import throttle from 'lodash/throttle'

defineProps({
    processing: Boolean,
    filter: Boolean,
    fetchedData: Object,
    resource: String,
})

const emit = defineEmits([
    'searching',
    'addClicked',
    'filterClicked',
    'clearFilters',
])

const search = ref('')

watch(() => search.value, throttle((value) => {
    emit('searching', value)
}, 600))

</script>

<style scoped></style>