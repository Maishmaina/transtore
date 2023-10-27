<template>
    <TabularTemplate
        resource="Storage Type"
        :fetchedData="storageTypes"
        :processing="processing"
        :filterable="false"
        add-permission="create storage types"
        @add-clicked="showAddModal"
    >
        <template #thead>
            <th>Name</th>
            <th>Subtypes</th>
            <th>Date Created</th>
            <th class="text-end" v-if="permissions.includes('edit storage types') || permissions.includes('delete storage types')">Actions</th>
        </template>

        <template #tbody>
            <template v-if="storageTypes.data.length">
                <tr v-for="storageType in storageTypes.data" :key="storageType.id">
                    <td>{{ storageType.name }}</td>
                    <td>{{ storageType.subtypes_count }}</td>
                    <td>{{ moment(storageType.created_at).format('MMMM Do YYYY') }}</td>
                    <td class="text-end" v-if="permissions.includes('edit storage types') || permissions.includes('delete storage types')">
                        <button type="button" class="btn btn-sm btn-icon btn-primary" @click="showEditModal(storageType)" v-if="permissions.includes('edit storage types')">
                            <i class="fa-solid fa-pen-to-square"></i>
                        </button>
                        <button type="button" class="ms-2 btn btn-sm btn-icon btn-danger" @click="deleteStorageType(storageType.id)" v-if="permissions.includes('delete storage types')">
                            <i class="fa-solid fa-trash"></i>
                        </button>
                    </td>
                </tr>
            </template>
        </template>

        <template #pagination>
            <Pagination :data="storageTypes" @pagination-change-page="fetchStorageTypes" :limit="5" />
        </template>
    </TabularTemplate>
    
    <Modal id="storage-types-modal" :title="`${editStorageType ? 'Edit ' : 'Add '} Storage Type`">
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
            <template v-if="editStorageType">
                <div>
                    <p class="mt-8 mb-2 fw-semibold fs-5">Subtypes</p>
                    
                    <table class="table table-row-bordered">
                        <tbody>
                            <tr v-for="storageSubtype in storageSubtypes">
                                <td>{{ storageSubtype.name }}</td>
                                <td class="text-end">
                                    <button type="button" class="btn m-0 p-0" @click="editStorageSubtype(storageSubtype)">
                                        <i class="fa-solid fa-pen-to-square text-primary"></i>
                                    </button>
                                    <button type="button" class="ms-2 btn m-0 p-0" @click="deleteStorageSubtype(storageSubtype.id)">
                                        <i class="fa-solid fa-trash text-danger"></i>
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    
                    <div class="input-group input-group-sm mb-5" v-if="!editingStorageSubtype">
                        <input type="text" class="form-control" placeholder="Add subtype" :readonly="processingStorageSubtype" v-model="storageSubtype"/>
                        <button 
                            type="button" 
                            class="input-group-text btn btn-primary btn-sm" 
                            :disabled="processingStorageSubtype || !storageSubtype" 
                            @click="addStorageSubtype"
                        >
                            Add
                        </button>
                    </div>
                    <template v-else>
                        <div class="input-group input-group-sm mb-2">
                            <input type="text" class="form-control" placeholder="Edit subtype" :readonly="processingStorageSubtype" v-model="storageSubtype"/>
                            <button 
                                type="button" 
                                class="input-group-text btn btn-primary btn-sm" 
                                :disabled="processingStorageSubtype || !storageSubtype" 
                                @click="updateStorageSubtype"
                            >
                                Edit
                            </button>
                        </div>
                        <div class="d-flex justify-content-end">
                            <button type="button" class="btn btn-sm p-0 m-0 fs-7 text-muted text-end" @click="cancelStorageSubtypeEdit">Cancel Edit</button>
                        </div>
                    </template>
                </div>
            </template>
        </template>

        <template #modal-footer>
            <button type="button" class="btn btn-primary" :disabled="processing || processingStorageSubtype" @click="submitForm">
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

const { config, permissions } = useAuthStore()

const processing = ref(true)

const storageTypes = ref([])

const fetchStorageTypes = async (page = 1) => {
    let response = null
    try {
        response = await axios.get(`storage-types?page=${page}`, config)
    } catch (error) {
        response = error.response
    }
    
    if (response.status == 200) {
        storageTypes.value = response.data
        processing.value = false
    } else {
        toast.error("Error fetching storage types list")
    }
}

onMounted(() => {
    fetchStorageTypes()
})

const editStorageType = ref(false)
const storageTypeId = ref(null)

const form = ref({
    name: '',
})

const clearForm = () => {
    form.value.name = ''

    editStorageType.value = false
    storageTypeId.value = null
}

const errors = ref({})

const showAddModal = () => {
    errors.value = {}
    clearForm()
    $('#storage-types-modal').modal('show')
}

const storageSubtypes = ref([])

const showEditModal = (storageType) => {
    errors.value = {}
    editStorageType.value = true
    storageTypeId.value = storageType.id
    storageSubtypes.value = storageType.subtypes
    form.value.name = storageType.name
    
    $('#storage-types-modal').modal('show')
}

const submitForm = async () => {
    errors.value = {}
    processing.value = true
    
    let response = null
    try {
        if (editStorageType.value) {
            response = await axios.patch(`storage-types/${storageTypeId.value}`, form.value, config)
        } else {
            response = await axios.post('storage-types', form.value, config)
        }
    } catch (error) {
        response = error.response
    }

    if (response.status == 201) {
        toast.success("Storage type added successfully")
    } else if (response.status == 200) {
        toast.success("Storage type updated successfully")
    } else if (response.status == 422) {
        toast.error("Error adding storage type")

        errors.value = response.data.errors
        processing.value = false
    }
    
    if ([200, 201].includes(response.status)) {
        $('#storage-types-modal .btn-sm').click()
        clearForm()
        fetchStorageTypes()
    }
}

const deleteStorageType = (id) => {
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
                response = await axios.delete(`storage-types/${id}`, config)
            } catch (error) {
                response = error.response
                toast.error(response.data.message)
            }

            if (response.status == 200) {
                Swal.fire(
                    'Deleted!',
                    'Storage type has been deleted.',
                    'success'
                )
                processing.value = true

                fetchStorageTypes()
            }
        }
    })
}

const processingStorageSubtype = ref(false)

const storageSubtype = ref('')

const addStorageSubtype = async () => {
    processingStorageSubtype.value = true

    let response = null
    try {
        response = await axios.post('storage-subtypes', {
            storage_type_id: storageTypeId.value,
            name: storageSubtype.value
        }, config)
    } catch (error) {
        response = error.response
        toast.error(response.data.message)
    }

    if (response.status == 201) {
        fetchStorageTypes()
        
        storageSubtype.value = ''
        storageSubtypes.value.push(response.data)
        
        toast.success('Storage subtype added successfully')
    }
    
    processingStorageSubtype.value = false
}

const editingStorageSubtype = ref(false)

const storageSubtypeId = ref('')

const editStorageSubtype = (subtype) => {
    editingStorageSubtype.value = true
    storageSubtype.value = subtype.name
    storageSubtypeId.value = subtype.id
}

const cancelStorageSubtypeEdit = () => {
    editingStorageSubtype.value = false
    storageSubtype.value = ''
    storageSubtypeId.value = ''
}

const updateStorageSubtype = async () => {
    processingStorageSubtype.value = true

    let response = null
    try {
        response = await axios.patch(`storage-subtypes/${storageSubtypeId.value}`, {
            name: storageSubtype.value
        }, config)
    } catch (error) {
        response = error.response
        toast.error(response.data.message)
    }

    if (response.status == 200) {
        fetchStorageTypes()
        
        storageSubtypes.value.find(subtype => subtype.id == storageSubtypeId.value).name = storageSubtype.value
        storageSubtype.value = ''
        storageSubtypeId.value = ''
        editingStorageSubtype.value = false
        
        toast.success('Storage subtype updated successfully')
    }
    
    processingStorageSubtype.value = false
}

const deleteStorageSubtype = (id) => {
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
                response = await axios.delete(`storage-subtypes/${id}`, config)
            } catch (error) {
                response = error.response
                toast.error(response.data.message)
            }

            if (response.status == 200) {
                Swal.fire(
                    'Deleted!',
                    'Storage subtype has been deleted.',
                    'success'
                )

                storageSubtypes.value = storageSubtypes.value.filter(subtype => subtype.id != id)

                processingStorageSubtype.value = true

            }
        }
    })
}
</script>

<style scoped></style>