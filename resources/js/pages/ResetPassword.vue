<template>
  <form class="form w-100" @submit.prevent="submitForm">
    <div class="text-center mb-10">
      <h1 class="text-dark fw-bolder mb-3">Setup New Password</h1>
      <div class="text-gray-500 fw-semibold fs-6">
        Have you already reset the password ?
        <router-link :to="{ name: 'admin_login' }" class="link-primary fw-bold"
          >Sign in</router-link
        >
      </div>
    </div>

    <div class="fv-row mb-8">
      <input
        type="text"
        placeholder="Reset Code"
        autocomplete="off"
        class="form-control bg-transparent"
        :class="{ 'is-invalid': errors.reset_code }"
        v-model="form.reset_code"
      />
      <div class="invalid-feedback" v-if="errors.reset_code">
        {{ errors.reset_code[0] }}
      </div>
    </div>

    <div class="fv-row mb-8">
      <PasswordInput :errors="errors" @input-changed="form.password = $event" />
    </div>

    <div class="fv-row mb-8">
      <PasswordInput
        :errors="errors"
        placeholder="Repeat password"
        field-name="password-confirmation"
        @input-changed="form.password_confirmation = $event"
      />
    </div>
    <div class="d-grid mb-10">
      <button type="submit" id="kt_new_password_submit" class="btn btn-primary">
        <span class="indicator-label">Submit</span>
        <span class="indicator-progress">
          Please wait...
          <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
        </span>
      </button>
    </div>
  </form>
</template>
<script setup>
import { ref } from "vue";
import { useRouter } from "vue-router";
import { toast } from "vue3-toastify";
import PasswordInput from "@/components/PasswordInput.vue";

const router = useRouter();

const errors = ref({});
const processing = ref(false);

const form = ref({
  reset_code: "",
  password: "",
  password_confirmation: "",
});

const submitForm = async () => {

  errors.value = {};
  processing.value = true;
  let response = null;

  try {
    response = await axios.post("admin/reset-password", form.value);
  } catch (error) {
    response = error.response;
    error = response.data;
    toast.error(error.message);
    errors.value = error.errors ?? {};
  }
  processing.value = false;
  if (response.status == 200) {
    router.push({ name: "admin_login", query: { password_changed: true } });
  }
};
</script>

<style scoped></style>
