<template>
  <div class="app-content flex-column-fluid">
    <div class="app-container container-fluid">
      <div class="card">
        <div class="card-body">
          <div class="row justify-content-center">
            <div class="col-6">
              <div class="card-px pt-10 pb-15">
                <div class="text-center">
                  <h1 class="fw-bold">Rent a storage unit</h1>
                  <h3
                    class="mb-0 text-gray-600"
                  >Search and rent a storage unit from storage facility across the country that match your storage needs.</h3>
                </div>
                <hr class="border-2" />
                <div class="text-center pt-5">
                  <h2 class="fw-bold">What would you like to store?</h2>
                </div>
                <div>
                  <div v-for="store in storageTypes " :key="store.id">
                    <h1 class="fw-bold text-primary py-10">
                      <span>{{ store.name }} Storage</span>
                    </h1>

                    <router-link to="facility-filter"
                      v-for="substore in store.subtypes"
                      @click="saveClickedType(substore)"
                      class="mb-5"
                      :key="substore.id"
                    >
                      <span class="d-flex align-items-left me-2">
                        <span class="d-flex flex-column">
                          <h1 class="fw-bold text-primary">
                            <i
                              class="ki-outline ki-lock-3 text-black bg-warning fs-2x rounded-circle"
                            ></i>
                            <span style="margin-left: 5px;">{{ substore.name }}</span>
                          </h1>
                          <span
                            class="fs-6 fw-semibold text-black"
                          >Search and rent storage facilities and units, view and manage your storage rentals, request a pick-up/drop-off for your storage items. Search and rent storage facilities and units, view and manage your storage rentals, request a pick-up/drop-off for your storage items</span>
                        </span>
                        <span class="form-check form-check-custom ">
                          <input
                            class="form-check-input  cursor-pointer"
                            type="radio"
                            name="account_plan"
                            value="1"
                          />
                        </span>
                      </span>
                      <hr />
                    </router-link>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div></div>
        </div>
      </div>
    </div>
  </div>
</template>
<script setup>
import { ref, onMounted } from "vue";
import { toast } from "vue3-toastify";

import { useUserStore } from "@/stores/userStore.js";
let { user_config } = useUserStore();

import { useRentFacilityStore } from "@/stores/rentFacilityStore.js";
let { saveSelectedFacility } = useRentFacilityStore();

const storageTypes = ref();

onMounted(() => {
  fetchStorageTypes();
});

const fetchStorageTypes = async () => {
  let response = null;
  try {
    response = await axios.get("/storage-type-list", user_config);
  } catch (error) {
    response = error.response;
  }

  if (response.status == 200) {
    storageTypes.value = response.data;
  } else {
    toast.error("Error fetching storage types list");
  }
};
const saveClickedType = (s_type) => {

    saveSelectedFacility(s_type);
}
</script>
<style scoped>
</style>
