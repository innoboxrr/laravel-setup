<template>
	
	<form :id="formId" @submit.prevent="onSubmit">

        <!-- INPUTS -->
        <text-input-component
            :custom-class="inputClass"
            type="text"
            name="name"
            label="Nombre"
            placeholder="Nombre"
            validators="required length"
            min_length="3"
            max_length="100"
            v-model="name" />

        <button-component
            :custom-class="buttonClass"
            :disabled="disabled"
            value="Actualizar" />
        
    </form>

</template>

<script>

    import { showModel, updateModel} from '@models/search'
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
                default: 'editSearchForm'
            },

            searchId: {
                type: [Number, String],
                required: true
            }

        },

        emits: ['submit'],

        mounted() {

            this.fetchData(); 

            this.JSValidator = new JSValidator(this.formId).init();

            this.JSValidator.status = true;

        },

        data() {

            return {

                search: {},

                // ...

                disabled: false,

                JSValidator: undefined,

            }

        },

        methods: {

            fetchData() {

                this.fetchSearch();

            },

            fetchSearch() {

                showModel(this.searchId).then( res => {

                    this.search = res;

                    // Map other data

                });

            },

            onSubmit() {

                if(this.JSValidator.status) {

                    this.disabled = true;

                    updateModel(this.search.id, {

                        // data...

                    }).then( res => {

                        this.$emit('submit', res);

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