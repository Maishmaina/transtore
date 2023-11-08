<template>
	<div id="kt_app_content" class="app-content flex-column-fluid">
								<div id="kt_app_content_container" class="app-container container-fluid">
									<div class="stepper stepper-pills stepper-column d-flex flex-column flex-xl-row flex-row-fluid gap-10" id="kt_create_account_stepper">
                                        <facility-unit-steps></facility-unit-steps>

										<div class="card d-flex flex-row-fluid flex-center">
											<form class="card-body py-20 w-100 mw-xl-700px px-9" novalidate="novalidate" id="kt_create_account_form">
                                                <facility-step-one></facility-step-one>
												<div class="d-flex flex-stack pt-10">
													<div class="mr-2">
														<button type="button" @click="previous()" class="btn btn-lg btn-light-primary me-3">
														<i class="ki-outline ki-arrow-left fs-4 me-1"></i>Back</button>
													</div>
													<div>
														<button type="button" class="btn btn-lg btn-primary me-3">
															<span class="indicator-label">Submit
															<i class="ki-outline ki-arrow-right fs-3 ms-2 me-0"></i></span>
															<span class="indicator-progress">Please wait...
															<span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
														</button>
														<button type="button" class="btn btn-lg btn-primary" @click="nextStep()">Continue{{ currentPost }}
														<i class="ki-outline ki-arrow-right fs-4 ms-1 me-0"></i></button>
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
import { useRoute } from 'vue-router'
import facilityUnitSteps from '@/components/facility/facility-unit-steps.vue';
import facilityStepOne from '@/components/facility/facility-step-one.vue';
import { useFacilityStore } from "@/stores/facilityStore.js";

const { steps, stepsProgress }=useFacilityStore();

const currentPost = ref(steps);

const nextStep = () => {
    let nextItem = Number(steps)+1;
    stepsProgress(nextItem);

    currentPost.value + 1;
}

const previous = () => {
    let previous = Number(steps)-1;
    stepsProgress(previous);
}

const route = useRoute()
// console.log(route.params.id);
</script>
<style scoped>

</style>
