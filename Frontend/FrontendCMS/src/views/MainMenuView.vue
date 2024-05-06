<template>
  <div class="container custom-container">
    <div class="row">
      <div class="col-sm-6">
        <!-- Card 1 -->
        <div class="card mb-5">
          <div class="row g-0">
            <div class="col-md-4">
              <img src="/img/add-g273330623_1280.png" class="img-fluid rounded-start" alt="...">
            </div>
            <div class="col-md-8">
              <div class="card-body">
                <h5 class="card-title">Stage Manager</h5>
                <router-link :to="{ name: 'StageManager' }" class="nav-link">
                  <span class="btn custom-button-color custom-button-margin">Otvoriť</span>
                </router-link>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-sm-6">
        <!-- Card 2 -->
        <div class="card mb-5">
          <div class="row g-0">
            <div class="col-md-4">
              <img src="/img/trash-g0d0eff27b_1280.png" class="img-fluid rounded-start" alt="...">
            </div>
            <div class="col-md-8">
              <div class="card-body">
                <h5 class="card-title">Sponsor Manager</h5>
                <router-link :to="{ name: 'SponsorManager' }" class="nav-link">
                  <span class="btn custom-button-color custom-button-margin">Otvoriť</span>
                </router-link>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-sm-6">
        <!-- Card 3 -->
        <div class="card mb-5">
          <div class="row g-0">
            <div class="col-md-4">
              <img src="/img/add-g273330623_1280.png" class="img-fluid rounded-start" alt="...">
            </div>
            <div class="col-md-8">
              <div class="card-body">
                <h5 class="card-title">Speaker Manager</h5>
                <router-link :to="{ name: 'SpeakerManager' }" class="nav-link">
                  <span class="btn custom-button-color custom-button-margin">Otvoriť</span>
                </router-link>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-sm-6">
        <!-- Card 4 -->
        <div class="card mb-5">
          <div class="row g-0">
            <div class="col-md-4">
              <img src="/img/trash-g0d0eff27b_1280.png" class="img-fluid rounded-start" alt="...">
            </div>
            <div class="col-md-8">
              <div class="card-body">
                <h5 class="card-title">Sponsor Manager</h5>
                <router-link :to="{ name: 'SponsorManager' }" class="nav-link">
                  <span class="btn custom-button-color custom-button-margin">Otvoriť</span>
                </router-link>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="d-flex justify-content-center mt-3 mb-5">
      <button @click="" class="btn custom-button-color">Logout</button>
    </div>
  </div>
</template>
