<template>
    <form :id="formId" @submit.prevent="onSubmit">
        <translation-button-for-edit-form 
            @changeLanguage="setLang" />
            
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
            v-model="option.name" />

        <!-- KEY INPUT -->
        <text-input-component
            :custom-class="inputClass"
            type="text"
            name="key"
            :label="__('Key value')"
            :placeholder="__('Wire the key value here...')"
            validators="required"
            v-model="option.key" />

        <!-- VALUE INPUT -->
        <code-mirror-component
            :label="__('Value')"
            :placeholder="__('Write the value here...')"
            v-model="option.value" />

        <button-component
            :custom-class="buttonClass"
            :disabled="disabled"
            :value="__('Update')" />
    </form>
</template>

<script>
    import { showModel, updateModel } from '@models/option';
    import JSValidator from 'innoboxrr-js-validator';
    import {
        TextInputComponent,
        CodeMirrorComponent,
        ButtonComponent
    } from 'innoboxrr-form-elements';
    import { slugify } from 'innoboxrr-js-libs/libs/string.js';

    export default {
        components: {
            TextInputComponent,
            CodeMirrorComponent,
            ButtonComponent,
        },

        props: {
            formId: {
                type: String,
                default: 'editOptionForm'
            },
            optionId: {
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
                option: {
                    name: '',
                    key: '',
                    value: '',
                },
                lang: this.defaultLang,
                disabled: false,
                JSValidator: undefined,
            }
        },

        watch: {
            'option.key': function (val) {
                this.option.key = slugify(val, '_');
            }
        },

        methods: {
            setLang(lang) {
                this.lang = lang;
                this.fetchOption();
            },
            fetchData() {
                this.fetchOption();
            },
            fetchOption() {
                showModel(this.optionId, [], [], { lang: this.lang }).then(res => {
                    this.option = this.translateModel(res);
                    this.formatValue();
                });
            },
            isJSON(value) {
                try {
                    JSON.parse(value);
                    return true;
                } catch (e) {
                    return false;
                }
            },

            formatValue() {
                if (this.isJSON(this.option.value)) {
                    let parsedValue = JSON.parse(this.option.value);
                    this.option.value = JSON.stringify(parsedValue, null, 4); // Formatear con 4 espacios
                }
            },

            onSubmit() {
                if (this.JSValidator.status) {
                    this.disabled = true;

                    if (this.isJSON(this.option.value)) {
                        let parsedValue = JSON.parse(this.option.value);
                        this.option.value = JSON.stringify(parsedValue); // Convertir a JSON string antes de enviar
                    }

                    updateModel(this.option.id, {
                        name: this.option.name,
                        key: this.option.key,
                        value: this.option.value,
                        lang: this.lang
                    }).then(res => {
                        this.$emit('submit', res);
                        this.alert('success');
                        setTimeout(() => { this.disabled = false; }, 2500);
                    }).catch(error => {
                        this.disabled = false;
                        if (error.response.status == 422)
                            this.JSValidator.appendExternalErrors(error.response.data.errors);
                    });
                } else {
                    this.disabled = false;
                }
            }
        }
    }
</script>
