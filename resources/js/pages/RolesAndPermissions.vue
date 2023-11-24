<template>
    <TabularTemplate
        resource="Role"
        :fetchedData="roles"
        :processing="processing"
        :filterable="false"
        add-permission="create roles"
        @add-clicked="showAddModal"
    >
        <template #thead>
            <th>Name</th>
            <th>Permissions</th>
            <th>Operators</th>
            <th>Date Created</th>
            <th class="text-end" v-if="userPermissions.includes('edit roles') || userPermissions.includes('delete roles')">Actions</th>
        </template>

        <template #tbody>
            <template v-if="roles.data.length">
                <tr v-for="role in roles.data" :key="role.id">
                    <td>{{ role.name }}</td>
                    <td>{{ `${role.permissions_count} of ${allPermissions.length}` }}</td>
                    <td>{{ role.users_count }}</td>
                    <td>{{ moment(role.created_at).format('MMMM Do YYYY') }}</td>
                    <td class="text-end" v-if="userPermissions.includes('edit roles') || userPermissions.includes('delete roles')">
                        <template v-if="role.id !== 1">
                            <button type="button" class="btn btn-sm btn-primary" @click="showPermissionsModal(role)" v-if="userPermissions.includes('edit roles')">
                                <i class="fa-solid fa-rotate"></i>
                                Sync Permissions
                            </button>
                            <button type="button" class="ms-2 btn btn-sm btn-icon btn-primary" @click="showEditModal(role)" v-if="userPermissions.includes('edit roles')">
                                <i class="fa-solid fa-pen-to-square"></i>
                            </button>
                            <button type="button" class="ms-2 btn btn-sm btn-icon btn-danger" @click="deleteRole(role.id)" v-if="userPermissions.includes('delete roles')">
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

    <Modal id="role-modal" :title="`${editRole ? 'Edit ' : 'Add '} Role`">
        <template #modal-body>
            <div class="form-group">
                <label for="name" class="required form-label">Name</label>
                <input type="text"
                    class="form-control form-control-solid"
                    :class="{'is-invalid': errors.name}"
                    id="name"
                    placeholder="Enter name"
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

    <Modal id="permissions-modal" :title="currentRole.name + ' Permissions'" size="large">
        <template #modal-body>
            <div class="row">
                <div class="my-3 col-md-4" v-for="permission in allPermissions" :key="permission">
                    <div class="form-check form-check-custom form-check-solid">
                        <input class="form-check-input" type="checkbox" :value="permission" :id="permission" v-model="permissions"/>
                        <label class="form-check-label" :for="permission">
                            {{ permission.toUpperCase() }}
                        </label>
                    </div>
                </div>
            </div>
        </template>

        <template #modal-footer>
            <button type="button" class="btn btn-primary" @click="syncPermissions">
                <span class="indicator-label" v-if="!processing">
                    Sync Permissions
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

const { token, permissions: userPermissions } = useAuthStore()

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
        response = await axios.get(`admin/roles?page=${page}`, config)
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

const allPermissions = ref([])

onMounted(() => {
    fetchRoles()

    axios.get('admin/permissions', config)
        .then(response => {
            allPermissions.value = response.data
        })
        .catch(() => {
            toast.error('Error fetching permissions')
        })
})

const editRole = ref(false)
const roleId = ref(null)

const form = ref({
    name: '',
})

const clearForm = () => {
    form.value.name = ''

    editRole.value = false
    roleId.value = null
}

const errors = ref({})


const showAddModal = () => {
    errors.value = {}
    clearForm()
    $('#role-modal').modal('show')
}


const showEditModal = (role) => {
    errors.value = {}
    editRole.value = true
    roleId.value = role.id
    form.value.name = role.name

    $('#role-modal').modal('show')
}

const submitForm = async () => {
    errors.value = {}
    processing.value = true

    let response = null
    try {
        if (editRole.value) {
            response = await axios.patch(`admin/roles/${roleId.value}`, form.value, config)
        } else {
            response = await axios.post('admin/roles', form.value, config)
        }
    } catch (error) {
        response = error.response
    }

    if (response.status == 201) {
        toast.success("Role added successfully")
    } else if (response.status == 200) {
        toast.success("Role updated successfully")
    } else if (response.status == 422) {
        toast.error("Error adding role")

        errors.value = response.data.errors
        processing.value = false
    }

    if ([200, 201].includes(response.status)) {
        $('#role-modal .btn-sm').click()
        clearForm()
        fetchRoles()
    }
}

const permissions = ref([])

const currentRole = ref({})

const showPermissionsModal = (role) => {
    role.permissions.forEach(permission => {
        if (allPermissions.value.includes(permission.name)) {
            permissions.value.push(permission.name)
        }
    })

    currentRole.value = role

    $('#permissions-modal').modal('show')
}

const syncPermissions = () => {
    let data = {
        role_id: currentRole.value.id,
        permissions: permissions.value
    }

    processing.value = true

    axios.post('admin/sync-permissions', data, config)
        .then(() => {
            toast.success('Permissions synced successfully')

            fetchRoles()

            $('#permissions-modal .btn-sm').click()
            permissions.value = []
            currentRole.value = {}

        })
        .catch(() => {
            toast.error('Error syncing permissions')
            processing.value =false
        })
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
                response = await axios.delete(`admin/roles/${id}`, config)
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
