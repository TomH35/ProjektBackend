<template>
    <div class="custom-container">
      <Banner />
      <SpeakerBanner />
      <StageBanner />
      <SponsorBanner />
    </div>
  </template>
  
  <script>
  import Banner from '../components/Banner.vue';
  import SpeakerBanner from '../components/SpeakerBanner.vue';
  import StageBanner from '../components/StageBanner.vue';
  import SponsorBanner from '../components/SponsorBanner.vue';

  
  export default {
    components: {
      Banner,
      SpeakerBanner,
      SponsorBanner,
      StageBanner
    },
  };
  </script>
  