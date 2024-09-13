<template>
    <div>
        <form
            @submit.prevent="submitCreateDirectoryForm" 
            class="w-full mx-auto">
            <label 
                for="new-directory" 
                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                {{ __('Directory Name') }}
            </label>
            <input 
                v-model="directoryName" 
                type="text" 
                id="new-directory" 
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" 
                required>

            <button 
                type="submit" 
                class="mt-4 w-full bg-green-500 text-white py-2 rounded-lg hover:bg-green-600">
                {{ __('Create Directory') }}
            </button>
        </form>
    </div>
</template>

<script>
export default {
    data() {
        return {
            directoryName: ''
        };
    },
    computed: {
        currentDirectory() {
            return this.$store.getters['fileManagerStore/getCurrentDirectory'];
        }
    },
    methods: {
        async submitCreateDirectoryForm() {
            if (!this.directoryName) {
                alert("Please enter a directory name.");
                return;
            }
            
            try {
                await this.$store.dispatch('fileManagerStore/createDirectory', this.directoryName);
                this.$store.commit('fileManagerStore/CLOSE_CREATE_DIRECTORY_MODAL');
                this.directoryName = '';
            } catch (error) {
                console.error('Error creating directory:', error);
                alert('Failed to create directory');
            }
        }
    }
};
</script>

<style scoped>
/* Add your custom styles here */
</style>
