<template>
  <div class="app-content flex-column-fluid">
    <div class="app-container container-fluid">
      <div class="card">
        <div class="card-body">
          <div class="row justify-content-center">
            <div class="col-6">
              <div class="card-px pt-15 pb-15">
                <div class="text-center">
                  <p class="fw-bold">{{ returnGreetings() }} , {{ user ? user.user.full_name:'' }}</p>
                  <h2 class="fs-2x text-gray-400 mb-0">Let's help you get started</h2>
                  <p class="text-gray-400 fs-4 fw-semibold py-7">What would you like to do today?</p>
                </div>
                <hr />
                <router-link to="rent-facility" class="mb-5 cursor-pointer">
                  <span class="d-flex align-items-left me-2">
                    <span class="d-flex flex-column">
                      <h1 class="fw-bold text-primary">
                        <i class="ki-outline ki-lock-3 text-black bg-warning fs-2x rounded-circle"></i>
                        <span style="margin-left: 5px;">Rent A Storage Unit</span>
                      </h1>
                      <span
                        class="fs-6 fw-semibold text-muted"
                      >Search and rent storage facilities and units, view and manage your storage rentals, request a pick-up/drop-off for your storage items.</span>
                    </span>
                    <span class="pt-15">
                      <i class="ki-duotone ki-black-right fs-2x"></i>
                    </span>
                  </span>
                </router-link>
                <hr />
                <router-link to="/" class="mb-5 cursor-pointer border-top pt-5">
                  <span class="d-flex align-items-left me-2">
                    <span class="d-flex flex-column">
                      <h1 class="fw-bold text-primary">
                        <i class="ki-outline ki-scooter text-black bg-warning fs-2x rounded-circle"></i>
                        <span style="margin-left: 5px;">Transport</span>
                      </h1>
                      <h3 class="fw-bold">Request transport services</h3>
                      <span
                        class="fs-6 fw-semibold text-muted"
                      >Request transport services for your personal or bulk items to and from a destination.</span>
                    </span>
                    <span class="pt-15">
                      <i class="ki-duotone ki-black-right fs-2x"></i>
                    </span>
                  </span>
                </router-link>
                <hr />
                <router-link to="/" class="mb-5 cursor-pointer border-top pt-5">
                  <span class="d-flex align-items-left me-2">
                    <span class="d-flex flex-column">
                      <h3 class="text-muted">
                        Manage pick-up/drop-off requests
                        <i class="ki-outline ki-lock-3 fs-2x rounded-circle"></i>
                      </h3>
                      <span
                        class="fs-6 fw-semibold text-muted"
                      >View and manage shipments, billing history and payments.</span>
                    </span>
                    <span class="pt-15" style="margin-left: 92px;">
                      <i class="ki-duotone ki-black-right fs-2x"></i>
                    </span>
                  </span>
                </router-link>
              </div>
            </div>
          </div>
          <div></div>
        </div>
      </div>
    </div>
  </div>
</template>
<script setup>


const returnGreetings = () => {
  const date = new Date();
  const hour = date.getHours();

  let greeting;

  if (hour >= 5 && hour < 12) {
    greeting = "Good morning!";
  } else if (hour >= 12 && hour < 18) {
    greeting = "Good afternoon!";
  } else if (hour >= 18 && hour < 22) {
    greeting = "Good evening!";
  } else {
    greeting = "Good night!";
  }

  return greeting;
};
</script>
<style scoped>
</style>
