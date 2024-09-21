<template>
	
	<form :id="formId" @submit.prevent="onSubmit">      

        <!-- NAME INPUT -->
        <text-input-component
            :custom-class="inputClass"
            type="text"
            name="name"
            :label="__('Option name')"
            :placeholder="__('Option name')"
            validators="required length"
            min_length="3"
            max_length="130"
            v-model="name" />

        <!-- NAME INPUT -->
        <text-input-component
            :custom-class="inputClass"
            type="text"
            name="key"
            :label="__('Key value')"
            :placeholder="__('Wire the key value here...')"
            validators="required"
            v-model="key" />

        <!-- NAME INPUT -->
        <code-mirror-component
            :placeholder="__('Write the value here. You can use HTML or JSON format')"
            v-model="value" />
         
        <button-component
            :custom-class="buttonClass"
            :disabled="disabled"
            :value="__('Create')" />
        
    </form>

</template>

<script>

    import { createModel } from '@models/option'
    import JSValidator from 'innoboxrr-js-validator'
    import {
        TextInputComponent,
        CodeMirrorComponent,
        ButtonComponent
    } from 'innoboxrr-form-elements'
    import { slugify } from 'innoboxrr-js-libs/libs/string.js'
	
	export default {

        components: {
            TextInputComponent,
            CodeMirrorComponent,
            ButtonComponent,
        },

        props: {

        	formId: {
        		type: String,
        		default: 'createOptionForm',
        	}

        },

        emits: ['submit'],

        data() {
            return {
                name: '',
                key: '',
                value: '',
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
            key: function (val) {
                this.key = slugify(val, '_');
            }
        },

        methods: {

            fetchData() {},

            onSubmit() {
                if(this.JSValidator.status) {
                    this.disabled = true;
                    createModel({
                        name: this.name,
                        key: this.key,
                        value: this.value,
                    }).then( res => {
                        this.$emit('submit', res);
                        this.alert('success');
                        setTimeout(() => { this.disabled = false; }, 2500);
                    }).catch(error => {
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