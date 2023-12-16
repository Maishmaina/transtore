<template>
  <div class="app-content flex-column-fluid">
    <div class="app-container container-fluid">
      <div class="card">
        <div class="card-body">
          <div class="row justify-content-center">
            <div class="col-6">
              <div class="card-px pt-10 pb-15">
                <div class="text-center">
                  <div class="d-flex flex-wrap flex-between">
                    <div class="py-3 px-3 mb-3">
                      <VueDatePicker v-model="rent_date" range multi-calendars />
                    </div>
                    <div class="py-3 px-3 mx-4 mb-3">
                      <div class="input-group input-group-sm mb-3">
                        <span class="input-group-text" id="basic-addon1">
                          <i class="fa fa-map-pin" aria-hidden="true"></i>
                        </span>
                        <input
                          type="text"
                          class="form-control"
                          placeholder="Location"
                          aria-describedby="basic-addon1"
                        />
                      </div>
                    </div>
                  </div>
                  <span class="d-flex flex-wrap flex-start">
                    <h2 class="fw-bold text-primary">
                      <i class="fas fa-bicycle text-black bg-warning p-1 fs-2 rounded-circle"></i>
                      <span style="margin-left: 5px;">Personal Items</span>
                    </h2>
                  </span>
                </div>
                <hr class="border-1" />
                <div class="d-flex justify-content-between">
                  <h6>50 Facilities</h6>
                  <h6>
                    <span>Rating</span>
                  </h6>
                </div>
                <hr class="border-1" />
                <div class="mb-1 card border-warning border p-4">
                  <div class="d-flex flex-wrap justify-content-between border-bottom">
                    <div class="d-flex flex-column">
                      <h5 class="text-primary">Select Unit</h5>
                    </div>
                    <div class="pr-15 ">
                        <h5>ABC Warehouse Limited</h5>
                    </div>
                  </div>
                   <span class="d-flex flex-wrap flex-center my-4">
                    <h2 class="fw-bold text-primary">
                      <i class="fas fa-bicycle text-black bg-warning p-1 fs-2 rounded-circle"></i>
                      <span style="margin-left: 5px;">Personal Items</span>
                    </h2>
                  </span>
                  <div class="table-responsive">
                    <table class="table table-hover fs-6 gy-5">
                        <thead>
                            <tr class="border">
                                <th>Option</th>
                                <th>Dimension</th>
                                <th>Weight</th>
                                <th>Per Day</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="border">
                                <td>Small</td>
                                <td>5*5*5(cm)</td>
                                <td>200kg</td>
                                <td>KES 200</td>
                                <td><button class="btn btn-outline btn-active-light-warning btn-sm">Select</button></td>
                            </tr>
                              <tr class="border">
                                <td>Small</td>
                                <td>5*5*5(cm)</td>
                                <td>200kg</td>
                                <td>KES 200</td>
                                <td><button class="btn btn-outline btn-active-light-warning btn-sm">Select</button></td>
                            </tr>
                        </tbody>
                    </table>
                  </div>
                </div>
                <div></div>
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
import VueDatePicker from "@vuepic/vue-datepicker";
import "@vuepic/vue-datepicker/dist/main.css";

import { useUserStore } from "@/stores/userStore.js";

let { user_config } = useUserStore();

const storageTypes = ref();

//set date picker
const rent_date = ref();

onMounted(() => {
  fetchStorageTypes();

  const startDate = new Date();
  const endDate = new Date(new Date().setDate(startDate.getDate() + 7));
  rent_date.value = [startDate, endDate];
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
</script>
<style scoped>
</style>
