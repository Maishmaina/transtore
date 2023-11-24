<template>
  <form class="form w-100"
   id="kt_sign_in_form"
   @submit.prevent="submitForm"
   >
    <div class="text-center mb-11">
      <h1 class="text-dark fw-bolder mb-3">Sign In</h1>

      <div class="text-gray-500 fw-semibold fs-6">Welcome Back Customer</div>
    </div>

    <div class="fv-row mb-8">
      <input
        type="text"
        placeholder="Email"
        name="email"
        autocomplete="off"
        class="form-control bg-transparent"
        v-model="form.email"
        :class="{'is-invalid': errors.email}"
      />
       <div class="invalid-feedback" v-if="errors.email">{{ errors.email[0] }}</div>

    </div>
    <div class="fv-row mb-3">
      <PasswordInput :errors="errors" @input-changed="form.password = $event" />
    </div>
    <div class="d-flex flex-stack flex-wrap gap-3 fs-base fw-semibold mb-8">
      <div></div>
      <router-link
      :to="{name:'forgot-password'}"
        class="link-primary"
        >Forgot Password ?</router-link
      >
    </div>
    <div class="d-grid mb-10">
      <button
      type="submit"
      class="btn btn-primary"
      @submit.prevent="submitForm"
      >
        <span v-if="!processing" class="indicator-label">Sign In</span>
        <span
        v-else
          >Please wait...
          <span class="spinner-border spinner-border-sm align-middle ms-2"></span
        ></span>
      </button>
    </div>
    <div class="text-gray-500 text-center fw-semibold fs-6">
      don't have an account yet?
      <router-link :to="{name:'register'}" class="link-primary">Sign up</router-link>
    </div>
  </form>
</template>

<script setup>
import { ref, watch } from "vue";
import { useRoute, useRouter } from "vue-router";
import { useUserStore } from "@/stores/userStore";
import { toast } from "vue3-toastify";
import PasswordInput from "@/components/PasswordInput.vue";


const route = useRoute();
const router = useRouter();
let { loginUser } = useUserStore();

const form = ref({
  email: "",
  password: "",
});

const errors = ref({});

const processing = ref(false);

const submitForm = async () => {
  errors.value = {};

  processing.value = true;

  let response = await loginUser(form.value);

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
