<template>
    <div class= "container mt-5 mb-5 d-flex justify-content-center">
<div class= "row mt-5 mb-5">
<div class= "col-sm-6 mt-5 mb-5">
<div class="card mb-5 mt-5" style="max-width: 540px;">
  <div class="row g-0">
    <div class="col-md-4">
      <img src="/img/add-g273330623_1280.png" class="img-fluid rounded-start" alt="...">
    </div>
    <div class="col-md-8">
      <div class="card-body">
        <h5 class="card-title">Stage Manager</h5>
        <p class="card-text"></p>
        <router-link :to="{ name: 'StageManager' }" class="nav-link">
            <span class="btn custom-button-color custom-button-margin">Otvoriť</span>
        </router-link>
      </div>
    </div>
  </div>
</div>
</div>
<div class="col-sm-6 mt-5 mb-5">
  <div class="card mb-5 mt-5" style="max-width: 540px;">
    <div class="row g-0">
      <div class="col-md-4">
        <img src="/img/trash-g0d0eff27b_1280.png" class="img-fluid rounded-start" alt="...">
      </div>
      <div class="col-md-8">
        <div class="card-body">
          <h5 class="card-title">Sponsor Manager</h5>
          <p class="card-text"></p>
          <router-link :to="{ name: 'SponsorManager' }" class="nav-link">
            <span class="btn custom-button-color custom-button-margin">Otvoriť</span>
          </router-link>
        </div>
      </div>
    </div>
  </div>


</div>
</div>
</div>
<div class="container d-flex justify-content-center mt-3 mb-5">
    <button @click="" class="btn custom-button-color">Logout</button>
</div>

</template>