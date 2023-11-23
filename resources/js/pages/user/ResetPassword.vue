<template>
  <form class="form w-100" novalidate="novalidate" id="kt_sign_in_form">
    <div class="text-center mb-11">
      <h1 class="text-dark fw-bolder mb-1">Setup New Password</h1>
    </div>
    <div class="fv-row mb-8">
        <label for="reset-code" class="form-label">Enter reset code</label>
      <input
        type="text"
        placeholder="Code"
        name="code"
        autocomplete="off"
        class="form-control bg-transparent"
      />
    </div>
        <div class="fv-row mb-8" data-kt-password-meter="true">
      <div class="mb-1">
        <div class="position-relative mb-3">
            <label for="password" class="form-label">Your Password</label>
          <input
            class="form-control bg-transparent"
            type="password"
            placeholder="Password"
            name="password"
            autocomplete="off"
          />
          <span
            class="btn btn-sm btn-icon position-absolute translate-middle top-50 end-0 me-n2"
            data-kt-password-meter-control="visibility"
          >
            <i class="ki-outline ki-eye-slash fs-2"></i>
            <i class="ki-outline ki-eye fs-2 d-none"></i>
          </span>
        </div>
        <div
          class="d-flex align-items-center mb-3"
          data-kt-password-meter-control="highlight"
        >
          <div
            class="flex-grow-1 bg-secondary bg-active-success rounded h-5px me-2"
          ></div>
          <div
            class="flex-grow-1 bg-secondary bg-active-success rounded h-5px me-2"
          ></div>
          <div
            class="flex-grow-1 bg-secondary bg-active-success rounded h-5px me-2"
          ></div>
          <div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px"></div>
        </div>
      </div>
      <div class="text-muted">
        Use 8 or more characters with a mix of letters, numbers & symbols.
      </div>
    </div>
    <div class="fv-row mb-8">
        <label for="email" class="form-label">Confirm password</label>
      <input
        placeholder="Repeat Password"
        name="confirm-password"
        type="password"
        autocomplete="off"
        class="form-control bg-transparent"
      />
    </div>
    <div class="d-grid mb-10">
      <button type="submit" id="kt_sign_in_submit" class="btn btn-primary">
        <span class="indicator-label">Sign In</span>
        <span class="indicator-progress"
          >Please wait...
          <span class="spinner-border spinner-border-sm align-middle ms-2"></span
        ></span>
      </button>
    </div>
    <div class="text-gray-500 text-center fw-semibold fs-6">
      Have you already reset the password ?
      <router-link :to="{name:'login'}" class="link-primary">Sign in</router-link>
    </div>
  </form>
</template>

<script setup>
import { ref, watch } from "vue";
import { useRoute, useRouter } from "vue-router";
import { useAuthStore } from "@/stores/authStore";
import { toast } from "vue3-toastify";
import PasswordInput from "@/components/PasswordInput.vue";

const route = useRoute();
const router = useRouter();
let { login } = useAuthStore();

if (route.query.password_changed) {
  toast.success("Password changed successfully. Please login.");
}

const form = ref({
  email: "",
  password: "",
});

const errors = ref({});

const processing = ref(false);

const submitForm = async () => {
  errors.value = {};

  processing.value = true;

  let response = await login(form.value);

  processing.value = false;

  if (response.status == 200) {
    // router.push({name: 'home'})
    window.location.href = "/";
  } else {
    let error = response.data;
    toast.error(error.message);
    errors.value = error.errors ?? {};
  }
};
</script>
<style scoped></style>
