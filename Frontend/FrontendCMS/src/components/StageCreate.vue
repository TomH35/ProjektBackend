<template>
    <div class="stage-create">
      <h1>Create Stage</h1>
  
      <form @submit.prevent="createStage">
        <div>
          <label for="name">Stage Name:</label>
          <input id="name" v-model="stage.name" type="text" required>
        </div>
  
        <div>
          <label for="date">Date:</label>
          <input id="date" v-model="stage.date" type="date" required>
        </div>
  
        <div v-for="(event, index) in events" :key="index">
          <h2>Event {{ index + 1 }}</h2>
  
          <div>
            <label :for="'eventName' + index">Event Name:</label>
            <input :id="'eventName' + index" v-model="event.name" type="text" required>
          </div>
  
          <div>
            <label :for="'eventStartTime' + index">Start Time:</label>
            <input :id="'eventStartTime' + index" v-model="event.start_time" type="time" required>
          </div>
  
          <div>
            <label :for="'eventEndTime' + index">End Time:</label>
            <input :id="'eventEndTime' + index" v-model="event.end_time" type="time" required>
          </div>
  
          <div>
            <label :for="'eventSpeaker' + index">Speaker:</label>
            <input :id="'eventSpeaker' + index" v-model="event.speaker" type="text" required>
          </div>
  
          <div>
            <label :for="'eventLink' + index">Link:</label>
            <input :id="'eventLink' + index" v-model="event.link" type="url">
          </div>
  
          <div>
            <label :for="'eventDescription' + index">Description:</label>
            <textarea :id="'eventDescription' + index" v-model="event.description"></textarea>
          </div>
  
          <div>
            <label :for="'eventImage' + index">Event Image:</label>
            <input :id="'eventImage' + index" type="file" @change="handleImageChange(index, $event)">
          </div>
        </div>
  
        <button type="button" @click="addEvent">Add Event</button>
        <button type="submit">Create Stage</button>
        <button type="button" @click="removeEvent(index)">Remove Event</button>

    

      </form>
    </div>
  </template>
  
  <script>
  export default {
    data() {
      return {
        successMessage: '',
        errorMessage: '',

        stage: {
          name: '',
          date: '',
        },
        events: [
       
          {
            name: '',
            start_time: '',
            end_time: '',
            speaker: '',
            link: '',
            description: '',
            image: null,
          },
        ],
      };
    },
    methods: {

        removeEvent(index) {
      this.events.splice(index, 1);
    },
      addEvent() {
        this.events.push({
          name: '',
          start_time: '',
          end_time: '',
          speaker: '',
          link: '',
          description: '',
          image: null,
        });
      },
      handleImageChange(index, event) {
        this.events[index].image = event.target.files[0];
      },
      async createStage() {
  try {
    const response = await fetch('http://localhost/Backend/laravel/public/api/stage', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json'
      },
      body: JSON.stringify({
        stage: this.stage,
        events: this.events,
      }),
    });

    if (!response.ok) {
 
      const data = await response.json();
      this.errorMessage = data.error;

      alert(this.errorMessage);
      throw new Error(`HTTP error! status: ${response.status}`);
    } else {

      this.successMessage = 'Stage has been created successfully!';
 
      alert(this.successMessage);
  
      this.errorMessage = '';
    }
  } catch (error) {

    this.successMessage = '';
    console.error(error);
  }
},


    },
  };
  </script>
  
