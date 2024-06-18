<template>
    <div>
      <Banner />
      <SpeakerBanner />
      <StageBanner />
    </div>
  </template>
  
  <script>
  import Banner from '../components/Banner.vue';
  import SpeakerBanner from '../components/SpeakerBanner.vue';
  import StageBanner from '../components/StageBanner.vue';

  
  export default {
    components: {
      Banner,
      SpeakerBanner,
      StageBanner
    },
  };
  </script>
  