<template>
	
	<form :id="formId" @submit.prevent="onSubmit">

        <div class="rounded-md bg-yellow-50 p-4">
            <div class="flex">
                <div class="flex-shrink-0">
                <svg class="h-5 w-5 text-yellow-400" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                    <path fill-rule="evenodd" d="M8.485 2.495c.673-1.167 2.357-1.167 3.03 0l6.28 10.875c.673 1.167-.17 2.625-1.516 2.625H3.72c-1.347 0-2.189-1.458-1.515-2.625L8.485 2.495zM10 5a.75.75 0 01.75.75v3.5a.75.75 0 01-1.5 0v-3.5A.75.75 0 0110 5zm0 9a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd" />
                </svg>
                </div>
                <div class="ml-3">
                <h3 class="text-sm font-medium text-yellow-800">
                    {{ __('No form available') }}
                </h3>
                <div class="mt-2 text-sm text-yellow-700">
                    <p>
                        {{ __('The "Translation" model does not have a form available') }}
                    </p>
                </div>
                </div>
            </div>
        </div>

        <button-component
            v-if="false"
            :custom-class="buttonClass"
            :disabled="disabled"
            :value="__('Update')" />
        
    </form>

</template>

<script>

    import { showModel, updateModel} from '@models/translation'
    import JSValidator from 'innoboxrr-js-validator'
    import {
        TextInputComponent,
        ButtonComponent
    } from 'innoboxrr-form-elements'
    
	
	export default {

        components: {
            
            TextInputComponent,
            
            ButtonComponent,

        },

        props: {

            formId: {
                type: String,
                default: 'editTranslationForm'
            },

            translationId: {
                type: [Number, String],
                required: true
            },
            defaultLang: {
                type: String,
                default: null
            },

        },

        emits: ['submit'],

        mounted() {

            this.fetchData(); 

            this.JSValidator = new JSValidator(this.formId).init();

            this.JSValidator.status = true;

        },

        data() {

            return {

                translation: {},

                // ...
                lang: this.defaultLang,

                disabled: false,

                JSValidator: undefined,

            }

        },

        methods: {

            fetchData() {

                this.fetchTranslation();

            },

            fetchTranslation() {

                showModel(this.translationId, [], [], { lang: this.lang }).then( res => {

                    this.translation = this.translateModel(res);

                });

            },

            onSubmit() {

                if(this.JSValidator.status) {

                    this.disabled = true;

                    updateModel(this.translation.id, {
                        lang: this.lang
                    }).then( res => {

                        this.$emit('submit', res);
                        this.alert('success');

                        setTimeout(() => { this.disabled = false; }, 2500);

                    }).catch(error => {

                        this.disabled = false;

                        if(error.response.status == 422)
                            this.JSValidator
                                .appendExternalErrors(error.response.data.errors);

                    });

                } else {

                    this.disabled = false;

                }

            }

        }

	}

</script>