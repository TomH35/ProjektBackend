<template>
  <div class="container mt-5">
    <form @submit.prevent="register">
      <div v-for="(events, timeWindow) in groupedEvents" :key="timeWindow" class="mb-3">
        <label :for="timeWindow" class="form-label">{{ timeWindow }}:</label>
        <select v-model="form.registrations[timeWindow]" class="form-select" required>
          <option :value="null">Select an event</option>
          <option v-for="event in events" :key="event.id" :value="event.id">{{ event.name }}</option>
        </select>
      </div>
      <div class="mb-3">
        <label for="email" class="form-label">Email:</label>
        <input type="email" v-model="form.email" class="form-control" required />
      </div>
      <button type="submit" class="btn btn-primary">Register</button>
      <p v-if="errorMessage" class="text-danger mt-3">{{ errorMessage }}</p>
    </form>
  </div>
</template>

<script>
export default {
  data() {
    return {
      form: {
        registrations: {},
        email: '',
      },
      groupedEvents: {},
      errorMessage: '',
    };
  },
  created() {
    this.fetchEventsGroupedByTime();
  },
  methods: {
    async fetchEventsGroupedByTime() {
      try {
        const response = await fetch('./laravel/public/api/EventsGroupedByTime');
        const data = await response.json();
        this.groupedEvents = data;
      } catch (error) {
        console.error('Error fetching events:', error);
      }
    },
    async register() {
      try {
        this.errorMessage = '';
        const registrations = Object.entries(this.form.registrations)
          .filter(([timeWindow, eventId]) => eventId)
          .map(([timeWindow, eventId]) => ({ event_id: eventId }));

        const response = await fetch('./laravel/public/api/register', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
          },
          body: JSON.stringify({
            registrations,
            email: this.form.email,
          }),
        });

        if (response.ok) {
          alert('Registrations successful');
          this.form.registrations = {};
          this.form.email = '';
        } else {
          const data = await response.json();
          this.errorMessage = data.error || 'Registration failed';
        }
      } catch (error) {
        console.error('Error registering:', error);
        this.errorMessage = 'Registration failed';
      }
    },
  },
};
</script>

<style>
.container {
  max-width: 600px;
}
.error-message {
  color: red;
  font-weight: bold;
}
</style>
