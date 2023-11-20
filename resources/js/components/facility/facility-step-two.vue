<template>
  <div class="current">
    <div class="w-100">
      <div class="pb-10 pb-lg-15">
        <h2 class="fw-bold d-flex align-items-center text-dark">
          Aisle Settings.
          <span
            class="ms-1"
            data-bs-toggle="tooltip"
            title="Billing is issued based on your selected account typ"
          >
            <i class="ki-outline ki-information-5 text-gray-500 fs-6"></i>
          </span>
        </h2>
        <div class="text-muted fw-semibold fs-6">Sep Two includes Aisle Settings</div>
      </div>
      <div class="fv-row">
        <label class="btn btn-outline btn-outline-dashed btn-active-light-primary w-100 p-4">
          <input type="radio" class="btn-check" name="account_team_size" value="1-1" />
          <span class="fs-3">
            Section Name:
            <span class="fw-bold">{{ aisle.section.section }}</span>
          </span>
          <span class="fs-3">
            Number of Aisle:
            <span class="fw-bold">{{ aisle.section.aisle }}</span>
          </span>
        </label>
        <div class="card-body pt-0">
          <div class="table-responsive">
            <table class="table table-striped align-middle table-row-dashed fs-6 gy-5">
              <thead>
                <tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0">
                  <th>Name</th>
                  <th>Unit Number</th>
                  <th>Unit Size</th>
                  <th>Dimension(cm)</th>
                  <th>Weight(Kg)</th>
                  <th>Price</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody class="fw-semibold text-gray-600">
                <tr v-for="(aisle,i) in aisle.aisle" :key="i">
                  <td>
                    <input
                    type="text"
                    class="form-control"
                    v-model="aisle.name"/>
                  </td>
                  <td>
                    <input
                      type="number"
                      min="1"
                      class="form-control"
                      placeholder="10"
                      v-model="aisle.units"
                    />
                  </td>
                  <td>
                    <select class="form-select" v-model="aisle.size">
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
                      placeholder="5*5*10"
                      v-model="aisle.dimension"
                    />
                  </td>
                  <td>
                    <input
                      type="number"
                      class="form-control"
                      placeholder="250"
                      v-model="aisle.weight"
                    />
                  </td>
                  <td>
                    <input
                      type="number"
                      class="form-control"
                      placeholder="250"
                      v-model="aisle.price"
                    />
                  </td>
                  <td>
                    <i @click="duplicate(aisle)" type="button" class="fa-solid fa-copy text-primary" title="duplicate this Aisle"></i>
                    <i @click="remove(aisle)" type="button" class="fa-solid fa-trash text-danger" title="remove this Aisle" style="margin-left:15px;"></i>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script setup>
import { ref } from "vue";
import { useFacilityStore } from "@/stores/facilityStore.js";
const { setOne, aisleListing, setAisleUnit } = useFacilityStore();
const aisle = ref({
  section: setOne,
  aisle: aisleListing
});

const submitStepTwo = () => {
    setAisleUnit(aisle.value.aisle);
};

const duplicate = (asl) => {

    let items = aisle.value.aisle;
    let index = items.indexOf(asl);
    let newIndex = index + 1;
    items.splice(newIndex, 0, asl);

}
const remove = (asl) => {
    let items = aisle.value.aisle;
    let index = items.indexOf(asl);
    if (index !== -1) {
    items.splice(index, 1);
}

}

defineExpose({
  submitStepTwo,
  aisle
});
</script>
<style scoped>
</style>
