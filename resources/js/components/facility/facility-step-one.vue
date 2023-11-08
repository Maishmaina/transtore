<template>
<div class="current" data-kt-stepper-element="content">
													<div class="w-100">
														<div class="pb-10 pb-lg-15">
															<h2 class="fw-bold d-flex align-items-center text-dark">Choose Account Type
															<span class="ms-1" data-bs-toggle="tooltip" title="Billing is issued based on your selected account typ">
																<i class="ki-outline ki-information-5 text-gray-500 fs-6"></i>
															</span></h2>
															<div class="text-muted fw-semibold fs-6">If you need more info, please check out
															<a href="#" class="link-primary fw-bold">Help Page</a>.</div>
														</div>
														<div class="fv-row">
															<div class="row">
																<div class="col-lg-6">
																	<input type="radio" class="btn-check" name="account_type" value="personal" checked="checked" id="kt_create_account_form_account_type_personal" />
																	<label class="btn btn-outline btn-outline-dashed btn-active-light-primary p-7 d-flex align-items-center mb-10" for="kt_create_account_form_account_type_personal">
																		<i class="ki-outline ki-badge fs-3x me-5"></i>
																		<span class="d-block fw-semibold text-start">
																			<span class="text-dark fw-bold d-block fs-4 mb-2">Personal Account</span>
																			<span class="text-muted fw-semibold fs-6">If you need more info, please check it out</span>
																		</span>
																	</label>
																</div>
																<div class="col-lg-6">
																	<input type="radio" class="btn-check" name="account_type" value="corporate" id="kt_create_account_form_account_type_corporate" />
																	<label class="btn btn-outline btn-outline-dashed btn-active-light-primary p-7 d-flex align-items-center" for="kt_create_account_form_account_type_corporate">
																		<i class="ki-outline ki-briefcase fs-3x me-5"></i>
																		<span class="d-block fw-semibold text-start">
																			<span class="text-dark fw-bold d-block fs-4 mb-2">Corporate Account</span>
																			<span class="text-muted fw-semibold fs-6">Create corporate account to mane users</span>
																		</span>
																	</label>
																</div>
															</div>
														</div>
													</div>
												</div>
</template>
<script setup>

</script>
<style scoped>

</style>
