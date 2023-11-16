<template>
  <div
    class="card d-flex justify-content-center justify-content-xl-start flex-row-auto w-100 w-xl-300px w-xxl-400px"
  >
    <div class="card-body px-6 px-lg-10 px-xxl-15 py-20">
      <div class="stepper-nav">
        <div class="stepper-item" :class="step==1 ? 'current':'' ">
          <div class="stepper-wrapper">
            <div class="stepper-icon w-40px h-40px">
              <i class="ki-outline ki-check fs-2 stepper-check"></i>
              <span class="stepper-number">1</span>
            </div>
            <div class="stepper-label">
              <h3 class="stepper-title">Create Section</h3>
              <div class="stepper-desc fw-semibold">Setup Section Details</div>
            </div>
          </div>
          <div class="stepper-line h-40px"></div>
        </div>
        <div class="stepper-item" :class="step==2 ? 'current':''">
          <div class="stepper-wrapper">
            <div class="stepper-icon w-40px h-40px">
              <i class="ki-outline ki-check fs-2 stepper-check"></i>
              <span class="stepper-number">2</span>
            </div>
            <div class="stepper-label">
              <h3 class="stepper-title">Aisle Settings</h3>
              <div class="stepper-desc fw-semibold">Setup Your Aisles</div>
            </div>
          </div>
          <div class="stepper-line h-40px"></div>
        </div>

        <div class="stepper-item" :class="step==3 ? 'current':''">
          <div class="stepper-wrapper">
            <div class="stepper-icon w-40px h-40px">
              <i class="ki-outline ki-check fs-2 stepper-check"></i>
              <span class="stepper-number">3</span>
            </div>
            <div class="stepper-label">
              <h3 class="stepper-title">Unit Settings</h3>
              <div class="stepper-desc fw-semibold">Unit Settings</div>
            </div>
          </div>
          <div class="stepper-line h-40px"></div>
        </div>

        <div class="stepper-item mark-completed" :class="step==4 ? 'current':''">
          <div class="stepper-wrapper">
            <div class="stepper-icon w-40px h-40px">
              <i class="ki-outline ki-check fs-2 stepper-check"></i>
              <span class="stepper-number">4</span>
            </div>
            <div class="stepper-label">
              <h3 class="stepper-title">Submit</h3>
              <div class="stepper-desc fw-semibold">Complete and Close</div>
            </div>
          </div>
          <div class="stepper-line h-40px"></div>
        </div>
      </div>
    </div>
  </div>
</template>
<script setup>
import { ref, watch } from "vue";
const props = defineProps({
  step: Number
});
const step = ref(props.step);
watch(
  () => props.step,
  () => {
    step.value = props.step;
  }
);
</script>
<style>
</style>
