<template>
  <div class="current">
    <div class="w-100">
      <div class="pb-10 pb-lg-15">
        <h2 class="fw-bold d-flex align-items-center text-dark">
          Unit Settings.
          <span
            class="ms-1"
            data-bs-toggle="tooltip"
            title="Billing is issued based on your selected account typ"
          >
            <i class="ki-outline ki-information-5 text-gray-500 fs-6"></i>
          </span>
        </h2>
        <div class="text-muted fw-semibold fs-6">Sep Three includes Units Settings</div>
      </div>
      <div class="fv-row">
        <label class="btn btn-outline btn-outline-dashed btn-active-light-primary w-100 p-4">
          <input type="radio" class="btn-check" name="account_team_size" value="1-1" />
          <span class="fs-3 fw-bold">Configure Units on each Aisle:</span>
        </label>
        <div class="pe-md-10 mb-10 mb-md-0">
          <div class="m-0" v-for="(aisle,i) in aisle_unit" :key="i">
            <div
              class="d-flex align-items-center collapsible py-3 toggle mb-0"
              data-bs-toggle="collapse"
              :data-bs-target="'#'+i"
              :class="i!=0?'collapsed':''"
            >
              <div class="btn btn-sm btn-icon mw-20px btn-active-color-primary me-5">
                <i class="ki-outline ki-minus-square toggle-on text-primary fs-1"></i>
                <i class="ki-outline ki-plus-square toggle-off fs-1"></i>
              </div>
              <h4
                class="text-gray-700 fw-bold cursor-pointer mb-0"
              >Name: {{ aisle.name }}, Number of Units: {{ aisle.units }}</h4>
            </div>
            <div :id="i" class="collapse fs-6 ms-1" :class="i===0?'show':''">
              <div class="mb-4 text-gray-600 fw-semibold fs-6 ps-10">
                <div class="table-responsive">
                  <table class="table table-striped align-middle table-row-dashed fs-6 gy-5">
                    <thead>
                      <tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0">
                        <th>Aisle Name</th>
                        <th>Unit Name</th>
                        <th>Unit Size</th>
                        <th>Dimension(cm)</th>
                        <th>Weight(Kg)</th>
                        <th>Price</th>
                      </tr>
                    </thead>
                    <tbody class="fw-semibold text-gray-600">
                      <tr v-for="(in_unit,x) in aisle.unitsDetails" :key="x">
                        <td>
                          <input
                            type="text"
                            class="form-control"
                            id="location"
                            placeholder="Aisle 1"
                            disabled
                            v-model="in_unit.aisleName"
                          />
                        </td>
                        <td>
                          <input
                            type="text"
                            class="form-control"
                            id="location"
                            placeholder="Unit 1"
                            v-model="in_unit.unitName"
                          />
                        </td>
                        <td>
                          <select
                            class="form-select"
                            id="filter-owner"
                            v-model="in_unit.size"
                          >
                            <option value>Select Size...</option>
                            <option value="1" key="1">Small</option>
                            <option value="2" key="2">Medium</option>
                            <option value="3" key="3">Large</option>
                          </select>
                        </td>
                        <td>
                          <input
                            type="text"
                            class="form-control"
                            id="location"
                            placeholder="10*10*5"
                            v-model="in_unit.dimension"
                          />
                        </td>
                        <td>
                          <input
                            type="number"
                            class="form-control"
                            id="location"
                            placeholder="200"
                            v-model="in_unit.weight"
                          />
                        </td>
                        <td>
                          <input
                            type="number"
                            class="form-control"
                            id="location"
                            placeholder="1000"
                            v-model="in_unit.price"
                          />
                        </td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
            <div class="separator separator-dashed"></div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script setup>
import { ref } from "vue";
import { useFacilityStore } from "@/stores/facilityStore.js";

const { aisleListing } = useFacilityStore();
const aisle_unit = ref(aisleListing);

defineExpose({
  aisle_unit
});
</script>
<style scoped>
</style>
