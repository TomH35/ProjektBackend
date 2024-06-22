<template>
  <div>
    <Banner />
    <SpeakerBanner />
    <StageBanner />
    <AboutUSBanner />
    <SponsorBanner />
    <GalleryBanner/>
  </div>
</template>

<script>
import Banner from '../components/Banner.vue';
import SpeakerBanner from '../components/SpeakerBanner.vue';
import StageBanner from '../components/StageBanner.vue';
import SponsorBanner from '../components/SponsorBanner.vue';
import AboutUSBanner from '../components/AboutUSBanner.vue';
import GalleryBanner from '../components/GalleryBanner.vue';



export default {
  components: {
    Banner,
    SpeakerBanner,
    SponsorBanner,
    AboutUSBanner,
    StageBanner,
    GalleryBanner,
  },
};
</script>
