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
            max_length="130"
            v-model="language.name" />
        
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
            v-model="language.code" />

        <text-input-component
            :custom-class="inputClass"
            type="text"
            name="country_code"
            :label="__('Country code')"
            :placeholder="__('Country code')"
            validators="required length"
            min_length="2"
            max_length="130"
            v-model="language.country_code" />

        <button-component
            :custom-class="buttonClass"
            :disabled="disabled"
            :value="__('Update')" />
        
    </form>

</template>

<script>

    import { showModel, updateModel} from '@models/language'
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
                default: 'editLanguageForm'
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
                language: {
                    name: '',
                    code: '',
                    country_code: '',
                },
                // ...
                lang: this.defaultLang,
                disabled: false,
                JSValidator: undefined,
            }
        },

        watch: {
            'language.code': function (val) {
                this.language.code = slugify(val, '_');
            }
        },

        methods: {

            fetchData() {
                this.fetchLanguage();
            },

            fetchLanguage() {
                showModel(this.languageId, [], [], { lang: this.lang }).then( res => {
                    this.language = this.translateModel(res);
                });
            },

            onSubmit() {
                if(this.JSValidator.status) {
                    this.disabled = true;
                    updateModel(this.language.id, {
                        name: this.language.name,
                        code: this.language.code, 
                        country_code: this.language.country_code,
                        lang: this.lang
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