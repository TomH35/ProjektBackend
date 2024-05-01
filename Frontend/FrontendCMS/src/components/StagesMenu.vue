<template>
  <div class="stages-menu">
    <div v-for="stage in stages" :key="stage.id" class="card mb-3">
      <div class="card-body w-50">
        <h5 class="card-title">{{ stage.name }}</h5>
        <div class="d-flex justify-content-start">
          <button @click="editStage(stage)" class="btn btn-primary me-2">Edit</button>
          <button @click="deleteStage(stage)" class="btn btn-danger">Delete</button>
        </div>
      </div>
    </div>
  </div>
</template>


  
<script>
export default {
  data() {
    return {
      stages: [], 
      events: [],
    };
  },
  created() {
    this.fetchStagesAndEvents();
    
  },
  methods: {

    refreshStages() {
      this.fetchStagesAndEvents();
    },
    
    async fetchStagesAndEvents() {
  try {
    const response = await fetch('./laravel/public/api/StageRead'); 
    if (!response.ok) {
      throw new Error(`HTTP error! status: ${response.status}`);
    }
    const data = await response.json();
    this.stages = data.stages;
    this.events = data.events;
  } catch (error) {
    console.error('There was a problem with the fetch operation: ', error);
  }
},

    
editStage(stage) {
  const stageEvents = this.events.filter(event => event.stage_id === stage.id);
  this.$emit('edit', { stage, events: stageEvents });
},


async deleteStage(stage) {
  try {

    if (!window.confirm('Are you sure you want to delete this Stage? This action cannot be undone.')) {
      return;
    }

    const response = await fetch(`./laravel/public/api/StageDelete/${stage.id}`, {
      method: 'DELETE',
    });
    if (!response.ok) {
      throw new Error(`HTTP error! status: ${response.status}`);
    }

    this.stages = this.stages.filter(s => s.id !== stage.id);
  } catch (error) {
    console.error('There was a problem with the fetch operation: ', error);
  } 
}

  },
};
</script>

  