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
                          v-model="search_text"
                        />
                      </div>
                    </div>
                  </div>
                  <span class="d-flex flex-wrap flex-start">
                    <h1 class="fw-bold text-primary">
                      <i class="fas fa-bicycle text-black bg-warning p-1 fs-2 rounded-circle"></i>
                      <span style="margin-left: 5px;">{{ facility_type? facility_type.name:'' }}</span>
                    </h1>
                  </span>
                </div>
                <hr class="border-1" />
                <div class="d-flex justify-content-between">
                  <h6>50 Facilities</h6>
                  <h6>
                    <span>Rating</span>
                    <!-- <i class="ki-solid ki-down-square text-black fs-2"></i> -->
                  </h6>
                </div>
                <hr class="border-1" />
                <div class="mb-1">
                  <div class="d-flex flex-wrap justify-content-between">
                    <div class="d-flex flex-column">
                      <h1 class="fw-bold text-primary d-flex flex-wrap">
                        <span class="mr-3">ABC warehouse</span>
                        <div class="rating justify-content-end" style="margin-left: 5px;">
                          <div class="rating-label checked">
                            <i class="ki-solid ki-star fs-6"></i>
                          </div>
                          <div class="rating-label checked">
                            <i class="ki-solid ki-star fs-6"></i>
                          </div>
                          <div class="rating-label checked">
                            <i class="ki-solid ki-star fs-6"></i>
                          </div>
                          <div class="rating-label">
                            <i class="ki-solid ki-star fs-6"></i>
                          </div>
                          <div class="rating-label">
                            <i class="ki-outline ki-star fs-6"></i>
                          </div>
                        </div>
                      </h1>
                      <span class="text-black">
                        Rated
                        <span class="fw-bold">4</span> out of
                        <span class="fw-bold">5</span> from
                        <span class="text-primary">1,000 Reviews</span>
                      </span>
                      <p class="fw-bold text-primary my-1">Indoor and Outdoor units</p>
                      <span class="text-black">Small, Medium and Large units available</span>
                    </div>
                    <div class="pr-15 justify-content-center">
                      <div class="d-flex flex-column align-items-center">
                        <p>From</p>
                        <h3 style="line-height: 0.1!important;">KES 200</h3>
                        <p>Per Day</p>
                      </div>
                      <button @click="showFilterModal('data')" class="btn btn-warning btn-sm">Select Unit</button>
                    </div>
                  </div>
                  <hr />
                   <div class="d-flex flex-wrap justify-content-between">
                    <div class="d-flex flex-column">
                      <h1 class="fw-bold text-primary d-flex flex-wrap">
                        <span class="mr-3">ABC warehouse</span>
                        <div class="rating justify-content-end" style="margin-left: 5px;">
                          <div class="rating-label checked">
                            <i class="ki-solid ki-star fs-6"></i>
                          </div>
                          <div class="rating-label checked">
                            <i class="ki-solid ki-star fs-6"></i>
                          </div>
                          <div class="rating-label checked">
                            <i class="ki-solid ki-star fs-6"></i>
                          </div>
                          <div class="rating-label">
                            <i class="ki-solid ki-star fs-6"></i>
                          </div>
                          <div class="rating-label">
                            <i class="ki-outline ki-star fs-6"></i>
                          </div>
                        </div>
                      </h1>
                      <span class="text-black">
                        Rated
                        <span class="fw-bold">4</span> out of
                        <span class="fw-bold">5</span> from
                        <span class="text-primary">1,000 Reviews</span>
                      </span>
                      <p class="fw-bold text-primary my-1">Indoor and Outdoor units</p>
                      <span class="text-black">Small, Medium and Large units available</span>
                    </div>
                    <div class="pr-15 justify-content-center">
                      <div class="d-flex flex-column align-items-center">
                        <p>From</p>
                        <h3 style="line-height: 0.1!important;">KES 200</h3>
                        <p>Per Day</p>
                      </div>
                      <button @click="showFilterModal('data')" class="btn btn-warning btn-sm">Select Unit</button>
                    </div>
                  </div>
                  <hr />

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
  <Modal id="select-unit-modal" title="Select Unit">
    <template #modal-body>
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
                                <td>Medium</td>
                                <td>5*5*10(cm)</td>
                                <td>300kg</td>
                                <td>KES 300</td>
                                <td><button class="btn btn-outline btn-active-light-warning btn-sm">Select</button></td>
                            </tr>
                             <tr class="border">
                                <td>Large</td>
                                <td>5*5*20(cm)</td>
                                <td>400kg</td>
                                <td>KES 500</td>
                                <td><button class="btn btn-outline btn-active-light-warning btn-sm">Select</button></td>
                            </tr>
                        </tbody>
                    </table>
                  </div>
                </div>
    </template>
    <template #modal-footer>
      <button type="button" class="btn btn-primary" >
        <span class="indicator-label">Add Cart</span>
        <span class="indicator-progress d-none" >
          Please wait...
          <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
        </span>
      </button>
    </template>
  </Modal>

</template>
<script setup>
import { ref, onMounted, watch } from "vue";
import { toast } from "vue3-toastify";
import VueDatePicker from "@vuepic/vue-datepicker";
import "@vuepic/vue-datepicker/dist/main.css";
import throttle from "lodash/throttle";

import { useUserStore } from "@/stores/userStore.js";
import { useRentFacilityStore } from "@/stores/rentFacilityStore.js";
import Modal from "@/components/Modal.vue";

let { user_config } = useUserStore();
let { facility_type, rent_dates,rent_location,saveSelectedRage } = useRentFacilityStore();


const storageTypes = ref();

//set date picker
const rent_date = ref();
const search_text = ref(rent_location);

onMounted(() => {
  fetchStorageTypes();

  const startDate = new Date();
  const endDate = new Date(new Date().setDate(startDate.getDate() + 7));
  rent_date.value =rent_dates ? rent_dates: [startDate, endDate];
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
//fetch units from the system:

const returnUnitSearch = () => {

    saveSelectedRage(rent_date.value, search_text.value);
    //fetch
}

watch(
    () => search_text.value,
      throttle(() => {
     returnUnitSearch()
  }, 600)
)

watch(
    () => rent_date.value,
    () => returnUnitSearch()
)

const showFilterModal = (data) => {
    console.log(data);
  $("#select-unit-modal").modal("show");
};
</script>
<style scoped>
</style>
