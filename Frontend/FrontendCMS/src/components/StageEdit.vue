<template>
    <div v-if="stageToEdit.stage" class="stage-create">
      <h1>Edit Stage</h1>
  
      <form @submit.prevent="updateStage" class="form" v-if="stageToEdit.stage.id">
        <div class="form-group">
          <label for="name">Stage Name:</label>
          <input id="name" v-model="stageToEdit.stage.name" type="text" required>
        </div>
  
        <div class="form-group">
          <label for="date">Date:</label>
          <input id="date" v-model="stageToEdit.stage.date" type="date" required>
        </div>
  
        <div v-for="(event, index) in stageToEdit.events" :key="index" class="event">
          <h2>Event {{ index + 1 }}</h2>
  
          <div class="form-group">
            <label :for="'eventName' + index">Event Name:</label>
            <input :id="'eventName' + index" v-model="event.name" type="text" required>
          </div>
  
          <div class="form-group">
            <label :for="'eventStartTime' + index">Start Time:</label>
            <input :id="'eventStartTime' + index" v-model="event.start_time" type="time" required>
          </div>
  
          <div class="form-group">
            <label :for="'eventEndTime' + index">End Time:</label>
            <input :id="'eventEndTime' + index" v-model="event.end_time" type="time" required>
          </div>
  
          <div class="form-group">
            <label :for="'eventSpeaker' + index">Speaker:</label>
            <input :id="'eventSpeaker' + index" v-model="event.speaker" type="text" required>
          </div>
  
          <div class="form-group">
            <label :for="'eventLink' + index">Link:</label>
            <input :id="'eventLink' + index" v-model="event.link" type="url">
          </div>
  
          <div class="form-group">
            <label :for="'eventDescription' + index">Description:</label>
            <textarea :id="'eventDescription' + index" v-model="event.description"></textarea>
          </div>
  
          <div class="form-group">
            <label :for="'eventImage' + index">Event Image:</label>
            <input :id="'eventImage' + index" type="file" @change="handleImageChange(index, $event)">
          </div>
        </div>
  
        <button type="button" @click="addEvent" class="btn">Add Event</button>
        <button type="submit" class="btn">Update Stage</button>
        <button type="button" @click="removeEvent(index)" class="btn">Remove Event</button>
      </form>
    </div>
  </template>
  <script>
  export default {
    props: {
      stageToEdit: {
        type: Object,
        default: () => ({ stage: {}, events: [] }),
      },
    },
    data() {
      return {
        successMessage: '',
        errorMessage: '',
      };
    },
    methods: {
      removeEvent(index) {
        this.stageToEdit.events.splice(index, 1);
      },
      addEvent() {
        this.stageToEdit.events.push({
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
        this.stageToEdit.events[index].image = event.target.files[0];
      },
      async updateStage() {
        try {
          const formData = new FormData();
  
          formData.append('stage', JSON.stringify(this.stageToEdit.stage));
  
          this.stageToEdit.events.forEach((event, index) => {
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
  
          const response = await fetch(`http://localhost/Backend/laravel/public/api/editStage/${this.stageToEdit.stage.id}`, {
            method: 'POST',
            body: formData,
          });
  
          if (!response.ok) {
            const data = await response.json();
            this.errorMessage = data.error;
            alert(this.errorMessage);
            throw new Error(`HTTP error! status: ${response.status}`);
          } else {
            this.successMessage = 'Stage has been updated successfully!';
            alert(this.successMessage);
            this.errorMessage = '';
            this.$emit('stageUpdated', this.stageToEdit);

          }
        } catch (error) {
          this.successMessage = '';
          console.error(error);
        }
      },
    },
  };
  </script>
  <style scoped>
  .form {
  
    
  
    background-color: #f7f7f7;
    border-radius: 5px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
  }
  
  .form-group {
    margin-bottom: 15px;
    display: flex;
    flex-direction: column;
  }
  
  .form-group label {
    margin-bottom: 5px;
    font-weight: bold;
    color: #333;
  }
  
  .form-group input,
  .form-group textarea {
    padding: 10px;
    border-radius: 5px;
    border: 1px solid #ccc;
    font-size: 16px;
  }
  
  .event {
    padding: 10px;
    margin-bottom: 15px;
    border: 1px solid #ccc;
    border-radius: 5px;
    background-color: #fff;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.05);
  }
  
  .btn {
    margin-top: 10px;
    padding: 10px 20px;
    background-color: #007BFF;
    color: #fff;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    font-size: 16px;
    transition: background-color 0.3s ease;
  }
  
  .btn:hover {
    background-color: #0056b3;
  }
  </style>
  
  