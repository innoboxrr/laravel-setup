<template>
    <button 
        @click="toggleFullScreen"
        id="fullscreen-toggle" 
        type="button" 
        class="text-gray-500 inline-flex items-center justify-center dark:text-slate-400 dark:hover:text-slate-500 rounded-lg text-sm p-2.5">
        
        <i v-if="!isFullScreen" class="fa-solid fa-expand"></i>

        <i v-else class="fa-solid fa-compress"></i>

        <span class="sr-only">Toggle full screen mode</span>
    </button>
</template>

<script>
export default {
    data() {
        return {
            isFullScreen: false
        }
    },
    methods: {
        toggleFullScreen() {
            if (!document.fullscreenElement) {
                document.documentElement.requestFullscreen().then(() => {
                    this.isFullScreen = true;
                }).catch((err) => {
                    console.error(`Error attempting to enable full-screen mode: ${err.message} (${err.name})`);
                });
            } else if (document.exitFullscreen) {
                document.exitFullscreen().then(() => {
                    this.isFullScreen = false;
                }).catch((err) => {
                    console.error(`Error attempting to disable full-screen mode: ${err.message} (${err.name})`);
                });
            }
        }
    }
}
</script>
