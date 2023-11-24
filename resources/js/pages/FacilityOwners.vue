<template>
    <TabularTemplate
        resource="Facility Owner"
        :fetched-data="owners"
        :processing="processing"
        :filter="filter"
        add-permission="create facility owners"
        @add-clicked="showAddModal"
        @searching="searching"
        @clear-filters="clearFilters"
        @filter-clicked="showFilterModal"
    >
        <template #thead>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Phone No.</th>
            <th>Email</th>
            <th>Date Joined</th>
            <th class="text-end" v-if="permissions.includes('view facility owner details') || permissions.includes('delete facility owners')">Actions</th>
        </template>

        <template #tbody>
            <template v-if="owners.data.length">
                <tr v-for="owner in owners.data">
                    <td>{{ owner.first_name }}</td>
                    <td>{{ owner.last_name }}</td>
                    <td>{{ owner.phone_number }}</td>
                    <td>{{ owner.email }}</td>
                    <td>{{ moment(owner.created_at).format('MMMM Do YYYY') }}</td>
                    <td class="text-end" v-if="permissions.includes('view facility owner details') || permissions.includes('delete facility owners')">
                        <a href="#" type="button" class="btn btn-sm btn-icon btn-primary" v-if="permissions.includes('view facility owner details')">
                            <i class="fa-solid fa-eye"></i>
                        </a>
                        <button type="button" class="ms-2 btn btn-sm btn-icon btn-danger" @click="deleteOwner(owner.id)" v-if="permissions.includes('delete facility owners')">
                            <i class="fa-solid fa-trash"></i>
                        </button>
                    </td>
                </tr>
            </template>
            <tr v-else>
                <td colspan="7" class="text-center">No data available</td>
            </tr>
        </template>

    </TabularTemplate>

    <Modal id="add-modal" title="Add Facility Owner">
        <template #modal-body>
            <div class="form-group">
                <label for="first-name" class="required form-label">First Name</label>
                <input type="text"
                    class="form-control form-control-solid"
                    :class="{'is-invalid': errors.first_name}"
                    id="first-name"
                    placeholder="Enter first name"
                    v-model="form.first_name"
                    :readonly="processing"
                />
                <div class="invalid-feedback" v-if="errors.first_name">
                    <small>{{ errors.first_name[0] }}</small>
                </div>
            </div>
            <div class="form-group">
                <label for="last-name" class="required form-label">Last Name</label>
                <input type="text"
                    class="form-control form-control-solid"
                    :class="{'is-invalid': errors.last_name}"
                    id="last-name"
                    placeholder="Enter last name"
                    v-model="form.last_name"
                    :readonly="processing"
                />
                <div class="invalid-feedback" v-if="errors.last_name">
                    <small>{{ errors.last_name[0] }}</small>
                </div>
            </div>
            <div class="form-group">
                <label for="phone-number" class="form-label">Phone No.</label>
                <input type="text"
                    class="form-control form-control-solid"
                    :class="{'is-invalid': errors.phone_number}"
                    id="phone-number"
                    placeholder="Enter phone number"
                    v-model="form.phone_number"
                    :readonly="processing"
                />
                <div class="invalid-feedback" v-if="errors.phone_number">
                    <small>{{ errors.phone_number[0] }}</small>
                </div>
            </div>
            <div class="form-group">
                <label for="email" class="required form-label">Email</label>
                <input type="email"
                    class="form-control form-control-solid"
                    :class="{'is-invalid': errors.email}"
                    id="email"
                    placeholder="Enter email"
                    v-model="form.email"
                    :readonly="processing"
                />
                <div class="invalid-feedback" v-if="errors.email">
                    <small>{{ errors.email[0] }}</small>
                </div>
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

    <Modal id="filter-modal" title="Filter Facility Owners">
        <template #modal-body>
            <div class="form-group">
                <label for="filter-first-name" class="form-label">First Name</label>
                <input type="text"
                    class="form-control form-control-solid"
                    id="filter-first-name"
                    v-model="filters.first_name"
                    :readonly="processing"
                />
            </div>
            <div class="form-group">
                <label for="filter-last-name" class="form-label">Last Name</label>
                <input type="text"
                    class="form-control form-control-solid"
                    id="filter-last-name"
                    v-model="filters.last_name"
                    :readonly="processing"
                />
            </div>
            <div class="form-group">
                <label for="filter-phone-number" class="form-label">Phone No.</label>
                <input type="text"
                    class="form-control form-control-solid"
                    id="filter-phone-number"
                    v-model="filters.phone_number"
                    :readonly="processing"
                />
            </div>
            <div class="form-group">
                <label for="filter-email" class="form-label">Email</label>
                <input type="email"
                    class="form-control form-control-solid"
                    id="filter-email"
                    v-model="filters.email"
                    :readonly="processing"
                />
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
            <button type="button" class="btn btn-primary" @click="filterOwners">
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
import { toast } from 'vue3-toastify';
import throttle from 'lodash/throttle'
import { onMounted, ref, watch } from 'vue'
import { useAuthStore } from '@/stores/authStore.js'
import TabularTemplate from '@/components/TabularTemplate.vue'
import Modal from '@/components/Modal.vue'

const { permissions, config } = useAuthStore()

const processing = ref(true)

const search = ref('')

const searching = (value) => {
    search.value = value
}

watch(() => search.value, throttle(() => {
    fetchOwners()
}, 600))

const filter = ref(false)

const filters = ref({
    first_name: '',
    last_name: '',
    phone_number: '',
    email: '',
    from_date: '',
    to_date: ''
})

watch(() => filters.value.from_date, () => {
    if (!filters.value.to_date) {
        filters.value.to_date = moment().format('YYYY-MM-D')
    }
})

const clearFilters = async () => {
    processing.value = true

    filters.value.first_name = ''
    filters.value.last_name = ''
    filters.value.phone_number = ''
    filters.value.email = ''
    filters.value.from_date = ''
    filters.value.to_date = ''

    await fetchOwners()

    filter.value = false
}

const owners = ref({})

const fetchOwners = async (page = 1) => {
    let response = null
    try {
        response = await axios.get(`admin/facility-owners`, {
            ...config,

            params: {
                page,
                search: search.value,
                first_name: filters.value.first_name,
                last_name: filters.value.last_name,
                phone_number: filters.value.phone_number,
                email: filters.value.email,
                from_date: filters.value.from_date,
                to_date: filters.value.to_date,
            }
        })
    } catch (error) {
        response = error.response
    }

    if (response.status == 200) {
        owners.value = response.data
        processing.value = false
    } else {
        toast.error("Error fetching facility owners list")
    }

}

onMounted(() => {
    fetchOwners()
})

const showAddModal = () => {
    $('#add-modal').modal('show')
}

const errors = ref({})

const form = ref({
    first_name: '',
    last_name: '',
    phone_number: '',
    email: '',
})

const clearForm = () => {
    form.value.first_name = ''
    form.value.last_name = ''
    form.value.phone_number = ''
    form.value.email = ''
}

const submitForm = async () => {
    errors.value = {}
    processing.value = true

    let response = null
    try {
        response = await axios.post('admin/facility-owners', form.value, config)
    } catch (error) {
        response = error.response
    }

    if (response.status == 201) {
        toast.success("Facility owner added successfully")
        clearForm()
        $('#add-modal .btn-sm').click()
        fetchOwners()
    } else if (response.status == 422) {
        toast.error(response.data.message)
        errors.value = response.data.errors

        processing.value = false
    }
}

const showFilterModal = () => {
    $('#filter-modal').modal('show')
}

const filterOwners = async () => {
    $('#filter-modal .btn-sm').click()

    processing.value = true

    await fetchOwners()

    filter.value = true
}

const deleteOwner = (id) => {
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
                response = await axios.delete(`admin/facility-owners/${id}`, config)
            } catch (error) {
                response = error.response
                toast.error("Error deleting facility owner")
            }

            if (response.status == 200) {
                Swal.fire(
                    'Deleted!',
                    'Facility owner has been deleted.',
                    'success'
                )
                processing.value = true

                fetchOwners()
            }
        }
    })
}

</script>

<style scoped></style>
