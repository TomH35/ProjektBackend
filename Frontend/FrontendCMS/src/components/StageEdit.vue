<template>
  <div v-if="stageToEdit.stage" class="stage-create container">
    <div class="card">
      <div class="card-body">
        <form @submit.prevent="updateStage" class="form" v-if="stageToEdit.stage.id">

          <div class="mb-3">
            <label for="name" class="form-label">Stage Name:</label>
            <input id="name" v-model="stageToEdit.stage.name" type="text" class="form-control" required>
          </div>

          <div class="mb-3">
            <label for="date" class="form-label">Date:</label>
            <input id="date" v-model="stageToEdit.stage.date" type="date" class="form-control" required>
          </div>

          <div v-for="(event, index) in stageToEdit.events" :key="index" class="event">
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
              <select :id="'eventSpeaker' + index" v-model="event.speaker_id" class="form-control" required>
                <option v-for="speaker in speakers" :key="speaker.id" :value="speaker.id">{{ speaker.name }} {{ speaker.surname }}</option>
              </select>
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
              <label :for="'eventCapacity' + index" class="form-label">Capacity:</label>
              <input :id="'eventCapacity' + index" v-model="event.capacity" type="number" class="form-control" required>
            </div>
            
            <label :for="'eventSelectable' + index" class="form-label">Selectable:</label>
            <input :id="'eventSelectable' + index" type="checkbox" :checked="event.is_selectable" @change="event.is_selectable = $event.target.checked" class="form-check-input">


            <div class="mb-3">
              <label :for="'eventImage' + index" class="form-label">Event Image:</label>
              <input :id="'eventImage' + index" type="file" class="form-control" @change="handleImageChange(index, $event)">
            </div>
          </div>

          <button type="button" @click="addEvent" class="btn btn-primary mt-3">Add Event</button>
          <button type="submit" class="btn btn-success mt-3">Update Stage</button>
          <button type="button" @click="removeEvent()" class="btn btn-danger mt-3">Remove Event</button>
        </form>
      </div>
    </div>
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
      speakers: [],
    };
  },
  created() {
    this.fetchSpeakers();
  },

  
  methods: {
    async fetchSpeakers() {
      try {
        const response = await fetch('./laravel/public/api/Speakers');
        if (!response.ok) {
          throw new Error(`HTTP error! status: ${response.status}`);
        }
        this.speakers = await response.json();
      } catch (error) {
        console.error('There was a problem with the fetch operation: ', error);
      }
    },
    removeEvent() {
      this.stageToEdit.events.pop();
    },
    addEvent() {
      this.stageToEdit.events.push({
        name: '',
        start_time: '',
        end_time: '',
        speaker_id: null,
        link: '',
        description: '',
        image: null,
        capacity: 0,
        is_selectable: true,
        
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
                if (key === 'is_selectable') {
                  formData.append(`events[${index}][${key}]`, event[key] ? '1' : '0');
                } else {
                  formData.append(`events[${index}][${key}]`, event[key]);
                }
              }
            }
          }
        });


        const response = await fetch(`./laravel/public/api/StageUpdate/${this.stageToEdit.stage.id}`, {
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
          this.$emit('stageUpdated');
        }
      } catch (error) {
        this.successMessage = '';
        console.error(error);
      }
    },
  },
};
</script>
