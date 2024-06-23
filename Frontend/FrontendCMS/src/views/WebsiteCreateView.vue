<template>
    <mavon-editor class= "editor" ref="md" @imgAdd="$imgAdd" @imgDel="$imgDel" language="en"></mavon-editor>
    <div class="form-container">
        <input type="text" v-model="name" placeholder="Enter name here">
    </div>
    <div class="checkbox-container">
        <label>
            <input type="checkbox" v-model="includeNavbar"> Include in Navbar
        </label>
        <br>
        <label>
            <input type="checkbox" v-model="includeFooter"> Include in Footer
        </label>
    </div>
    <div class="button-container">
        <button class="upload-button" @click="upload_data">Upload</button>
    </div>
    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Character Count</th>
                    <th>Image Count</th>
                    <th>Location</th>
                    <th>Actions</th>
                    
                </tr>
            </thead>
            <tbody>
                <tr v-for="content in contents" :key="content.id">
                    <td>{{ content.name }}</td>
                    <td>{{ getCharacterCount(content.content) }}</td>
                    <td>{{ getImageCount(content.content) }}</td>
                    <td>{{ content.location }}</td>

                    <td>
                        <button @click="confirmDelete(content.id)" class="delete-button">Delete</button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
export default {
    data() {
        return {
            img_file: {},
            markdownContent: '',
            name: '',
            includeNavbar: false,
            includeFooter: false,
            contents: []
        }
    },
    methods: {
        $imgAdd(pos, $file) {
            this.img_file[pos] = $file;
        },
        $imgDel(pos) {
            delete this.img_file[pos];
        },
        upload_data() {
            var formdata = new FormData();
            var baseUrl = import.meta.env.VITE_BASE_URL;

            for (var _img in this.img_file) {
                formdata.append(_img, this.img_file[_img], this.img_file[_img].name);
            }

            this.Content = this.$refs.md.d_render;

            if (!this.Content.trim()) {
                alert("You can't send empty content!");
                return;
            }

            var ContentWithoutByte = this.Content;

            for (var _img in this.img_file) {
                var regex = /(<img[^>]*src=")data:image\/[^"]*("[^>]*>)/;
                ContentWithoutByte = ContentWithoutByte.replace(regex, '$1' + baseUrl + '/laravel/public/storage/images/editor/' + this.img_file[_img].name + '$2');
            }

            formdata.append('content', ContentWithoutByte);
            formdata.append('name', this.name);

            if (this.includeNavbar && this.includeFooter) {
                formdata.append('location', 'both');
            } else if (this.includeNavbar) {
                formdata.append('location', 'navbar');
            } else if (this.includeFooter) {
                formdata.append('location', 'footer');
            }

            console.log('Form Data:', [...formdata]);
            fetch('./laravel/public/api/editorPost', {
                method: 'POST',
                body: formdata,
            })
            .then(response => {
                if(response.ok) {
                    alert('Upload successful!');
                    this.fetchContents();
                } else {
                    alert('Upload failed!');
                }
            })
            .catch(error => console.error('Error:', error));
        },
        fetchContents() {
            fetch('./laravel/public/api/editorPost')
            .then(response => response.json())
            .then(data => {
                this.contents = data.content;
            })
            .catch(error => console.error('Error:', error));
        },
        getCharacterCount(content) {
            return content.length;
        },
        getImageCount(content) {
            const imgTags = content.match(/<img[^>]*>/g);
            return imgTags ? imgTags.length : 0;
        },
        confirmDelete(id) {
            if (confirm("Are you sure you want to delete this content?")) {
                this.deleteContent(id);
            }
        },
        deleteContent(id) {
            fetch(`./laravel/public/api/editorDelete/${id}`, {
                method: 'DELETE',
            })
            .then(response => {
                if(response.ok) {
                    alert('Delete successful!');
                    this.fetchContents();
                } else {
                    alert('Delete failed!');
                }
            })
            .catch(error => console.error('Error:', error));
        }
    },
    mounted() {
        this.fetchContents();
    }
}
</script>

<style scoped>
.editor{
    height: 500px;
}
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

.table-container {
    margin-top: 20px;
}

table {
    width: 100%;
    border-collapse: collapse;
}

th, td {
    border: 1px solid #ddd;
    padding: 8px;
}

th {
    background-color: #f2f2f2;
    text-align: left;
}

.delete-button {
    padding: 5px 10px;
    background-color: #f44336;
    border: none;
    color: white;
    cursor: pointer;
}

.delete-button:hover {
    background-color: #e53935;
}
</style>
