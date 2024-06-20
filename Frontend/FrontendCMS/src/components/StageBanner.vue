<template>
  <div class="stage-banner">
    <div class="stage-list">
      <ul>
        <li 
          v-for="stage in stages" 
          :key="stage.id" 
          @click="selectStage(stage)"
          :class="{ selected: selectedStage && selectedStage.id === stage.id }"
        >
          {{ stage.name }}<br>{{ stage.date }}
        </li>
      </ul>
    </div>
    <div class="stage-events" v-if="selectedStage">
      <table class="stage-table">
        <thead>
          <tr>
            <th>ČAS</th>
            <th>PREDNÁŠKA</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="event in selectedStage.events" :key="event.id">
            <td>{{ event.start_time }} - {{ event.end_time }}</td>
            <td>{{ event.name }}</td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      stages: [],
      selectedStage: null,
    };
  },
  created() {
    this.fetchStages().then(() => {
      if (this.stages.length > 0) {
        this.selectStage(this.stages[0]); 
      }
    });
  },
  methods: {
    async fetchStages() {
      try {
        const response = await fetch('./laravel/public/api/StageRead');
        const data = await response.json();
        this.stages = data.stages.map(stage => ({
          ...stage,
          events: data.events.filter(event => event.stage_id === stage.id)
        }));
      } catch (error) {
        console.error('Error fetching stages:', error);
      }
    },
    selectStage(stage) {
      this.selectedStage = stage;
    }
  }
};
</script>


<style scoped>
.stage-banner {
  display: flex;
  background-color: rgb(0, 76, 117);
  padding: 20px;
  justify-content: center;
  align-items: center;
  max-width: 1000px;
  margin-left: auto;
  margin-right: auto;
}

.stage-list {
  width: 200px;
  margin-right: 20px;
}

.stage-list ul {
  list-style-type: none;
  padding: 0;
}

.stage-list li {
  padding: 10px 15px;
  cursor: pointer;
  background-color: #004c75;
  color: white;
  margin-bottom: 5px;
  border-radius: 4px;
  transition: background-color 0.3s ease;
  font-weight: bold;
}

.stage-list li:hover {
  background-color: #006599;
}

.stage-list .selected {
  background-color: #007bff3a;
}

.stage-events {
  flex: 1;
 
}

.stage-table {
  width: 100%;
  border-collapse: collapse;
  text-align: left;
}

.stage-table th,
.stage-table td {
  padding: 12px;
  border: 1px solid #ddd;
}

.stage-table th {
  background-color: rgb(0, 76, 117);
  color: white;
  font-weight: bold;
}

.stage-table td {
  background-color: white;
}

.stage-table tr:nth-child(even) td {
  background-color: #f2f2f2;
}
</style>
