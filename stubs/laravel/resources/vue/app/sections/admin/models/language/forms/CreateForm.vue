<template>
	
	<form :id="formId" @submit.prevent="onSubmit">      

         <!-- NAME INPUT -->
        <text-input-component
            :custom-class="inputClass"
            type="text"
            name="name"
            :label="__('Name')"
            :placeholder="__('Name')"
            validators="required length"
            min_length="3"
            max_length="130"
            v-model="name" />

        <!-- DESCRIPTION INPUT -->
        <text-input-component
            :custom-class="inputClass"
            type="text"
            name="code"
            :label="__('Code')"
            :placeholder="__('Code')"
            validators="required length"
            min_length="2"
            max_length="130"
            v-model="code" />

        <text-input-component
            :custom-class="inputClass"
            type="text"
            name="country_code"
            :label="__('Country code')"
            :placeholder="__('Country code')"
            validators="required length"
            min_length="2"
            max_length="130"
            v-model="country_code" />
         
        <button-component
            :custom-class="buttonClass"
            :disabled="disabled"
            :value="__('Create')" />
        
    </form>

</template>

<script>

    import { createModel } from '@models/language'
    import JSValidator from 'innoboxrr-js-validator'
    import {
        TextInputComponent,
        ButtonComponent
    } from 'innoboxrr-form-elements'
    import { slugify } from 'innoboxrr-js-libs/libs/string.js'
	
	export default {

        components: {
            TextInputComponent,
            ButtonComponent,
        },

        props: {
        	formId: {
        		type: String,
        		default: 'createLanguageForm',
        	}
        },

        emits: ['submit'],

        data() {
            return {
                name: '',
                code: '',
                country_code: '',
                // Set more $data
                disabled: false,
                JSValidator: undefined,
            }
        },

        mounted() {
            this.fetchData();
            this.JSValidator = new JSValidator(this.formId).init();
        },

        watch: {
            code: function (val) {
                this.code = slugify(val, '_');
            }
        },

        methods: {

            fetchData() {},

            onSubmit(event) {

                if(this.JSValidator.status) {
                    this.disabled = true;
                    createModel({
                        name: this.name,
                        code: this.code,
                        country_code: this.country_code,
                    }).then( res => {
                        this.$emit('submit', res);
                        this.alert('success');
                        setTimeout(() => { this.disabled = false; }, 2500);
                    }).catch(error => {
                        console.log(error);
                        this.disabled = false;
                        if(error.response.status == 422)
                            this.JSValidator.appendExternalErrors(error.response.data.errors);
                    });
                } else {
                    this.disabled = false;
                }
            }
        }
	}
</script>