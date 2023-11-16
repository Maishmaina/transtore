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
        <th>Section Name</th>
        <th>Aisle Name</th>
        <th>Unit Name</th>
        <th>Unit Size</th>
        <th>Unit Dimensions</th>
        <th>Weight</th>
        <th>Price</th>
        <th
          class="text-end"
        >Actions</th>
      </template>
      <template #tbody>
        <tr>
          <td colspan="7" class="text-center">No data available</td>
        </tr>
      </template>
      <template #pagination>
        <Pagination :data="facilities" @pagination-change-page="fetchFacilities" :limit="5" />
      </template>
    </TabularTemplate>
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
                  <span v-else >
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
import { ref } from "vue";
import { useRoute } from "vue-router";
import { toast } from "vue3-toastify";
import axios from 'axios';
import facilityUnitSteps from "@/components/facility/facility-unit-steps.vue";
import facilityStepOne from "@/components/facility/facility-step-one.vue";
import facilityStepTwo from "@/components/facility/facility-step-two.vue";
import facilityStepThree from "@/components/facility/facility-step-three.vue";
import facilityStepFour from "@/components/facility/facility-step-four.vue";
import { useAuthStore } from '@/stores/authStore.js'
import { useFacilityStore } from "@/stores/facilityStore.js";


import { Bootstrap5Pagination as Pagination } from "laravel-vue-pagination";
import TabularTemplate from "@/components/TabularTemplate.vue";

const { config } = useAuthStore();
const { setOne,aisleListing,tabState, steps, stepsProgress } = useFacilityStore();

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

  if (step === 1){
    let value = stepOneUI.value.stpOne;
    stepOneUI.value.submitStepOne();
    if (value.section != "" && value.aisle != "") {
      return true;
    }
    return false;
  }else if (step === 2){
    let value = stepTwo.value.aisle.aisle;
    stepTwo.value.submitStepTwo();
    const result = !value.some(aisle => Object.values(aisle).some(i => !i));
    return result;
  }else if (step === 3) {
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

/*
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
*/

const submitData = async () => {
    processing.value = true;
    let result = null;

    let submit_result = ref({
        facility:route.params.id,
        section: setOne,
        result_aisle: aisleListing
    })
    try {

        result = await axios.post('units',submit_result.value,config);

    } catch (error) {
        console.error(error);
    }
    console.log(result);
    toast.success("Unit Mapping done successfully");
};
const route = useRoute();
// console.log(route.params.id);
</script>
<style scoped>
</style>
