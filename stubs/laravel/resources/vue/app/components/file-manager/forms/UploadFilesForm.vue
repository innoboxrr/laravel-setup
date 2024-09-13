<template>
    <div>
        <!-- Dropzone para subir archivos -->
        <div class="flex items-center justify-center w-full mb-4">
            <label for="dropzone-file" 
                class="flex flex-col items-center justify-center w-full h-48 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 dark:hover:bg-gray-800 dark:bg-gray-700 hover:bg-gray-100 dark:border-gray-600 dark:hover:border-gray-500 dark:hover:bg-gray-600">
                <div class="flex flex-col items-center justify-center pt-5 pb-6">
                    <svg class="w-8 h-8 mb-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 16">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2"/>
                    </svg>
                    <p class="mb-2 text-sm text-gray-500 dark:text-gray-400"><span class="font-semibold">Click to upload</span> or drag and drop</p>
                    <p class="text-xs text-gray-500 dark:text-gray-400">SVG, PNG, JPG or GIF (MAX. 800x400px)</p>
                </div>
                <input id="dropzone-file" type="file" class="hidden" @change="handleFiles" multiple />
            </label>
        </div>

        <!-- Vista previa de archivos seleccionados -->
        <div v-if="files.length" class="mb-4">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">Files to Upload:</h3>
            <ul>
                <li v-for="(file, index) in files" :key="index" class="flex items-center justify-between p-2 mb-2 bg-gray-100 rounded-lg dark:bg-gray-800">
                    <div class="flex items-center">
                        <img v-if="file.type.startsWith('image/')" :src="getFilePreview(file)" class="w-10 h-10 object-cover mr-2 rounded" alt="Preview" />
                        <div>
                            <p class="text-sm font-medium text-gray-900 dark:text-white">{{ file.name }}</p>
                            <p class="text-xs text-gray-500 dark:text-gray-400">{{ (file.size / 1024).toFixed(2) }} KB</p>
                        </div>
                    </div>
                    <div class="flex items-center">
                        <button @click="removeFile(index)" class="text-red-500 hover:text-red-700 mr-2">
                            <i class="fa-solid fa-trash"></i>
                        </button>
                        <a :href="getFilePreview(file)" download :title="'Download ' + file.name" class="text-blue-500 hover:text-blue-700">
                            <i class="fa-solid fa-eye"></i>
                        </a>
                    </div>
                </li>
            </ul>
        </div>

        <!-- Formulario para seleccionar privacidad y subir archivos -->
        <form @submit.prevent="submitForm" class="w-full mt-4">
            <label for="privacy" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Select Privacy</label>
            <select id="privacy" v-model="privacy" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                <option value="private">Private</option>
                <option value="public-read">Public</option>
            </select>

            <button type="submit" class="mt-4 w-full bg-blue-500 text-white py-2 rounded-lg hover:bg-blue-600">Upload Files</button>
        </form>
    </div>
</template>

<script>
export default {
    data() {
        return {
            files: [],
            privacy: 'private',
        };
    },
    computed: {
        currentDirectory() {
            return this.$store.getters['fileManagerStore/getCurrentDirectory'];
        }
    },
    methods: {
        handleFiles(event) {
            // Agregar los archivos nuevos a los archivos existentes
            const newFiles = Array.from(event.target.files);
            this.files = this.files.concat(newFiles);
        },
        removeFile(index) {
            this.files.splice(index, 1);
        },
        getFilePreview(file) {
            if (window.URL && window.URL.createObjectURL) {
                return window.URL.createObjectURL(file);
            }
            return '';
        },
        async submitForm() {
            if (this.files.length === 0) {
                alert("Please select at least one file.");
                return;
            }
            
            try {
                await this.$store.dispatch('fileManagerStore/uploadFiles', {
                    files: this.files,
                    privacy: this.privacy
                });
                this.files = []; 
            } catch (error) {
                console.error('Error uploading files:', error);
                alert('Failed to upload files');
            }
        }
    }
};
</script>

<style scoped>
/* Add your custom styles here */
</style>
