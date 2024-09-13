<template>
    <div class="space-y-6 pb-16">

        <!-- Si hay solo un archivo seleccionado, mostrar sus detalles -->
        <div v-if="selectedFiles.length === 1">
            <div class="block w-full overflow-hidden rounded-lg">
                <component 
                    :is="getComponentForFileType(selectedFile.information.type)"
                    :file="selectedFile"
                />
            </div>
            <div class="mt-4 flex items-start justify-between">
                <div>
                    <h2 class="text-lg font-medium text-gray-900 dark:text-white">
                        <span class="sr-only">{{ __('Details for') }} </span>{{ selectedFile.name }}
                    </h2>
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">
                        {{ selectedFile.size }}
                    </p>
                </div>
                <div class="relative ml-4">
                    <aside-dropdown-menu
                        :file="selectedFile" />
                </div>
            </div>
            <div class="mt-4">
                <h3 class="font-medium text-gray-900 dark:text-white">
                {{ __('Information') }}
                </h3>
                <dl class="mt-2 divide-y divide-gray-200 dark:divide-gray-700 border-b border-t border-gray-200 dark:border-gray-700">
                    <div 
                        v-for="(value, key) in selectedFile.information" 
                        :key="key" 
                        class="flex justify-between py-3 text-sm font-medium">
                        <dt class="text-gray-500 dark:text-gray-400">
                            {{ key }}
                        </dt>
                        <dd class="whitespace-nowrap text-gray-900 dark:text-white">
                            {{ value }}
                        </dd>
                    </div>
                </dl>
            </div>
        </div>

        <!-- Si hay múltiples archivos seleccionados, mostrar resumen -->
        <div v-else-if="selectedFiles.length > 1">
            <div class="mt-4 flex items-start justify-between">
                <div>
                    <h2 class="text-lg font-medium text-gray-900 dark:text-white">
                        {{ selectedFiles.length }} {{ __('items selected') }}
                    </h2>
                </div>
                <div class="relative ml-4">
                    <aside-dropdown-menu
                        :files="selectedFiles" />
                </div>
            </div>
            <div>
                <div 
                    v-for="file in selectedFiles" 
                    :key="file.name" 
                    class="flex items center justify-between mt-4">
                    <div>
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">
                            {{ file.name }}
                        </p>
                    </div>
                    <div>
                        <span class="text-sm font-medium text-gray-900 dark:text-white">
                            {{ file.size }}
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Si no hay archivos seleccionados -->
        <div v-else>
            <p class="text-gray-500 dark:text-gray-400">
                {{ __('No items selected') }}
            </p>
        </div>
        
    </div>
</template>

<script>
import { defineAsyncComponent } from 'vue';
import { getComponentForFileType } from '../js/helpers.js';

export default {
    setup() {
        return {
            getComponentForFileType
        }
    },
    components: {
        AsideDropdownMenu: defineAsyncComponent(() => import('./AsideDropdownMenu.vue')),
        ImageCard: defineAsyncComponent(() => import('../cards/ImageCard.vue')),
        AudioCard: defineAsyncComponent(() => import('../cards/AudioCard.vue')),
        VideoCard: defineAsyncComponent(() => import('../cards/VideoCard.vue')),
        DocumentCard: defineAsyncComponent(() => import('../cards/DocumentCard.vue')),
        DefaultCard: defineAsyncComponent(() => import('../cards/DefaultCard.vue')),
        DirectoryCard: defineAsyncComponent(() => import('../cards/DirectoryCard.vue'))
    },
    data() {
        return {
            
        };
    },
    computed: {
        selectedFiles() {
            return this.$store.state.fileManagerStore.selectedFiles;
        },
        selectedFile() {
            return this.selectedFiles.length === 1 ? this.selectedFiles[0] : null;
        }
    },
    methods: {
        async changeVisibility(visibility) {
            if (this.selectedFile) {
                // Lógica para cambiar la visibilidad de un archivo
                try {
                    await this.$store.dispatch('fileManagerStore/changeFileVisibility', {
                        fileKey: this.selectedFile.source,
                        visibility
                    });
                } catch (error) {
                    console.error('Error changing visibility:', error);
                }
            }
        },
        async changeVisibilityForSelected(visibility) {
            if (this.selectedFiles.length > 1) {
                // Lógica para cambiar la visibilidad de múltiples archivos
                try {
                    await this.$store.dispatch('fileManagerStore/changeFilesVisibility', {
                        fileKeys: this.selectedFiles.map(file => file.name),
                        visibility
                    });
                } catch (error) {
                    console.error('Error changing visibility for selected files:', error);
                }
            }
        }
    }
}
</script>
