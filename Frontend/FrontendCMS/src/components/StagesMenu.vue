<template>
    <div class="stages-menu">
      <h1>Stages</h1>
      <div v-for="stage in stages" :key="stage.id" class="stage-item">
        <p>{{ stage.name }}</p>
        <button @click="editStage(stage)">Edit</button>
        <button @click="deleteStage(stage)">Delete</button>
      </div>
    </div>
  </template>
  
  <script>
export default {
  data() {
    return {
      stages: [], 
    };
  },
  async created() {
    try {
      const response = await fetch('http://localhost/Backend/laravel/public/api/showStages'); 
      if (!response.ok) {
        throw new Error(`HTTP error! status: ${response.status}`);
      }
      this.stages = await response.json();
    } catch (error) {
      console.error('There was a problem with the fetch operation: ', error);
    }
  },
  methods: {
    editStage(stage) {

      this.$emit('edit', stage);
    },
    deleteStage(stage) {
   
    },
  },
};
</script>

  
  <style scoped>
  .stages-menu {
    width: 30%;
    height: 100vh;
    overflow-y: auto;
  }
  
  .stage-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 10px;
    border-bottom: 1px solid #ccc;
  }
  </style>
  