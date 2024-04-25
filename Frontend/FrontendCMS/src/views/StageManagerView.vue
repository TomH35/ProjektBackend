<template>
  <div class="container">
    <StageCreate />
    <StagesMenu @edit="editStage" />
  </div>
</template>

<script>
import StageCreate from '../components/StageCreate.vue'
import StagesMenu from '../components/StagesMenu.vue'

export default {
  components: {
    StageCreate,
    StagesMenu
  },
  methods: {
    editStage(stage) {
 
    }
  }
}
</script>

<style scoped>
.container {
  display: flex;
  justify-content: space-around;
  align-items: flex-start;
}
</style>
