<template>
  <form class="form w-100 " novalidate="novalidate">
    <div class="text-center mb-10">
      <img alt="Logo" class="mh-125px" src="/assets/media/auth/please-verify-your-email.png" />
    </div>
    <div class="text-center mb-10">
      <h1 class="text-dark mb-3">Digit Verification</h1>
      <div class="text-muted fw-semibold fs-5 mb-5">Enter 4-digit verification code we sent to</div>
      <div class="fw-bold text-dark fs-3">tran....gmail.com</div>
    </div>
    <div class="mb-10">
      <div class="fw-bold text-start text-dark fs-6 mb-1 ms-1">
        This code will expire in 1:58
      </div>
      <div class="d-flex flex-wrap flex-stack">
        <input
          type="text"
          name="code_1"
          maxlength="1"
          class="form-control bg-transparent h-60px w-60px fs-2qx text-center mx-1 my-2"
        />
        <input
          type="text"
          name="code_2"
          maxlength="1"
          class="form-control bg-transparent h-60px w-60px fs-2qx text-center mx-1 my-2"
        />
        <input
          type="text"
          name="code_3"
          maxlength="1"
          class="form-control bg-transparent h-60px w-60px fs-2qx text-center mx-1 my-2"
        />
        <input
          type="text"
          name="code_4"
          maxlength="1"
          class="form-control bg-transparent h-60px w-60px fs-2qx text-center mx-1 my-2"
        />
      </div>
    </div>
    <div class="d-flex flex-center">
      <button
        type="button"
        id="kt_sing_in_two_factor_submit"
        class="btn btn-lg btn-primary fw-bold"
      >
        <span class="indicator-label">Submit</span>
        <span class="indicator-progress">
          Please wait...
          <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
        </span>
      </button>
    </div>
    <!--end::Submit-->
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
  email: ""
});

const submitForm = async () => {
  //   errors.value = {};
  //   processing.value = true;
  //   let response = null;
  //   try {
  //     response = await axios.post("forgot-password", form.value);
  //   } catch (error) {
  //     response = error.response;
  //     error = response.data;
  //     toast.error(error.message);
  //     errors.value = error.errors ?? {};
  //   }
  //   processing.value = false;
  //   if (response.status == 200) {
  //     router.push({ name: "reset-password" });
  //   }
};
</script>

<style scoped></style>
