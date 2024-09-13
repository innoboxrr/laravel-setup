<template>
    <div v-flowbite>
        <button 
            data-dropdown-toggle="fm-aside-dropdown-menu" 
            type="button" 
            class="relative flex h-8 w-8 items-center justify-center rounded-full bg-white dark:bg-gray-700 text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-600 hover:text-gray-500 dark:hover:text-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500">
            <i class="fa-solid fa-bars"></i>
        </button>
        <!-- Dropdown menu -->
        <div 
            id="fm-aside-dropdown-menu" 
            class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-44 dark:bg-gray-700">
            <ul 
                class="py-2 text-sm text-gray-700 dark:text-gray-200" 
                aria-labelledby="dropdownDefaultButton">
                <li v-if="file && file.information.visibility == 'private' && file.information.type != 'directory'">
                    <a 
                        @click="changeVisibility('public')" 
                        class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">
                        {{ __('Make Public') }}
                    </a>
                </li>
                <li v-if="file && file.information.visibility == 'public' && file.information.type != 'directory'">
                    <a 
                        @click="changeVisibility('private')" 
                        class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">
                        {{ __('Make Private') }}
                    </a>
                </li>
                <li v-if="file && file.information.visibility == 'public' && file.information.type != 'directory'">
                    <a 
                        @click="copyUrl()" 
                        class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">
                        {{ __('Copy public URL') }}
                    </a>
                </li>
                <li v-if="file && file.information.type != 'directory'">
                    <a 
                        @click="copySignedUrl()" 
                        class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">
                        {{ __('Copy temporary URL') }}
                    </a>
                </li>
            </ul>
        </div>
    </div>
</template>

<script>

export default {
    props: {
        file: {
            type: Object,
            default: null
        },
        files: {
            type: Array,
            default: () => []
        }
    },
    methods: {
        async changeVisibility(visibility) {
            if (this.file) {
                try {
                    await this.$store.dispatch('fileManagerStore/changeFileVisibility', {
                        fileKey: this.file.source,
                        visibility
                    });
                    this.file.information.visibility = visibility;
                } catch (error) {
                    console.error('Error changing visibility:', error);
                }
            } else if (this.files.length > 1) {
                try {
                    await this.$store.dispatch('fileManagerStore/changeFilesVisibility', {
                        fileKeys: this.files.map(file => file.name),
                        visibility
                    });
                } catch (error) {
                    console.error('Error changing visibility for selected files:', error);
                }
            }
        },
        copyUrl() {
            if(!this.file) return;
            const url = this.file.url;
            navigator.clipboard.writeText(url);
            this.alert('success', {}, 'URL copied to clipboard');
        },
        copySignedUrl() {
            if(!this.file) return;
            const url = this.file.signedUrl;
            navigator.clipboard.writeText(url);
            this.alert('success', {}, 'URL copied to clipboard');
        },
    }
}
</script>
