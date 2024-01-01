<template>
    <div v-if="open" :id="id" class="fixed inset-0 z-50 overflow-y-auto">

        <div class="flex items-end justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
            
            <div class="fixed inset-0 transition-opacity" aria-hidden="true">
                <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
            </div>

            <!-- Centra el contenido del modal verticalmente -->
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

            <div :class="{
                    'max-w-6xl': largeModal, // 90% para largeModal
                    'max-w-lg': !largeModal  // Tamaño estándar para otros casos
                 }"
                 class="inline-block overflow-hidden text-left align-bottom transition-all transform bg-white rounded-lg shadow-xl dark:bg-gray-700 sm:my-8 sm:align-middle sm:w-full">
                
                <div class="flex justify-between items-center p-4 border-b border-gray-200 dark:border-gray-600">
                    <h2 class="text-xl font-semibold text-gray-900 dark:text-white">{{ title }}</h2>
                    <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white" @click="closeModal">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M10 9a1 1 0 011-1h6a1 1 0 110 2h-6a1 1 0 01-1-1zM4 9a1 1 0 011-1h4a1 1 0 110 2H5a1 1 0 01-1-1z" clip-rule="evenodd"></path>
                        </svg>
                    </button>
                </div>

                <div class="p-0">
                    <slot name="body"></slot>
                </div>

                <div v-if="showFooter" class="p-4 border-t border-gray-200 dark:border-gray-600">
                    <slot name="footer"></slot>
                </div>

            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        id: {
            type: String,
            default: 'modal-id',
        },
        open: {
            type: Boolean,
            default: false,
        },
        title: {
            type: String,
            default: 'Modal title',
        },
        largeModal: {
            type: Boolean,
            default: false,
        },
        showFooter: {
            type: Boolean,
            default: false,
        },
    },
    emits: ['close'],
    methods: {
        closeModal() {
            this.$emit('close');
        }
    }
}
</script>
