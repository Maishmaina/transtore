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
              src="/assets/media/auth/agency.png"
              alt=""
            />
            <img
              class="theme-dark-show mx-auto mw-100 w-150px w-lg-300px mb-10 mb-lg-20"
              src="/assets/media/auth/agency-dark.png"
              alt=""
            />

            <h1 class="text-gray-800 fs-2qx fw-bold text-center mb-7">
              Fast, Efficient and Safe
            </h1>
            <div class="text-gray-600 fs-base text-center fw-semibold">
              In this kind of post,
              <a href="#" class="opacity-75-hover text-primary me-1">the blogger</a
              >introduces a person they’ve interviewed <br />and provides some background
              information about
              <a href="#" class="opacity-75-hover text-primary me-1">the interviewee</a
              >and their <br />work following this is a transcript of the interview.
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
                <form
                  class="form w-100"
                  novalidate="novalidate"
                  id="kt_sign_in_form"
                  data-kt-redirect-url="../../demo55/dist/index.html"
                  action="#"
                >
                  <div class="text-center mb-11">
                    <h1 class="text-dark fw-bolder mb-3">Sign In</h1>

                    <div class="text-gray-500 fw-semibold fs-6">
                      Welcome Back Customer
                    </div>
                  </div>

                  <div class="fv-row mb-8">
                    <input
                      type="text"
                      placeholder="Email"
                      name="email"
                      autocomplete="off"
                      class="form-control bg-transparent"
                    />
                  </div>
                  <div class="fv-row mb-3">
                    <input
                      type="password"
                      placeholder="Password"
                      name="password"
                      autocomplete="off"
                      class="form-control bg-transparent"
                    />
                  </div>
                  <div class="d-flex flex-stack flex-wrap gap-3 fs-base fw-semibold mb-8">
                    <div></div>
                    <a
                      href="../../demo55/dist/authentication/layouts/overlay/reset-password.html"
                      class="link-primary"
                      >Forgot Password ?</a
                    >
                  </div>
                  <div class="d-grid mb-10">
                    <button type="submit" id="kt_sign_in_submit" class="btn btn-primary">
                      <span class="indicator-label">Sign In</span>
                      <span class="indicator-progress"
                        >Please wait...
                        <span
                          class="spinner-border spinner-border-sm align-middle ms-2"
                        ></span
                      ></span>
                    </button>
                  </div>
                  <div class="text-gray-500 text-center fw-semibold fs-6">
                    don't have an account yet?
                    <a href="#" class="link-primary">Sign up</a>
                  </div>
                </form>
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
import { onMounted, onUnmounted } from "vue";

const body = document.body;

const isDarkTheme = body.getAttribute("data-bs-theme") == "dark";

onMounted(() => {
  body.setAttribute("id", "kt_body");
  body.classList.add(
    "app-blank",
    "bgi-size-cover",
    "bgi-attachment-fixed",
    "bgi-position-center",
    "bgi-no-repeat"
  );
  if (isDarkTheme) {
    body.style.backgroundImage = "url('/assets/media/auth/bg4-dark.jpg')";
  } else {
    body.style.backgroundImage = "url('/assets/media/auth/bg4.jpg')";
  }
});

onUnmounted(() => {
  body.removeAttribute("id");
  body.removeAttribute("style");
  body.classList.remove(
    "app-blank",
    "bgi-size-cover",
    "bgi-attachment-fixed",
    "bgi-position-center",
    "bgi-no-repeat"
  );
});
</script>

<style scoped></style>
