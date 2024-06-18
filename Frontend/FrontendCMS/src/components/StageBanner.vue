<template>
    <div class="stage-banner">
      <table class="stage-table">
        <thead>
          <tr>
            <th>STAGE</th>
            <th>ČAS</th>
            <th>PREDNÁŠKA</th>
          </tr>
        </thead>
        <tbody>
          <template v-for="stage in stages" :key="stage.id">
            <template v-for="(event, index) in stage.events" :key="event.id">
              <tr>
                <td v-if="index === 0" :rowspan="stage.events.length">{{ stage.name }}<br>{{ stage.date }}</td>
                <td>{{ event.start_time }} - {{ event.end_time }}</td>
                <td>{{ event.name }}</td>
              </tr>
            </template>
          </template>
        </tbody>
      </table>
    </div>
  </template>
  
  <script>
  export default {
    data() {
      return {
        stages: [],
      };
    },
    created() {
      this.fetchStages();
    },
    methods: {
      async fetchStages() {
        try {
          const response = await fetch('http://localhost/laravel/public/api/StageRead');
          const data = await response.json();
          this.stages = data.stages.map(stage => ({
            ...stage,
            events: data.events.filter(event => event.stage_id === stage.id)
          }));
        } catch (error) {
          console.error('Error fetching stages:', error);
        }
      }
    }
  };
  </script>
  
  <style scoped>
  .stage-banner {
    width: 100%;
    overflow-x: auto;
    background-color: #f4f4f4;
    padding: 20px;
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
    background-color: #004c75;
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
  