<template>
    <mavon-editor ref="md" @imgAdd="$imgAdd" @imgDel="$imgDel" language="en"></mavon-editor>
    <div class="form-container">
        <input type="text" v-model="name" placeholder="Enter name here">
    </div>
    <div class="button-container">
        <button class="upload-button" @click="upload_data">Upload</button>
        <button class="redirect-button" @click="redirectToWebsiteView">Go to Website View</button>
    </div>
</template>

<script>
export default {
    data() {
        return {
            img_file: {},
            markdownContent: '',
            name: '', 
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
            var baseUrl = import.meta.env.VITE_BASE_URL;

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
                var regex = /(<img[^>]*src=")data:image\/[^"]*("[^>]*>)/;
                ContentWithoutByte = ContentWithoutByte.replace(regex, '$1' + baseUrl + '/laravel/public/storage/images/editor/' + this.img_file[_img].name + '$2');
            }

            formdata.append('content', ContentWithoutByte);
            formdata.append('name', this.name); 
            console.log('Form Data:', [...formdata]);
            fetch('./laravel/public/api/editorPost', {
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
        },

        redirectToWebsiteView() {
            this.$router.push({ name: 'WebsiteView' });
        }

        
    }
}
</script>

<style scoped>
.editor-container {
    position: relative;
}

.form-container {
    margin-top: 10px;
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
.redirect-button {
    margin-top: 10px;
    padding: 10px 20px;
    background-color: #af4c4c; 
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

.redirect-button:hover {
    background-color: #a04545;
}
</style>
