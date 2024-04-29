<template>
    <div>
      <div v-for="content in contents" :key="content.id">
        <div v-if="content.id === activeContentId" v-html="fetchedContent"></div>
        <button @click="fetchContent(content.id)">
          {{ content.id === activeContentId ? 'Hide Content' : 'Render Content' }}
        </button>
      </div>
    </div>
  </template>
  
  <script>
  export default {
    data() {
      return {
        contents: [],
        fetchedContent: '',
        activeContentId: null
      }
    },
    async mounted() {
      const response = await fetch(`http://localhost/Backend/laravel/public/api/editorPost`);
      const data = await response.json();
      this.contents = data.content;
    },
    methods: {
      async fetchContent(id) {
        if (this.activeContentId === id) {
          this.activeContentId = null;
          this.fetchedContent = '';
        } else {
          const response = await fetch(`http://localhost/Backend/laravel/public/api/editorPost/${id}`);
          const data = await response.json();
          this.fetchedContent = this.applyStyles(data.content);
          this.activeContentId = id;
        }
      },
      applyStyles(html) {
        return html
          .replace(/hljs-center/g, this.$style['hljs-center'])
          .replace(/hljs-left/g, this.$style['hljs-left'])
          .replace(/hljs-right/g, this.$style['hljs-right']);
      }
    }
  }
  </script>
  
  <style module>
  .hljs-center {
    display: flex;
    justify-content: center;
    align-items: center;
    flex-direction: column;
    text-align: center;
  }
  
  .hljs-left {
    text-align: left;
  }
  
  .hljs-right {
    text-align: right;
  }
  </style>
  