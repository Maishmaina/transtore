<template>
  <ul class="nav nav-stretch nav-line-tabs nav-line-tabs-2x border-transparent fs-5 fw-bold">
    <li class="nav-item">
      <button
        @click="setCurrentTab('details')"
        class="nav-link text-active-primary ms-0 me-10"
        :class="currentTabState=='details' ?'active':''"
        type="button"
      >Facility Details</button>
    </li>
    <li class="nav-item">
      <button
        @click="setCurrentTab('create')"
        class="nav-link text-active-primary ms-0 me-10"
        :class="currentTabState !='details'? 'active': ''"
        type="button"
      >Create New Section/Units</button>
    </li>
  </ul>
  <div v-if="currentTabState=='details'">
    <TabularTemplate
      resource="Facility"
      :fetched-data="facilityDetails"
      :processing="processing"
      :filter="filter"
      add-permission
      @add-clicked="showAddModal"
      @searching="searching"
      @clear-filters="clearFilters"
      @filter-clicked="showFilterModal"
    >
      <template #thead>
        <th>#</th>
        <th>Section Name</th>
        <th>Aisle Name</th>
        <th>Unit Name</th>
        <th>Unit Size</th>
        <th>Dimensions(CM)</th>
        <th>Weight(KG)</th>
        <th>Price</th>
        <th>Available</th>
        <th>Actions</th>
      </template>
      <template #tbody>
        <template v-if="facilityDetails.data">
          <tr v-for="(f_details,i) in facilityDetails.data">
            <td>{{ i+1 }}</td>
            <td>{{ f_details.aisle.section.name }}</td>
            <td>{{ f_details.aisle.name }}</td>
            <td>{{ f_details.name }}</td>
            <td>{{ f_details.unit_size.name }}</td>
            <td>{{ f_details.dimension }}</td>
            <td>{{ f_details.weight }}</td>
            <td>{{ f_details.price }}</td>
            <td>
              <span class="badge badge-light-success" v-if="f_details.available_status==1">Open</span>
              <span class="badge badge-light-danger" v-else>Close</span>
            </td>
            <td>
              <div class="d-flex">
                <button
                  type="button"
                  @click="editUnitDetails(f_details)"
                  class="btn btn-sm btn-icon btn-clear btn-active-light-primary me-3"
                  data-bs-toggle="tooltip"
                  data-bs-placement="top"
                  title="Edit"
                >
                  <i class="ki-outline ki-message-edit fs-2 m-0"></i>
                </button>
                <button
                  :disabled="f_details.available_status==0"
                  @click="deleteUnit(f_details.id)"
                  v-if="permissions.includes('delete facilities')"
                  type="button"
                  class="btn btn-sm btn-icon btn-light text-danger btn-active-light-danger me-2"
                  data-bs-toggle="tooltip"
                  data-bs-placement="top"
                  title="Delete"
                >
                  <i class="ki-outline ki-trash fs-2 m-0"></i>
                </button>
              </div>
            </td>
          </tr>
        </template>
        <tr v-else>
          <td colspan="7" class="text-center">No data available</td>
        </tr>
      </template>
      <template #pagination>
        <Pagination
          :data="facilityDetails"
          @pagination-change-page="fetchFacilityDetails"
          :limit="5"
        />
      </template>
    </TabularTemplate>

    <Modal id="unit-details-modal" :title="`Edit Unit Details`">
      <template #modal-body>
        <div class="d-flex flex-column mb-8 fv-row">
          <label class="d-flex align-items-center fs-6 fw-semibold mb-2">
            <span class="required">Unit Name</span>
            <span
              class="ms-1"
              data-bs-toggle="tooltip"
              title="Specify a target name for future usage and reference"
            ></span>
          </label>
          <input type="text" class="form-control" placeholder="Unit Name" v-model="form.name" />
        </div>
        <div class="fv-row mb-5">
          <label class="required fs-6 fw-semibold mb-2">Assign</label>
          <select class="form-select" id="target_assign" v-model="form.size">
            <option value>Select Size...</option>
            <option value="1">Small</option>
            <option value="2">Medium</option>
            <option value="3">Large</option>
          </select>
        </div>
        <div class="d-flex flex-column mb-8 fv-row">
          <label class="d-flex align-items-center fs-6 fw-semibold mb-2">
            <span class="required">Dimension</span>
            <span
              class="ms-1"
              data-bs-toggle="tooltip"
              title="Specify a target name for future usage and reference"
            ></span>
          </label>
          <input type="text" class="form-control" placeholder="5*5*2" v-model="form.dimension" />
        </div>
        <div class="d-flex flex-column mb-8 fv-row">
          <label class="d-flex align-items-center fs-6 fw-semibold mb-2">
            <span class="required">Weight</span>
            <span
              class="ms-1"
              data-bs-toggle="tooltip"
              title="Specify a target name for future usage and reference"
            ></span>
          </label>
          <input type="number" class="form-control" placeholder="Unit Weight" v-model="form.weight" />
        </div>
        <div class="d-flex flex-column mb-8 fv-row">
          <label class="d-flex align-items-center fs-6 fw-semibold mb-2">
            <span class="required">Price</span>
            <span
              class="ms-1"
              data-bs-toggle="tooltip"
              title="Specify a target name for future usage and reference"
            ></span>
          </label>
          <input type="number" class="form-control" placeholder="Unit Price" v-model="form.price" />
        </div>
        <label class="form-check form-switch form-check-custom form-check-solid">
          <input
            class="form-check-input"
            type="checkbox"
            v-model="form.availability"
            :checked="form.availability=='true' ? 'checked':''"
          />
          <span class="form-check-label fw-semibold text-muted">Available</span>
        </label>
      </template>

      <template #modal-footer>
        <button type="button" class="btn btn-primary" @click="submitUnitEdit" :disabled="processing">
          <span class="indicator-label" v-if="!processing">Submit</span>
          <span class="indicator-progress d-block" v-else>
            Please wait...
            <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
          </span>
        </button>
      </template>
    </Modal>
  </div>
  <div v-else>
    <div>
      <div
        class="stepper stepper-pills stepper-column d-flex flex-column flex-xl-row flex-row-fluid gap-10"
        id="kt_create_account_stepper"
      >
        <facility-unit-steps :step="currentPost"></facility-unit-steps>
        <div class="card d-flex flex-row-fluid flex-center">
          <form
            class="card-body w-100 mw-xl-800px px-1"
            novalidate="novalidate"
            id="kt_create_account_form"
          >
            <div v-if="currentPost===1">
              <facility-step-one ref="stepOneUI"></facility-step-one>
            </div>
            <div v-if="currentPost===2">
              <facility-step-two ref="stepTwo"></facility-step-two>
            </div>
            <div v-if="currentPost===3">
              <facility-step-three ref="stepThree"></facility-step-three>
            </div>
            <div v-if="currentPost===4">
              <facility-step-four></facility-step-four>
            </div>
            <div class="d-flex flex-stack pt-10">
              <div class="mr-2">
                <button
                  v-if="currentPost>1"
                  type="button"
                  @click="previous()"
                  class="btn btn-lg btn-light-primary me-3"
                >
                  <i class="ki-outline ki-arrow-left fs-4 me-1"></i>Back
                </button>
              </div>
              <div>
                <button
                  v-if="currentPost ===4"
                  @click="submitData()"
                  type="button"
                  class="btn btn-lg btn-primary me-3"
                >
                  <span class="indicator-label" v-if="!processing">
                    Submit
                    <i class="ki-outline ki-arrow-right fs-3 ms-2 me-0"></i>
                  </span>
                  <span v-else>
                    Please wait...
                    <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                  </span>
                </button>
                <button v-else type="button" class="btn btn-lg btn-primary" @click="nextStep()">
                  Next
                  <i class="ki-outline ki-arrow-right fs-4 ms-1 me-0"></i>
                </button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</template>
<script setup>
import { ref, onMounted, watch, reactive } from "vue";
import { useRoute } from "vue-router";
import { toast } from "vue3-toastify";
import throttle from "lodash/throttle";
import facilityUnitSteps from "@/components/facility/facility-unit-steps.vue";
import facilityStepOne from "@/components/facility/facility-step-one.vue";
import facilityStepTwo from "@/components/facility/facility-step-two.vue";
import facilityStepThree from "@/components/facility/facility-step-three.vue";
import facilityStepFour from "@/components/facility/facility-step-four.vue";
import { useAuthStore } from "@/stores/authStore.js";
import { useFacilityStore } from "@/stores/facilityStore.js";
import { Bootstrap5Pagination as Pagination } from "laravel-vue-pagination";
import TabularTemplate from "@/components/TabularTemplate.vue";
import Modal from "@/components/Modal.vue";

const route = useRoute();
const { config, permissions } = useAuthStore();
const {
  setOne,
  aisleListing,
  tabState,
  steps,
  stepsProgress,
  clearDetails
} = useFacilityStore();
const form = reactive({
  id: "",
  name: "",
  size: "",
  dimension: "",
  weight: "",
  availability: ""
});
const facilityDetails = ref([]);
const currentTabState = ref(tabState);
const currentPost = ref(steps);

//emit methods:
const stepOneUI = ref(null);
const stepTwo = ref(null);
const stepThree = ref(null);
const processing = ref(false);

const setCurrentTab = param => {
  currentTabState.value = param;
};

onMounted(() => {
  fetchFacilityDetails();
});
const previous = () => {
  if (currentPost.value > 1) {
    let previous = Number(currentPost.value) - 1;
    stepsProgress(previous);
    currentPost.value = currentPost.value - 1;
  }
};

const nextStep = () => {
  if (currentPost.value < 4) {
    if (_validate(currentPost.value)) {
      let nextItem = Number(currentPost.value) + 1;
      stepsProgress(nextItem);
      currentPost.value = currentPost.value + 1;
    } else {
      toast.error("Error Check All required Fields");
    }
  }
};

const _validate = step => {
  if (step === 1) {
    fetchFacilityDetails();
    let value = stepOneUI.value.stpOne;
    stepOneUI.value.submitStepOne();
    if (value.section && value.aisle) {
      return true;
    }
    return false;
  } else if (step === 2) {
    let value = stepTwo.value.aisle.aisle;
    stepTwo.value.submitStepTwo();
    const result = !value.some(aisle => Object.values(aisle).some(i => !i));
    return result;
  } else if (step === 3) {
    let result = false;

    let all_units = stepThree.value.aisle_unit;
    all_units.forEach(aisle_units => {
      const status = !aisle_units.unitsDetails.some(aisle =>
        Object.values(aisle).some(i => !i)
      );
      if (status === false) {
        result = false;
      } else {
        result = true;
      }
    });
    return result;
  }
};

const submitData = async () => {
  processing.value = true;
  let result = null;

  let submit_result = ref({
    facility: route.params.id,
    section: setOne,
    result_aisle: aisleListing
  });
  try {
    result = await axios.post("admin/units", submit_result.value, config);
  } catch (error) {
    processing.value = false;
    toast.error("Unit Mapping Failed, Confirm Details and Send");
  }
  if (result.data.message == "success") {
    fetchFacilityDetails();
    clearDetails();
    stepsProgress(1);
    setCurrentTab("details");
    currentPost.value = 1;
    processing.value = false;
    toast.success("Unit Mapping done successfully");
  } else {
    processing.value = false;
    toast.error("Unit Mapping Failed, Confirm Details and Send");
  }
};

const search = ref("");

const searching = value => {
  search.value = value;
};

const fetchFacilityDetails = async (page = 1) => {
  let response = null;
  try {
    response = await axios.get(`admin/units`, {
      ...config,
      params: {
        page,
        search: search.value,
        facility: route.params.id
      }
    });
  } catch (error) {
    response = error.response;
  }
  if (response.status == 200) {
    facilityDetails.value = response.data;
  } else {
    toast.error("Error fetching Facility Details");
  }
};

watch(
  () => search.value,
  throttle(() => {
    fetchFacilityDetails();
  }, 600)
);

//delete
const deleteUnit = id => {
  Swal.fire({
    title: "Are you sure?",
    text: "You won't be able to revert this!",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Yes, delete it!"
  }).then(async result => {
    if (result.isConfirmed) {
      let response = null;
      try {
        response = await axios.delete(`admin/units/${id}`, config);
      } catch (error) {
        response = error.response;
        toast.error("Error deleting facility");
      }

      if (response.status == 200) {
        Swal.fire("Deleted!", "Unit has been deleted.", "success");
        processing.value = false;
        fetchFacilityDetails();
      }
    }
  });
};

//edit unit details

const editUnitDetails = unit => {
  form.id = unit.id;
  form.name = unit.name;
  form.size = unit.size;
  form.dimension = unit.dimension;
  form.weight = unit.weight;
  form.price = unit.price;
  form.availability = unit.available_status == "1" ? true : false;

  $("#unit-details-modal").modal("show");
};
const submitUnitEdit = async () => {
  if (
    form.name == "" ||
    form.size == "" ||
    form.dimension == "" ||
    form.weight == "" ||
    form.price == ""
  ) {
    toast.error("Error, Empty Field Not Allowed");
  } else {
    processing.value = true;
    let result;
      try {
      result = await axios.patch(
        `admin/units/${form.id}`,
        form,
        config
      );
      processing.value = false;
    } catch (error) {
          result = error.response;
         processing.value = false;
      }
      if (result.status == 200){
          console.log(result);
          toast.success("Unit Updated Successfully")
          fetchFacilityDetails();
           $('#unit-details-modal .btn-sm').click()
      } else{
          toast.error("Error, Something wrong happened try again");
      }
  }
};
</script>
<style scoped>
</style>
