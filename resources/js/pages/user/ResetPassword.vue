<template>
  <form class="form w-100" @submit.prevent="submitForm">
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
        v-model="form.reset_code"
        :class="{'is-invalid': errors.reset_code}"
      />
        <div class="invalid-feedback" v-if="errors.reset_code">{{ errors.reset_code[0] }}</div>
    </div>
    <div class="fv-row mb-8" data-kt-password-meter="true">
      <PasswordInput :errors="errors" @input-changed="form.password = $event" />
    </div>
    <div class="d-grid mb-10">
      <button
      @submit.prevent="submitForm"
      type="submit"
      id="kt_sign_in_submit"
      class="btn btn-primary">
        <span v-if="!processing" class="indicator-label">Sign In</span>
        <span v-else>
          Please wait...
          <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
        </span>
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
import { toast } from "vue3-toastify";
import PasswordInput from "@/components/PasswordInput.vue";

const route = useRoute();
const router = useRouter();

const form = ref({
  reset_code: "",
  password: ""
});
const errors = ref({});

const processing = ref(false);

const submitForm = async () => {
  errors.value = {};
  processing.value = true;
  let response = null;

  try {
    response = await axios.post("reset-password", form.value);
  } catch (error) {
    response = error.response;
    error = response.data;
    toast.error(error.message);
    errors.value = error.errors ?? {};
  }
  processing.value = false;
  if (response.status == 200) {
    router.push({ name: "login", query: { password_changed: true } });
  }

};
</script>
<style scoped></style>
