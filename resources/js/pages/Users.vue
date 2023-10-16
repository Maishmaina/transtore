<template>
    <Main page-name="Customers List">
        <div class="card">
            <div class="card-header border-0 pt-6">
                <div class="card-title">
                    <div class="d-flex align-items-center position-relative my-1">
                        <i class="ki-outline ki-magnifier fs-3 position-absolute ms-5"></i>
                        <input type="text" class="form-control form-control-solid w-250px ps-12" placeholder="Search" />
                    </div>
                </div>
                <div class="card-toolbar">
                    <div class="d-flex justify-content-end">
                        <button type="button" class="btn btn-light-primary me-3" data-bs-toggle="modal" data-bs-target="#filter-modal">
                            <i class="ki-outline ki-filter fs-2"></i>
                            Filter
                        </button>
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#add-modal">Add Customer</button>
                    </div>
                </div>
            </div>
            <div class="card-body pt-0">
                <div class="table-responsive">
                    <table class="table table-striped align-middle table-row-dashed fs-6 gy-5">
                        <thead>
                            <tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0">
                                <th>First Name</th>
                                <th>Last Name</th>
                                <th>Phone No.</th>
                                <th>Email</th>
                                <th>Date Joined</th>
                                <th>Status</th>
                                <th class="text-end">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="fw-semibold text-gray-600">
                            <tr v-for="user in users.data">
                                <td>{{ user.first_name }}</td>
                                <td>{{ user.last_name }}</td>
                                <td>{{ user.phone_number }}</td>
                                <td>{{ user.email }}</td>
                                <td>{{ moment(user.created_at).format('MMMM Do YYYY') }}</td>
                                <td>
                                    <span class="badge badge-light-success" v-if="user.enabled">Enabled</span>
                                    <span class="badge badge-light-danger" v-else>Disabled</span>
                                </td>
                                <td class="text-end">
                                    <a href="#" type="button" class="btn btn-sm btn-icon btn-primary">
                                        <i class="fa-solid fa-eye"></i>
                                    </a>
                                    <button type="button" class="ms-2 btn btn-sm btn-icon btn-danger" @click="deleteItem(user.id)">
                                        <i class="fa-solid fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="mt-3 d-flex justify-content-between align-items-center" v-if="users.data">
                        <div>{{ `Showing ${users.meta.from ?? 0} to ${users.meta.to ?? 0} of ${users.meta.total} entries` }}</div>
                        <nav>
                            <Pagination :data="users" @pagination-change-page="fetchUsers" :limit="5" />
                        </nav>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" tabindex="-1" id="add-modal">
            <div class="modal-dialog modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3 class="modal-title">Add Customer</h3>

                        <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                            <i class="ki-duotone ki-cross fs-1"><span class="path1"></span><span class="path2"></span></i>
                        </div>
                    </div>

                    <div class="modal-body">
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
                        <div class="mt-6 form-check form-switch form-check-custom form-check-solid">
                            <input class="form-check-input h-25px w-40px" type="checkbox" id="enabled" v-model="form.enabled" :readonly="processing"/>
                            <label class="form-check-label" for="enabled">
                                Enabled
                            </label>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" @click="submitForm">
                            <span class="indicator-label" v-if="!processing">
                                Submit
                            </span>
                            <span class="indicator-progress d-block" v-else>
                                Please wait... <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                            </span>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" tabindex="-1" id="filter-modal">
            <div class="modal-dialog modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3 class="modal-title">Filters</h3>

                        <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                            <i class="ki-duotone ki-cross fs-1"><span class="path1"></span><span class="path2"></span></i>
                        </div>
                    </div>

                    <div class="modal-body">
                        <p>Modal body text goes here.</p>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary">Submit</button>
                    </div>
                </div>
            </div>
        </div>
    </Main>
</template>

<script setup>
import moment from 'moment'
import { onMounted, ref } from 'vue'
import { useAuthStore } from '@/stores/authStore.js'
import Main from '@/components/Main.vue'
import { toast } from 'vue3-toastify';
import Swal from 'sweetalert2'
import { Bootstrap5Pagination as Pagination } from 'laravel-vue-pagination';

const { token } = useAuthStore()

const config = {
    headers: {
        Authorization: `Bearer ${token}`
    }
}

const users = ref({})

const fetchUsers = async (page = 1) => {
    let response = null
    try {
        response = await axios.get(`users?page=${page}`, config)
    } catch (error) {
        response = error.response
    }
    
    if (response.status == 200) {
        users.value = response.data
    } else {
        toast.error("Error fetching customers list")
    }

}

onMounted(() => {
    fetchUsers()
})

// TABLE ACTIONS
const errors = ref({})
const processing = ref(false)

const form = ref({
    first_name: '',
    last_name: '',
    phone_number: '',
    email: '',
    enabled: true,
})

const clearForm = () => {
    form.value.first_name = '',
    form.value.last_name = '',
    form.value.phone_number = '',
    form.value.email = '',
    form.value.enabled = true
}

const submitForm = async () => {
    errors.value = {}
    processing.value = true
    
    let response = null
    try {
        response = await axios.post('users', form.value, config)
    } catch (error) {
        toast.error("Error adding customer")
        response = error.response
        errors.value = response.data.errors
    }
    
    if (response.status == 201) {
        fetchUsers()
        $('#add-modal .btn-sm').click()
        clearForm()
        toast.success("Customer added successfully")
    }

    processing.value = false

}

const deleteItem = (id) => {
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
                response = await axios.delete(`users/${id}`, config)
            } catch (error) {
                response = error.response
                toast.error("Error deleting customer")
            }

            if (response.status = 200) {
                fetchUsers()

                Swal.fire(
                    'Deleted!',
                    'Customer has been deleted.',
                    'success'
                )
            }
        }
    })
}
</script>

<style scoped>
.table.table-striped th:first-child,
.table.table-striped td:first-child {
    padding-left: 0.75rem;
}
</style>