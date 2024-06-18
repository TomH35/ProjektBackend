<template>
  <div class="content-container">
    <div 
      class="content-item" 
      v-for="content in contents" 
      :key="content.id"
    >
      <h2>{{ content.name }}</h2> 
      <div 
        v-if="content.id === activeContentId" 
        class="content-display"
        v-html="fetchedContent"
      ></div>
      <button 
        class="content-button" 
        @click="fetchContent(content.id)"
      >
        {{ content.id === activeContentId ? 'Hide' : 'Read more' }}
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
    const response = await fetch(`./laravel/public/api/editorPost`);
    const data = await response.json();
    this.contents = data.content;
  },
  methods: {
    async fetchContent(id) {
      if (this.activeContentId === id) {
        this.activeContentId = null;
        this.fetchedContent = '';
      } else {
        const response = await fetch(`./laravel/public/api/editorPost/${id}`);
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
  
  <style scoped>
  .content-container {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 1rem;
  }
  
  .content-item {
    width: 100%;
    border: 1px solid #ddd;
    padding: 1rem;
    border-radius: 0.5rem;
  }
  
  .content-display {
    margin-bottom: 1rem;
  }
  
  .content-button {
    padding: 0.5rem 1rem;
    border: none;
    border-radius: 0.5rem;
    background-color: #007BFF;
    color: white;
    cursor: pointer;
  }
  
  .content-button:hover {
    background-color: #0056b3;
  }
  
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
  