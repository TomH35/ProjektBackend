<template>
  <div class="stage-create">
    <div class="card">
      <div class="card-body">

        <form @submit.prevent="createStage" class="form">
          <div class="mb-3">
            <label for="name" class="form-label">Stage Name:</label>
            <input id="name" v-model="stage.name" type="text" class="form-control" required>
          </div>

          <div class="mb-3">
            <label for="date" class="form-label">Date:</label>
            <input id="date" v-model="stage.date" type="date" class="form-control" required>
          </div>

          <div v-for="(event, index) in events" :key="index" class="event">
            <h2 class="mt-4">Event {{ index + 1 }}</h2>

            <div class="mb-3">
              <label :for="'eventName' + index" class="form-label">Event Name:</label>
              <input :id="'eventName' + index" v-model="event.name" type="text" class="form-control" required>
            </div>

            
            <div class="mb-3">
  <label :for="'eventStartTime' + index" class="form-label">Start Time:</label>
  <input :id="'eventStartTime' + index" v-model="event.start_time" type="time" class="form-control" required>
</div>

<div class="mb-3">
  <label :for="'eventEndTime' + index" class="form-label">End Time:</label>
  <input :id="'eventEndTime' + index" v-model="event.end_time" type="time" class="form-control" required>
</div>

<div class="mb-3">
  <label :for="'eventSpeaker' + index" class="form-label">Speaker:</label>
  <input :id="'eventSpeaker' + index" v-model="event.speaker" type="text" class="form-control" required>
</div>

<div class="mb-3">
  <label :for="'eventLink' + index" class="form-label">Link:</label>
  <input :id="'eventLink' + index" v-model="event.link" type="url" class="form-control">
</div>

<div class="mb-3">
  <label :for="'eventDescription' + index" class="form-label">Description:</label>
  <textarea :id="'eventDescription' + index" v-model="event.description" class="form-control" required></textarea>
</div>


            <div class="mb-3">
              <label :for="'eventImage' + index" class="form-label">Event Image:</label>
              <input :id="'eventImage' + index" type="file" class="form-control" @change="handleImageChange(index, $event)">
              <img :src="events[index].previewImage" v-if="events[index].previewImage" alt="Image preview" class="img-thumbnail mt-2"/>
            </div>
          </div>

          <button type="button" @click="addEvent" class="btn btn-primary mt-3">Add Event</button>
          <button type="submit" class="btn btn-success mt-3">Create Stage</button>
          <button type="button" @click="removeEvent(index)" class="btn btn-danger mt-3">Remove Event</button>
        </form>
      </div>
    </div>
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

    let reader = new FileReader();
    reader.onload = (e) => {
      this.events[index].previewImage = e.target.result;
    };
    reader.readAsDataURL(this.events[index].image);
  },
  async createStage() {
  try {
    const formData = new FormData();


    formData.append('stage', JSON.stringify(this.stage));


    this.events.forEach((event, index) => {
      for (const key in event) {
        if (event.hasOwnProperty(key)) {
          if (key === 'image' && event[key]) {
            formData.append(`events[${index}][${key}]`, event[key]);
          } else {
            formData.append(`events[${index}][${key}]`, event[key]);
          }
        }
      }
    });

    const response = await fetch('./laravel/public/api/StageCreate', {
      method: 'POST',
      body: formData,
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
        this.$emit('stageCreated');
        
      }
    } catch (error) {

      this.successMessage = '';
      console.error(error);
    }
  },
},

  };
  </script>

  