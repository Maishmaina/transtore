<template>
  <form class="form w-100" @submit.prevent="submitForm">
    <div class="text-center mb-8">
      <h1 class="text-dark fw-bolder mb-2">Sign Up</h1>
      <div class="text-gray-500 fw-semibold fs-6">Create Account with Us</div>
    </div>
    <div class="fv-row mb-8">
      <label class="form-label">Your First Name</label>
      <input
        type="text"
        placeholder="First Name"
        name="first_name"
        autocomplete="off"
        class="form-control bg-transparent"
        v-model="form.first_name"
        :class="{'is-invalid': errors.first_name}"
      />
      <div class="invalid-feedback" v-if="errors.first_name">{{ errors.first_name[0] }}</div>
    </div>
    <div class="fv-row mb-8">
      <label class="form-label" for="last_name">Your Last Name</label>
      <input
        type="text"
        placeholder="Last Name"
        name="last_name"
        autocomplete="off"
        class="form-control bg-transparent"
        v-model="form.last_name"
        :class="{'is-invalid':errors.last_name}"
      />
      <div class="invalid-feedback" v-if="errors.last_name">{{ errors.last_name[0] }}</div>
    </div>
    <div class="fv-row mb-8">
      <label for="email" class="form-label">Your Email</label>
      <input
        type="text"
        placeholder="Email"
        name="email"
        autocomplete="off"
        class="form-control bg-transparent"
        v-model="form.email"
        :class="{'is-invalid':errors.email}"
      />
      <div class="invalid-feedback" v-if="errors.email">{{ errors.email[0] }}</div>
    </div>
    <div class="fv-row mb-8" data-kt-password-meter="true">
      <div class="mb-1">
        <div class="position-relative mb-3">
          <label for="password" class="form-label">Your Password</label>
          <PasswordInput :errors="errors" @input-changed="form.password = $event" />
        </div>
      </div>
    </div>

    <div class="fv-row mb-8">
      <label class="form-check form-check-inline">
        <input class="form-check-input" type="checkbox" name="toc" value="1" />
        <span class="form-check-label fw-semibold text-gray-700 fs-base ms-1">
          I Accept the
          <a href="#" class="ms-1 link-primary">Terms</a>
        </span>
      </label>
    </div>
    <div class="d-grid mb-10">
      <button type="submit" class="btn btn-primary" @submit.prevent="submitForm()">
        <span class="indicator-label" v-if="!processing">Sign up</span>
        <span v-else>
          Please wait...
          <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
        </span>
      </button>
    </div>
    <div class="text-gray-500 text-center fw-semibold fs-6">
      Already have an Account?
      <router-link :to="{name:'login'}" class="link-primary fw-semibold">Sign in</router-link>
    </div>
  </form>
</template>
<script setup>
import { ref } from "vue";
import { useRouter } from "vue-router";
import { toast } from "vue3-toastify";
import PasswordInput from "@/components/PasswordInput.vue";
import { useUserStore } from "@/stores/userStore";

let { registerUser } = useUserStore();

const router = useRouter();

const errors = ref({});
const processing = ref(false);

const form = ref({
  first_name: "",
  last_name: "",
  email: "",
  password: ""
});

const submitForm = async () => {
  errors.value = {};
  processing.value = true;
  let response = await registerUser(form.value);
    processing.value = false;
    console.log(response);
  if (response.status == 201) {
    router.push({ name: "verify-user" });
  } else {
    let error = response.data;
    toast.error(error.message);
    errors.value = error.errors ?? {};
  }

};
</script>

<style scoped></style>
