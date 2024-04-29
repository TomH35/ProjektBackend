<template>
 
    <mavon-editor ref="md" @imgAdd="$imgAdd" @imgDel="$imgDel" language="en"></mavon-editor>
    <div class="button-container">
            <button class="upload-button" @click="upload_data">Upload</button>
        </div>

</template>

<script>
export default {
    data() {
        return {
            img_file: {},
            markdownContent: '',
           
        }
    },
    
    methods: {

    

        $imgAdd(pos, $file) {
            this.img_file[pos] = $file;
        },
        $imgDel(pos) {
            delete this.img_file[pos];
        },
        upload_data($e) {
    var formdata = new FormData();
    for(var _img in this.img_file){
        formdata.append(_img, this.img_file[_img], this.img_file[_img].name);
    }
    this.Content = this.$refs.md.d_render;

    if (!this.Content.trim()) {
        alert("You can't send empty content!");
        return;
    }

    var ContentWithoutByte = this.Content;
  
    for(var _img in this.img_file){
        var regex = new RegExp('<img[^>]*src="data:image\/[^"]*"[^>]*>');
        ContentWithoutByte = ContentWithoutByte.replace(regex, '<img src="http://localhost/backend/laravel/storage/app/public/images/editor/' + this.img_file[_img].name + '">');
    }

    formdata.append('content', ContentWithoutByte);
    console.log('Form Data:', [...formdata]);
    fetch('http://localhost/Backend/laravel/public/api/editorPost', {
        method: 'POST',
        body: formdata,
    })
    .then(response => {
        if(response.ok) {
            alert('Upload successful!');
        } else {
            alert('Upload failed!');
        }
    })
    .catch(error => console.error('Error:', error));
}



        
        
    }
    
    
}
</script>

<style scoped>
.editor-container {
    position: relative;
}

.button-container {
    text-align: right;
    margin-right: 10px 
}

.upload-button {
    margin-top: 10px;
    padding: 10px 20px;
    background-color: #4CAF50; 
    border: none;
    color: white;
    text-align: center;
    text-decoration: none;
    display: inline-block;
    font-size: 16px;
    transition-duration: 0.4s;
    cursor: pointer;
    border-radius: 10%;
}

.upload-button:hover {
    background-color: #45a049;
}
</style>