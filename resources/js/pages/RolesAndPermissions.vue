<template>
    <TabularTemplate
        resource="Role"
        :fetchedData="roles"
        :processing="processing"
        :filterable="false"
        @add-clicked="showAddModal"
    >
        <template #thead>
            <th>Name</th>
            <th>Permissions</th>
            <th>Operators</th>
            <th>Date Created</th>
            <th class="text-end">Actions</th>
        </template>

        <template #tbody>
            <template v-if="roles.data.length">
                <tr v-for="role in roles.data" :key="role.id">
                    <td>{{ role.name }}</td>
                    <td>{{ role.permissions_count }}</td>
                    <td>{{ role.users_count }}</td>
                    <td>{{ moment(role.created_at).format('MMMM Do YYYY') }}</td>
                    <td class="text-end">
                        <template v-if="role.id !== 1">
                            <a href="#" type="button" class="btn btn-sm btn-primary">
                                <i class="fa-solid fa-rotate"></i>
                                Sync Permissions
                            </a>
                            <button type="button" class="ms-2 btn btn-sm btn-icon btn-danger" @click="deleteRole(role.id)">
                                <i class="fa-solid fa-trash"></i>
                            </button>
                        </template>
                    </td>
                </tr>
            </template>
        </template>

        <template #pagination>
            <Pagination :data="roles" @pagination-change-page="fetchRoles" :limit="5" />
        </template>
    </TabularTemplate>
    
    <Modal id="add-modal" title="Add Role">
        <template #modal-body>
            <div class="form-group">
                <label for="name" class="required form-label">Name</label>
                <input type="text" 
                    class="form-control form-control-solid" 
                    :class="{'is-invalid': errors.name}"
                    id="first-name" 
                    placeholder="Enter first name" 
                    v-model="form.name" 
                    :readonly="processing"
                />
                <div class="invalid-feedback" v-if="errors.name">
                    <small>{{ errors.name[0] }}</small>
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
</template>

<script setup>
import moment from 'moment'
import Swal from 'sweetalert2'
import { onMounted, ref } from 'vue'
import { useAuthStore } from '@/stores/authStore.js'
import { Bootstrap5Pagination as Pagination } from 'laravel-vue-pagination';
import TabularTemplate from '@/components/TabularTemplate.vue'
import Modal from '@/components/Modal.vue'
import { toast } from 'vue3-toastify'

const { token } = useAuthStore()

const config = {
    headers: {
        Authorization: `Bearer ${token}`
    }
}
const processing = ref(true)

const roles = ref([])

const fetchRoles = async (page = 1) => {
    let response = null
    try {
        response = await axios.get(`roles?page=${page}`, config)
    } catch (error) {
        response = error.response
    }
    
    if (response.status == 200) {
        roles.value = response.data
        processing.value = false
    } else {
        toast.error("Error fetching roles list")
    }
}

onMounted(() => {
    fetchRoles()
})

const showAddModal = () => {
    $('#add-modal').modal('show')
}

const errors = ref({})

const form = ref({
    name: '',
})

const submitForm = async () => {
    errors.value = {}
    processing.value = true
    
    let response = null
    try {
        response = await axios.post('roles', form.value, config)
    } catch (error) {
        response = error.response
    }
    
    if (response.status == 201) {
        toast.success("Role added successfully")
        $('#add-modal .btn-sm').click()
        form.value.name = ''
        fetchRoles()
    } else if (response.status == 422) {
        toast.error("Error adding role")
        errors.value = response.data.errors

        processing.value = false
    }
}

const deleteRole = (id) => {
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
                response = await axios.delete(`roles/${id}`, config)
            } catch (error) {
                response = error.response
            }

            if (response.status == 200) {
                Swal.fire(
                    'Deleted!',
                    'Role has been deleted.',
                    'success'
                )
                processing.value = true

                fetchRoles()
            } else if (response.status == 403) {
                toast.error(response.data.message)
            } else {
                toast.error("Error deleting role")
            }
        }
    })
}
</script>

<style scoped></style>