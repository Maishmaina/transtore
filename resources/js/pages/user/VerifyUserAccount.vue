<template>
  <form class="form w-100" @submit.prevent="submitForm">
    <div class="text-center mb-10">
      <img alt="Logo" class="mh-125px" src="/assets/media/auth/please-verify-your-email.png" />
    </div>
    <div class="text-center mb-10">
      <h1 class="text-dark mb-3">Digit Verification</h1>
      <div class="text-muted fw-semibold fs-5 mb-5">Enter 4-digit verification code we sent to</div>
      <div class="fw-bold text-dark fs-3">{{ returnObfsEmail(user_info) }}</div>
    </div>
    <div class="mb-10">
      <div
        class="fw-bold text-start text-dark fs-6 mb-1 ms-1"
      >This code will expire in {{ minutes }}:{{ seconds }}</div>
      <div class="d-flex flex-wrap flex-stack">
        <input
          type="text"
          name="code_1"
          maxlength="1"
          class="form-control bg-transparent h-60px w-60px fs-2qx text-center mx-1 my-2"
          v-model="form.one"
        />
        <input
          type="text"
          name="code_2"
          maxlength="1"
          class="form-control bg-transparent h-60px w-60px fs-2qx text-center mx-1 my-2"
          v-model="form.two"
        />
        <input
          type="text"
          name="code_3"
          maxlength="1"
          class="form-control bg-transparent h-60px w-60px fs-2qx text-center mx-1 my-2"
          v-model="form.three"
        />
        <input
          type="text"
          name="code_4"
          maxlength="1"
          class="form-control bg-transparent h-60px w-60px fs-2qx text-center mx-1 my-2"
          v-model="form.four"
        />
      </div>
    </div>
    <div class="d-flex flex-center">
      <button
        type="submit"
        @submit.prevent="submitForm"
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
  </form>
</template>

<script setup>
import { ref, onMounted } from "vue";
import { useRouter } from "vue-router";
import { toast } from "vue3-toastify";
import { useUserStore } from "@/stores/userStore";

let { user } = useUserStore();

const router = useRouter();

const user_info = ref(null);

const errors = ref({});
const processing = ref(false);

onMounted(() => {
  if (user) {
    user_info.value = user;
  } else {
    router.push({ name: "register" });
  }
});

const returnObfsEmail = email => {
  let obs_email = null;

  if (email) {
    let email_item = email.email.split("@");
    obs_email = email_item[0].substr(0, 3) + "...@" + email_item[1];
  }
  return obs_email;
};

let minutes = ref(5);
let seconds = ref(0);

let countdown = setInterval(function() {
  if (seconds.value === 0) {
    if (minutes.value === 0) {
      clearInterval(countdown);
      minute.value = "Resend";
      seconds.value = "";
      return;
    }

    minutes.value--;
    seconds.value = 59;
  } else {
    seconds.value--;
  }
}, 1000);

const form = ref({
  one: "",
  two: "",
  three: "",
  four: ""
});

const submitForm = async () => {
  //check if empty
  if (form.value.one && form.value.two && form.value.three && form.value.four) {
      let verification_code = { 'verification_code': form.value.one + form.value.two + form.value.three + form.value.four };
    processing.value = true;

    let response = null;
    try {
        response = await axios.post("verify-account", verification_code);
      router.push({ name: "login" });
    } catch (error) {
      response = error.response;
      error = response.data;
      toast.error(error.message);
    }
      console.log(response);
    processing.value = false;
  } else {
    toast.error("Invalid Verification Number");
  }
};
</script>
<style scoped></style>
