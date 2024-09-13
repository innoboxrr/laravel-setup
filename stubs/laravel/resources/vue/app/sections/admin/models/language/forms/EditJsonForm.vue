<template>
	
	<form :id="formId" @submit.prevent="onSubmit">

        <!-- NAME INPUT -->
        <code-mirror-component
            :placeholder="__('JSON editor...')"
            lang="json"
            v-model="json" />

        <button-component
            :custom-class="buttonClass"
            :disabled="disabled"
            :value="__('Update JSON')" />
        
    </form>

</template>

<script>

    import { getJson, updateJson} from '@models/language'
    import JSValidator from 'innoboxrr-js-validator'
    import {
        CodeMirrorComponent,
        ButtonComponent
    } from 'innoboxrr-form-elements'
    
	
	export default {

        components: {
            CodeMirrorComponent,
            ButtonComponent,
        },

        props: {
            formId: {
                type: String,
                default: 'editLanguageJsonForm'
            },
            languageId: {
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
                json: '',
                // ...
                lang: this.defaultLang,
                disabled: false,
                JSValidator: undefined,
            }
        },

        methods: {

            fetchData() {
                this.getJson();
            },

            async getJson() {
                let res = await getJson(this.languageId);
                if(res.status == 'success') {
                    // Convert JSON to string
                    this.json = JSON.stringify(res.json, null, 4);
                }
            },

            onSubmit() {
                if(this.JSValidator.status) {
                    this.disabled = true;
                    updateJson(this.languageId, {
                        json: this.json
                    }).then( res => {
                        this.$emit('submit', res);
                        this.alert('success');
                        setTimeout(() => { this.disabled = false; }, 2500);
                    }).catch(error => {
                        this.disabled = false;
                        if(error.response.status == 422) {
                            this.alert('error', {timer: 5000}, error.response.data.message);
                        }
                    });
                } else {
                    this.disabled = false;
                }
            }
        }
	}
</script>