<template>
  <div class="container">
    <StageCreate @stageCreated="refreshStages" />
    <StagesMenu ref="stagesMenu" @edit="editStage" />
    <StageEdit v-if="isEditing" :stageToEdit="selectedStage" @stageUpdated="handleStageUpdated" />


  </div>
</template>

<script>
import StageCreate from '../components/StageCreate.vue'
import StagesMenu from '../components/StagesMenu.vue'
import StageEdit from '../components/StageEdit.vue'

export default {
  components: {
    StageCreate,
    StagesMenu,
    StageEdit
  },

  data() {
    return {
      showStagesMenu: true,
      selectedStage: null,
      isEditing: false
     
    };
  },
  methods: {
    editStage(stage) {
    if (this.isEditing && this.selectedStage === stage) {
      this.isEditing = false; 
    } else {
      this.selectedStage = stage;
      this.isEditing = true;
    }
  },



    refreshStages() {
      this.$refs.stagesMenu.fetchStagesAndEvents();
    },
  }
}
</script>

<style scoped>
.container {
  display: flex;
  align-items: flex-start;
  gap: 20px;
}
</style>
