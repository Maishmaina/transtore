<template>
  <div class="current">
    <div class="w-100">
      <div class="pb-10 pb-lg-15">
        <h2 class="fw-bold d-flex align-items-center text-dark">
          Section Setting Confirmation.
          <span
            class="ms-1"
            data-bs-toggle="tooltip"
            title="Billing is issued based on your selected account typ"
          >
            <i class="ki-outline ki-information-5 text-gray-500 fs-6"></i>
          </span>
        </h2>
        <div class="text-muted fw-semibold fs-6">Please confirm section Aisle details and Submit</div>
      </div>
      <div class="fv-row">
          <label class="btn btn-outline btn-outline-dashed btn-active-light-primary w-100 p-4">
          <input type="radio" class="btn-check" name="account_team_size" value="1-1" />
          <span class="fs-3 fw-bold">Configure Units on each Aisle:</span>
        </label>
      </div>
    </div>
  </div>
</template>
<script setup>
import { ref } from "vue";
import { useFacilityStore } from "@/stores/facilityStore.js";
const { setOne,aisleListing } = useFacilityStore();
const confirm_all = ref({
    section: setOne.section,
    aisle:aisleListing
})
console.log(confirm_all);
</script>
<style scoped>
</style>
