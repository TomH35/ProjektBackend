<template>
  <div class="content-container">
    <div v-if="editorPost">
      <h2>{{ editorPost.name }}</h2>
      <div class="content-display" v-html="applyStyles(editorPost.content)"></div>
    </div>
  </div>
</template>

<script>
export default {
  props: ['id'],
  data() {
    return {
      editorPost: null,
    };
  },
  created() {
    this.fetchEditorPost(this.id);
  },
  watch: {
    id(newId) {
      this.fetchEditorPost(newId);
    },
  },
  methods: {
    async fetchEditorPost(id) {
      try {
        const response = await fetch(`../laravel/public/api/editorPost/${id}`);
        const data = await response.json();
        this.editorPost = data;
      } catch (error) {
        console.error('Error fetching editor post:', error);
      }
    },
    applyStyles(html) {
      return html
        .replace(/hljs-center/g, this.$style['hljs-center'])
        .replace(/hljs-left/g, this.$style['hljs-left'])
        .replace(/hljs-right/g, this.$style['hljs-right']);
    },
  },
};
</script>

<style scoped>


.content-display {
  margin-bottom: 1rem;
  padding: 10px;
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