<template>

    <div 
        :id="id"
        :class="{
            'uk-modal-container': largeModal,
        }"
        uk-modal="bg-close: false; esc-close: false;">

        <div class="uk-modal-dialog bg-white rounded-lg shadow dark:bg-gray-700 p-0">

            <button class="uk-modal-close-default" type="button"  @click="closeModal">
                <i class="fas fa-times"></i>
            </button>

            <div class="uk-modal-header bg-white rounded-t-lg shadow dark:bg-gray-800 dark:border-gray-800 p-2">
                
                <h2 class="text-xl font-semibold text-gray-900 dark:text-white pl-2">{{ title  }}</h2>

            </div>

            <div 
                class="uk-modal-body bg-white shadow dark:bg-gray-700 text-base leading-relaxed text-gray-500 dark:text-gray-400 p-0" 
                :class="{
                    'rounded-b-lg': !showFooter,
                }"
                uk-overflow-auto>

                <slot v-if="showBody" name="body"></slot>

                <div v-else class="modal-closing-animation flex justify-center items-center min-h-96">
                    <div class="p-24 bg-white rounded-lg dark:bg-gray-800">
                        <p class="font-normal text-gray-700 dark:text-gray-400 opacity-20">
                            Cerrando ventana
                        </p>
                    </div>
                </div>
                
            </div>

            <div
                v-if="showFooter" 
                class="uk-modal-footer bg-white rounded-b-lg shadow dark:bg-gray-700 dark:border-gray-800">
                
                <slot name="footer "></slot>

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

            showHeader: {
                type: Boolean,
                default: false,
            },

            showFooter: {
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

        },

        emits: ['close', 'open'],

        data() {
            return {
                showBody: true
            }
        },

        mounted() {
            console.log('ModalComponent.vue mounted');
        },

        watch: {
            open(newVal) {
                if (newVal) {
                    this.openModal();
                } else {
                    this.closeModal();
                }
            }
        },

        methods: {
            
            openModal() {
                UIkit.modal(`#${this.id}`).show();
                this.$emit('open');
            },

            closeModal() {
                try {
                    
                    this.showBody = false;

                    setTimeout(() => {
                        
                        this.showBody = true;
                        
                        UIkit.modal(`#${this.id}`).hide();
                        
                        this.$emit('close');

                    }, 1000);

                    this.sleep(1000); // Review mixin

                } catch (error) {

                    console.log(error);

                }

            }

        }

    }

</script>