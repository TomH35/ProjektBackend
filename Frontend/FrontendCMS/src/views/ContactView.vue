<template>
    <div>
      <!-- Map and Contact Information Section -->
      <section class="contact-section">
        <div class="container">
          <div class="row">
            <div class="col-lg-12">
              <div id="map">
                <iframe
                  src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2653.037526220508!2d18.095816621630984!3d48.32135972810276!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x476b3f15415e707f%3A0xf78375abe8093dab!2s%C5%A0tudentsk%C3%A9%20centrum%20UKF%20v%20Nitre!5e0!3m2!1ssk!2ssk!4v1719068508358!5m2!1ssk!2ssk"
                  width="100%"
                  height="450px"
                  frameborder="0"
                  style="border:0; border-radius: 5px; position: relative; z-index: 2;"
                  allowfullscreen
                ></iframe>
              </div>
            </div>
            <div class="col-lg-12">
              <div class="contact-info">
                <h4>KONTAKT</h4>
                <div class="contact-item">
                  <h5>Dominik Halvoník</h5>
                  <p>Organizátor</p>
                  <p><a href="mailto:dhalvonik@ukf.sk">dhalvonik@ukf.sk</a></p>
                  <p><a href="tel:+421902170744">+421 902 170 744</a></p>
                </div>
                <div class="contact-item">
                  <h5>Jaroslav Reichel</h5>
                  <p>Organizátor</p>
                  <p><a href="mailto:jreichel@ukf.sk">jreichel@ukf.sk</a></p>
                  <p><a href="tel:+421904687757">+421 904 687 757</a></p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>
    </div>
  </template>
  
  <script setup>
  </script>
  
  <style scoped>
  .contact-section {
    padding: 40px 0;
  }
  
  #map {
    margin-bottom: 20px;
  }
  
  .contact-info {
    background-color: #f9f9f9;
    padding: 20px;
    border-radius: 5px;
  }
  
  .contact-info h4 {
    margin-bottom: 20px;
    color: #333;
  }
  
  .contact-item {
    margin-bottom: 20px;
  }
  
  .contact-item img {
    width: 50px;
    height: 50px;
    border-radius: 50%;
    margin-right: 10px;
  }
  
  .contact-item h5 {
    margin: 0 0 5px;
  }
  
  .contact-item p {
    margin: 0;
  }
  
  .contact-item a {
    color: #007bff;
    text-decoration: none;
  }
  
  .contact-item a:hover {
    text-decoration: underline;
  }
  </style>
  