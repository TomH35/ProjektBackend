<template>
  <div class="container custom-container mx-auto" style="width: 80%;">
    <div class="row">
      <div class="col-sm-4">
        <h1 class="text-center">Create Stage</h1>
        <StageCreate @stageCreated="refreshStages" />
      </div>

      <div class="col-sm-4">
        <h1 class="text-center mb-4">Stages</h1>
        <StagesMenu ref="stagesMenu" @edit="editStage" />
      </div>

      <div class="col-sm-4">
        <h1 class="text-center">Edit Stage</h1>
        <StageEdit v-if="isEditing" :stageToEdit="selectedStage" @stageUpdated="handleStageUpdated" />
      </div>
    </div>
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

    handleStageUpdated() {

    this.refreshStages();
  },
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
