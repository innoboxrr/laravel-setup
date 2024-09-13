<template>
    <section class="mt-8 pb-16" aria-labelledby="gallery-heading">
        <ul 
            role="list" 
            class="grid grid-cols-3 gap-x-4 gap-y-8 sm:grid-cols-3 sm:gap-x-6 md:grid-cols-4 lg:grid-cols-4 xl:grid-cols-5 xl:gap-x-8">
            <li 
                v-for="file in files" 
                :key="file.name" 
                class="relative cursor-pointer"
                @click="toggleSelectFile(file)">
                <input 
                    v-if="file.information.type !== 'directory'"
                    type="checkbox" 
                    class="absolute top-2 right-2 z-10 cursor-pointer" 
                    name="selectedFiles"
                    :value="file.name"
                    @change="toggleSelectFile(file)"
                    @click.stop
                    :checked="selectedFiles.findIndex(selectedFile => selectedFile.name === file.name) >= 0"
                />
                <component 
                    :is="getComponentForFileType(file.information.type)"
                    :file="file"
                />
                <p class="pointer-events-none mt-2 block truncate text-sm font-medium text-gray-900 dark:text-gray-100">
                    {{ file.name }}
                </p>
                <p 
                    v-if="file.information.type  !== 'directory'"
                    class="pointer-events-none block text-sm font-medium text-gray-500 dark:text-gray-400">
                    {{ file.size }}
                </p>
            </li>
        </ul>
    </section>
</template>

<script>

import { getComponentForFileType } from '../js/helpers.js';
import { defineAsyncComponent } from 'vue';

export default {
    setup() {
        return {
            getComponentForFileType
        }
    },
    components: {
        ImageCard: defineAsyncComponent(() => import('../cards/ImageCard.vue')),
        AudioCard: defineAsyncComponent(() => import('../cards/AudioCard.vue')),
        VideoCard: defineAsyncComponent(() => import('../cards/VideoCard.vue')),
        DocumentCard: defineAsyncComponent(() => import('../cards/DocumentCard.vue')),
        DefaultCard: defineAsyncComponent(() => import('../cards/DefaultCard.vue')),
        DirectoryCard: defineAsyncComponent(() => import('../cards/DirectoryCard.vue'))
    },
    computed: {
        files() {
            return this.$store.getters['fileManagerStore/getFiles'];
        },
        selectedFiles() {
            return this.$store.state.fileManagerStore.selectedFiles;
        }
    },
    methods: {
        toggleSelectFile(file) {
            if(file.information.type === 'directory') {
                this.$store.dispatch('fileManagerStore/pushDirectory', file.name);
                return;
            }
            const index = this.selectedFiles.findIndex(selectedFile => selectedFile.name === file.name);
            if (index >= 0) {
                this.$store.commit('fileManagerStore/SET_SELECTED_FILES', this.selectedFiles.filter(selectedFile => selectedFile.name !== file.name));
            } else {
                this.$store.commit('fileManagerStore/SET_SELECTED_FILES', [...this.selectedFiles, file]);
            }
        },
        selectFile(file) {
            this.$store.commit('fileManagerStore/SET_FILE', file);
        }
    }
}
</script>
