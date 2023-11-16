<template>
  <div class="current">
    <div class="w-100">
      <div class="pb-10 pb-lg-15">
        <h2 class="fw-bold d-flex align-items-center text-dark">
          Create Facility Section.
          <span
            class="ms-1"
            data-bs-toggle="tooltip"
            title="Billing is issued based on your selected account typ"
          >
            <i class="ki-outline ki-information-5 text-gray-500 fs-6"></i>
          </span>
        </h2>
        <div class="text-muted fw-semibold fs-6">This is a single section within the Facility</div>
      </div>
      <div class="fv-row">
        <div class="row">
          <div class="col-lg-6">
            <div class="mb-10 fv-row">
              <label class="form-label mb-3">Section Name*</label>
              <input
                type="text"
                class="form-control form-control-lg "
                name="aisle"
                placeholder="Enter Section Name"
                v-model="stpOne.section"
              />
            </div>
          </div>
          <div class="col-lg-6">
          <div class="mb-10 fv-row">
              <label class="form-label mb-3">Enter Number of Aisle*</label>
              <input
                type="number"
                min="1"
                class="form-control form-control-lg "
                name="aisle"
                placeholder="Enter Number Aisle"
                v-model="stpOne.aisle"
              />
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script setup>
import { reactive } from "vue";
import { useFacilityStore } from "@/stores/facilityStore.js";

const { setOne,setSectionAisle } = useFacilityStore();

const stpOne = reactive({
    section: setOne.section,
    aisle:setOne.aisle
})
const submitStepOne = () => {
    setSectionAisle(stpOne);
}
defineExpose({
    submitStepOne,
   stpOne
  })
</script>
<style scoped>
</style>
