<template>
  <form class="form w-100" novalidate="novalidate" id="kt_sign_up_form">
    <div class="text-center mb-8">
      <h1 class="text-dark fw-bolder mb-2">Sign Up</h1>
      <div class="text-gray-500 fw-semibold fs-6">Create Account with Us</div>
    </div>
    <div class="fv-row mb-8">
        <label class="form-label">Your First Name</label>
      <input
        type="text"
        placeholder="First Name"
        name="name"
        autocomplete="off"
        class="form-control bg-transparent"
      />
    </div>
    <div class="fv-row mb-8">
     <label class="form-label" for="last_name">Your Last Name</label>
      <input
        type="text"
        placeholder="Last Name"
        name="last_name"
        autocomplete="off"
        class="form-control bg-transparent"
      />
    </div>
    <div class="fv-row mb-8">
        <label for="email" class="form-label">Your Email</label>
      <input
        type="text"
        placeholder="Email"
        name="email"
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
    <div class="fv-row mb-8">
      <label class="form-check form-check-inline">
        <input class="form-check-input" type="checkbox" name="toc" value="1" />
        <span class="form-check-label fw-semibold text-gray-700 fs-base ms-1"
          >I Accept the <a href="#" class="ms-1 link-primary">Terms</a></span
        >
      </label>
    </div>
    <div class="d-grid mb-10">
      <button type="submit" id="kt_sign_up_submit" class="btn btn-primary">
        <span class="indicator-label">Sign up</span>
        <span class="indicator-progress"
          >Please wait...
          <span class="spinner-border spinner-border-sm align-middle ms-2"></span
        ></span>
      </button>
    </div>
    <div class="text-gray-500 text-center fw-semibold fs-6">
      Already have an Account?
      <router-link
        :to="{name:'login'}"
        class="link-primary fw-semibold"
        >Sign in</router-link
      >
    </div>
  </form>
</template>

<script setup>
import { ref } from "vue";
import { useRouter } from "vue-router";
import { toast } from "vue3-toastify";

const router = useRouter();

const errors = ref({});
const processing = ref(false);

const form = ref({
  email: "",
});

const submitForm = async () => {
  errors.value = {};
  processing.value = true;

  let response = null;
  try {
    response = await axios.post("forgot-password", form.value);
  } catch (error) {
    response = error.response;
    error = response.data;

    toast.error(error.message);
    errors.value = error.errors ?? {};
  }

  processing.value = false;

  if (response.status == 200) {
    router.push({ name: "reset-password" });
  }
};
</script>

<style scoped></style>
