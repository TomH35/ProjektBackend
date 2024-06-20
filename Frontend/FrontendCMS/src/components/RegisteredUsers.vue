<template>
    <div class="stage-banner">
      <table class="stage-table">
        <thead>
          <tr>
            <th>STAGE</th>
            <th>ČAS</th>
            <th>PREDNÁŠKA</th>
            <th>AKCIE</th>
          </tr>
        </thead>
        <tbody>
          <template v-for="stage in stages" :key="stage.id">
            <template v-for="(event, index) in stage.events" :key="event.id">
              <tr>
                <td v-if="index === 0" :rowspan="stage.events.length">{{ stage.name }}<br>{{ stage.date }}</td>
                <td>{{ event.start_time }} - {{ event.end_time }}</td>
                <td>{{ event.name }}</td>
                <td>
                  <button @click="viewRegisteredUsers(event.id)">Show Users</button>
                </td>
              </tr>
            </template>
          </template>
        </tbody>
      </table>
  
      <div v-if="registeredUsers.length" class="registered-users">
        <h3>Registered Users for Event</h3>
        <ul>
          <li v-for="user in registeredUsers" :key="user.email">
            {{ user.email }}
          </li>
        </ul>
      </div>
    </div>
  </template>
  
  <script>
  export default {
    data() {
      return {
        stages: [],
        registeredUsers: [],
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
      },
      async viewRegisteredUsers(eventId) {
        try {
          const response = await fetch(`http://localhost/laravel/public/api/registrations/${eventId}`);
          if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
          }
          const users = await response.json();
          this.registeredUsers = users;
        } catch (error) {
          console.error('Error fetching registered users:', error);
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
  
  .registered-users {
    margin-top: 20px;
  }
  
  .registered-users ul {
    list-style-type: none;
    padding: 0;
  }
  
  .registered-users li {
    padding: 8px;
    background-color: #f9f9f9;
    margin-bottom: 8px;
    border: 1px solid #ddd;
    border-radius: 4px;
  }
  </style>
  