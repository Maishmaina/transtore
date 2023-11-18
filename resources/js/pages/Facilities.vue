<template>
    <TabularTemplate
        resource="Facility"
        :fetched-data="facilities"
        :processing="processing"
        :filter="filter"
        add-permission="create facilities"
        @add-clicked="showAddModal"
        @searching="searching"
        @clear-filters="clearFilters"
        @filter-clicked="showFilterModal"
    >
        <template #thead>
            <th>#</th>
            <th>Name</th>
            <th>Owner</th>
            <th>Location</th>
            <th>Coordinates</th>
            <th>Access Period</th>
            <th>Date Added</th>
            <th>Status</th>
            <th class="text-end" v-if="permissions.includes('view facility details') || permissions.includes('delete facilities')">Actions</th>
        </template>
        <template #tbody>
            <template v-if="facilities.data.length">
                <tr v-for="(facility,i) in facilities.data">
                    <td>{{ i+1 }}</td>
                    <td>{{ facility.name }}</td>
                    <td>{{ facility.owner.full_name }}</td>
                    <td>{{ facility.location }}</td>
                    <td>{{ facility.coordinates }}</td>
                    <td>{{ facility.access_period }}</td>
                    <td>{{ moment(facility.created_at).format('MMMM Do YYYY') }}</td>
                    <td>
                        <span class="badge badge-light-success" v-if="facility.enabled">Enabled</span>
                        <span class="badge badge-light-danger" v-else>Disabled</span>
                    </td>
                    <td class="text-end" v-if="permissions.includes('view facility details') || permissions.includes('delete facilities')">
                        <router-link :to="{name: 'facilities-details', params:{id:facility.id} }" class="btn btn-sm btn-icon btn-primary" v-if="permissions.includes('view facility details')">
                            <i class="fa-solid fa-eye"></i>
                        </router-link>
                        <button type="button" class="ms-2 btn btn-sm btn-icon btn-danger" @click="deleteFacility(facility.id)" v-if="permissions.includes('delete facilities')">
                            <i class="fa-solid fa-trash"></i>
                        </button>
                    </td>
                </tr>
            </template>
            <tr v-else>
                <td colspan="7" class="text-center">No data available</td>
            </tr>
        </template>
        <template #pagination>
            <Pagination :data="facilities" @pagination-change-page="fetchFacilities" :limit="5" />
        </template>
    </TabularTemplate>
    <Modal id="add-modal" title="Add Facility">
        <template #modal-body>
            <div class="form-group">
                <label for="owner" class="form-label">Owner</label>
                <select class="form-select form-select-solid" id="owner" v-model="form.facility_owner_id" :readonly="processing">
                    <option value="">Select owner...</option>
                    <option :value="facility_owner.id" v-for="facility_owner in facility_owners" :key="facility_owner.id">
                        {{ facility_owner.full_name }}
                    </option>
                </select>
            </div>
            <div class="form-group">
                <label for="name" class="required form-label">Name</label>
                <input type="text"
                    class="form-control form-control-solid"
                    :class="{'is-invalid': errors.name}"
                    id="name"
                    placeholder="Enter facility name"
                    v-model="form.name"
                    :readonly="processing"
                />
                <div class="invalid-feedback" v-if="errors.name">
                    <small>{{ errors.name[0] }}</small>
                </div>
            </div>
            <div class="form-group">
                <label for="location" class="required form-label">Location</label>
                <input type="text"
                    class="form-control form-control-solid"
                    :class="{'is-invalid': errors.location}"
                    id="location"
                    placeholder="Enter facility location"
                    v-model="form.location"
                    :readonly="processing"
                />
                <div class="invalid-feedback" v-if="errors.location">
                    <small>{{ errors.location[0] }}</small>
                </div>
            </div>
            <div class="form-group">
                <label for="location_latitude" class="required form-label">Location Latitude</label>
                <input type="text"
                    class="form-control form-control-solid"
                    :class="{'is-invalid': errors.location_latitude}"
                    id="location_latitude"
                    placeholder="Enter location latitude"
                    v-model="form.location_latitude"
                    :readonly="processing"
                />
                <div class="invalid-feedback" v-if="errors.location_latitude">
                    <small>{{ errors.location_latitude[0] }}</small>
                </div>
            </div>
            <div class="form-group">
                <label for="location_longitude" class="required form-label">Location Longitude</label>
                <input type="text"
                    class="form-control form-control-solid"
                    :class="{'is-invalid': errors.location_longitude}"
                    id="location_longitude"
                    placeholder="Enter location longitude"
                    v-model="form.location_longitude"
                    :readonly="processing"
                />
                <div class="invalid-feedback" v-if="errors.location_longitude">
                    <small>{{ errors.location_longitude[0] }}</small>
                </div>
            </div>
            <div class="form-group">
                <label for="access_period" class="required form-label">Access Period</label>
                <input type="text"
                    class="form-control form-control-solid"
                    :class="{'is-invalid': errors.access_period}"
                    id="access_period"
                    placeholder="Enter access period"
                    v-model="form.access_period"
                    :readonly="processing"
                />
                <div class="invalid-feedback" v-if="errors.access_period">
                    <small>{{ errors.access_period[0] }}</small>
                </div>
            </div>
            <div class="mt-6 form-check form-switch form-check-custom form-check-solid">
                <input class="form-check-input h-25px w-40px" type="checkbox" id="enabled" v-model="form.enabled" :readonly="processing"/>
                <label class="form-check-label" for="enabled">
                    Enabled
                </label>
            </div>
        </template>

        <template #modal-footer>
            <button type="button" class="btn btn-primary" @click="submitForm">
                <span class="indicator-label" v-if="!processing">
                    Submit
                </span>
                <span class="indicator-progress d-block" v-else>
                    Please wait... <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                </span>
            </button>
        </template>
    </Modal>

    <Modal id="filter-modal" title="Filter Facilities">
        <template #modal-body>
            <div class="form-group">
                <label for="filter-owner" class="form-label">Owner</label>
                <select class="form-select form-select-solid" id="filter-owner" v-model="filters.facility_owner_id" :readonly="processing">
                    <option value="">Select owner...</option>
                    <option :value="facility_owner.id" v-for="facility_owner in facility_owners" :key="facility_owner.id">
                        {{ facility_owner.full_name }}
                    </option>
                </select>
            </div>
            <div class="form-group">
                <label for="filter-name" class="form-label">Name</label>
                <input type="text" id="filter-name" class="form-control form-control-solid" v-model="filters.name" :readonly="processing">
            </div>
            <div class="form-group">
                <label for="filter-location" class="form-label">Location</label>
                <input type="text" id="filter-location" class="form-control form-control-solid" v-model="filters.location" :readonly="processing">
            </div>
            <div class="form-group">
                <label for="filter-status" class="form-label">Status</label>
                <select class="form-select form-select-solid" id="filter-status" v-model="filters.status" :readonly="processing">
                    <option value="">Select status...</option>
                    <option value="enabled">Enabled</option>
                    <option value="disabled">Disabled</option>
                </select>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <label for="filter-from-date" class="form-label">From Date</label>
                    <input type="date" id="filter-from-date" class="form-control form-control-solid" v-model="filters.from_date" :readonly="processing">
                </div>
                <div class="col-md-6">
                    <label for="filter-to-date" class="form-label">To Date</label>
                    <input type="date" id="filter-to-date" class="form-control form-control-solid" v-model="filters.to_date" :readonly="processing">
                </div>
            </div>
        </template>

        <template #modal-footer>
            <button type="button" class="btn btn-primary" @click="filterFacilities">
                <span class="indicator-label" v-if="!processing">
                    Apply Filters
                </span>
                <span class="indicator-progress d-block" v-else>
                    Please wait... <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                </span>
            </button>
        </template>
    </Modal>

</template>

<script setup>
import moment from 'moment'
import Swal from 'sweetalert2'
import throttle from 'lodash/throttle'
import { toast } from 'vue3-toastify';
import { onMounted, ref, watch } from 'vue'
import { useAuthStore } from '@/stores/authStore.js'
import { Bootstrap5Pagination as Pagination } from 'laravel-vue-pagination';
import TabularTemplate from '@/components/TabularTemplate.vue'
import Modal from '@/components/Modal.vue'

const { config, permissions } = useAuthStore()

const processing = ref(true)

const facilities = ref({})

const search = ref('')

const searching = (value) => {
    search.value = value
}

const filters = ref({
    facility_owner_id: '',
    name: '',
    location: '',
    status: '',
    from_date: '',
    to_date: ''
})

const fetchFacilities = async (page = 1) => {
    let response = null
    try {
        response = await axios.get(`facilities`, {

            ...config,
            params: {
                page,
                search: search.value,
                facility_owner_id: filters.value.facility_owner_id,
                name: filters.value.name,
                location: filters.value.location,
                status: filters.value.status,
                from_date: filters.value.from_date,
                to_date: filters.value.to_date,
            }
        })
    } catch (error) {
        response = error.response
    }

    if (response.status == 200) {
        facilities.value = response.data
        processing.value = false
    } else {
        toast.error("Error fetching facilities list")
    }

}

const facility_owners = ref([])

const fetchFacilityOwners = async (page = 1) => {
    let response = null
    try {
        response = await axios.get(`facility-owners?paginate=false`, config)
    } catch (error) {
        response = error.response
    }

    if (response.status == 200) {
        facility_owners.value = response.data
    } else {
        toast.error("Error fetching facility owners list")
    }

}

onMounted(() => {
    fetchFacilities()
    fetchFacilityOwners()
})

const showAddModal = () => {
    $('#add-modal').modal('show')
}

const errors = ref({})

const form = ref({
    facility_owner_id: '',
    name: '',
    location: '',
    location_latitude: '',
    location_longitude: '',
    access_period: '',
    enabled: true,
})

const clearForm = () => {
    form.value.facility_owner_id = ''
    form.value.name = ''
    form.value.location = ''
    form.value.location_latitude = ''
    form.value.location_longitude = ''
    form.value.access_period = ''
    form.value.enabled = true
}

const submitForm = async () => {
    errors.value = {}
    processing.value = true

    let response = null
    try {
        response = await axios.post('facilities', form.value, config)
    } catch (error) {
        response = error.response
    }

    if (response.status == 201) {
        toast.success("Facility added successfully")
        clearForm()
        $('#add-modal .btn-sm').click()
        fetchFacilities()
    } else if (response.status == 422) {
        toast.error("Error adding facility")
        errors.value = response.data.errors

        processing.value = false
    }
}

const filter = ref(false)

const showFilterModal = () => {
    $('#filter-modal').modal('show')
}

const filterFacilities = async () => {
    $('#filter-modal .btn-sm').click()

    processing.value = true
    await fetchFacilities()
    filter.value = true
}

watch(() => filters.value.from_date, () => {
    if (!filters.value.to_date) {
        filters.value.to_date = moment().format('YYYY-MM-D')
    }
})

const clearFilters = async () => {
    processing.value = true

    filters.value.facility_owner_id = ''
    filters.value.name = ''
    filters.value.location = ''
    filters.value.status = ''
    filters.value.from_date = ''
    filters.value.to_date = ''

    await fetchFacilities()

    filter.value = false
}

watch(() => search.value, throttle(() => {
    fetchFacilities()
}, 600))

const deleteFacility = (id) => {
    Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
    }).then(async (result) => {
        if (result.isConfirmed) {
            let response = null
            try {
                response = await axios.delete(`facilities/${id}`, config)
            } catch (error) {
                response = error.response
                toast.error("Error deleting facility")
            }

            if (response.status == 200) {
                Swal.fire(
                    'Deleted!',
                    'Facility has been deleted.',
                    'success'
                )
                processing.value = true

                fetchFacilities()
            }
        }
    })
}
</script>

<style scoped></style>
