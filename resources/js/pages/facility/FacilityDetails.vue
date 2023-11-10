<template>
  <div id="kt_app_content" class="app-content flex-column-fluid">
    <div id="kt_app_content_container" class="app-container container-fluid">
      <div
        class="stepper stepper-pills stepper-column d-flex flex-column flex-xl-row flex-row-fluid gap-10"
        id="kt_create_account_stepper"
      >
        <facility-unit-steps :step="currentPost"></facility-unit-steps>
        <div class="card d-flex flex-row-fluid flex-center">
          <form
            class="card-body py-20 w-100 mw-xl-800px px-1"
            novalidate="novalidate"
            id="kt_create_account_form"
          >
            <div v-if="currentPost===1">
              <facility-step-one ref="stepOne"></facility-step-one>
            </div>
            <div v-if="currentPost===2">
              <facility-step-two></facility-step-two>
            </div>
            <div v-if="currentPost===3">
              <facility-step-three></facility-step-three>
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
                <button v-if="currentPost ===4" type="button" class="btn btn-lg btn-primary me-3">
                  <span class="indicator-label">
                    Submit
                    <i class="ki-outline ki-arrow-right fs-3 ms-2 me-0"></i>
                  </span>
                  <span class="indicator-progress">
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
import { toast } from 'vue3-toastify';
import facilityUnitSteps from "@/components/facility/facility-unit-steps.vue";
import facilityStepOne from "@/components/facility/facility-step-one.vue";
import facilityStepTwo from "@/components/facility/facility-step-two.vue";
import facilityStepThree from "@/components/facility/facility-step-three.vue";
import facilityStepFour from "@/components/facility/facility-step-four.vue";
import { useFacilityStore } from "@/stores/facilityStore.js";


const { steps, stepsProgress } = useFacilityStore();

const currentPost = ref(steps);

//emit methods:
const stepOne = ref(null);

const previous = () => {
  if (currentPost.value > 1) {
    let previous = Number(currentPost.value) - 1;
    stepsProgress(previous);
    currentPost.value = currentPost.value - 1;
  }
};

const nextStep = () => {
    if (currentPost.value < 4) {

        if (_validate(currentPost.value)){
            let nextItem = Number(currentPost.value) + 1;
            stepsProgress(nextItem);
            currentPost.value = currentPost.value + 1;
        } else {
            toast.error("Error Check All required Fields")
        }

  }
};

const _validate = (step) => {
    if (step === 1) {
        let value=stepOne.value.stpOne;
         stepOne.value.submitStepOne();
        if (value.section != "" && value.aisle != "") {
            return true;
        }
        return false;
    }
}
const route = useRoute();
// console.log(route.params.id);
</script>
<style scoped>
</style>
