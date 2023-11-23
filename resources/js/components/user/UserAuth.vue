<template>
  <div
    id="kt_body"
    class="app-blank bgi-size-cover bgi-attachment-fixed bgi-position-center"
  >
    <div class="d-flex flex-column flex-root" id="kt_app_root">
      <div class="d-flex flex-column flex-lg-row flex-column-fluid">
        <div class="d-flex flex-lg-row-fluid">
          <div class="d-flex flex-column flex-center pb-0 pb-lg-10 p-10 w-100">
            <img
              class="theme-light-show mx-auto mw-100 w-150px w-lg-300px mb-10 mb-lg-20"
              :src="sideImage"
              alt=""
            />
            <img
              class="theme-dark-show mx-auto mw-100 w-150px w-lg-300px mb-10 mb-lg-20"
              :src="sideImage"
              alt=""
            />

            <h1 class="text-gray-800 fs-2qx fw-bold text-center mb-7">
              Fast, Efficient and Safe
            </h1>
            <div class="text-gray-600 fs-base text-center fw-semibold">
              In this kind of System,
              <a href="#" class="opacity-75-hover text-primary me-1">the customer</a
              >search facility and store<br />and get some background information about
              <a href="#" class="opacity-75-hover text-primary me-1">the Units</a>and
              their <br />availability and request book if available.
            </div>
          </div>
        </div>
        <div
          class="d-flex flex-column-fluid flex-lg-row-auto justify-content-center justify-content-lg-end p-12"
        >
          <div class="bg-body d-flex flex-column flex-center rounded-4 w-md-600px p-10">
            <div
              class="d-flex flex-center flex-column align-items-stretch h-lg-100 w-md-400px"
            >
              <div
                class="d-flex flex-center flex-column flex-column-fluid pb-15 pb-lg-20"
              >
                <router-view></router-view>
              </div>
              <div class="d-flex flex-stack">
                <div class="me-10"></div>
                <div class="d-flex fw-semibold text-primary fs-base gap-5">
                  <a href="#">Terms</a>
                  <a href="#">Plans</a>
                  <a href="#">Contact Us</a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script setup>
import { onMounted, onUnmounted, ref } from "vue";

const sideImage = ref(null);
const body = document.body;

const isDarkTheme = body.getAttribute("data-bs-theme") == "dark";

onMounted(() => {
  //   body.setAttribute("id", "kt_body");
  //   body.classList.add(
  //     "app-blank",
  //     "bgi-size-cover",
  //     "bgi-attachment-fixed",
  //     "bgi-position-center",
  //     "bgi-no-repeat"
  //   );
  if (isDarkTheme) {
    sideImage.value = "/assets/media/auth/agency.png";
  } else {
    sideImage.value = "/assets/media/auth/agency-dark.png";
  }
});

onUnmounted(() => {
  //   body.removeAttribute("id");
  //   body.removeAttribute("style");
  //   body.classList.remove(
  //     "app-blank",
  //     "bgi-size-cover",
  //     "bgi-attachment-fixed",
  //     "bgi-position-center",
  //     "bgi-no-repeat"
  //   );
});
</script>

<style scoped></style>
