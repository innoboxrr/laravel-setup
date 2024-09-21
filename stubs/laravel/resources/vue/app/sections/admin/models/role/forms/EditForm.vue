<template>
    <form :id="formId" @submit.prevent="onSubmit">

        <translation-button-for-edit-form 
            @changeLanguage="setLang" />
            
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
            v-model="role.name" />

        <button-component
            :custom-class="buttonClass"
            :disabled="disabled"
            :value="__('Update')" />
    </form>
</template>

<script>
    import { showModel, updateModel } from '@models/role'
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
                default: 'editRoleForm',
            },
            roleId: {
                type: [Number, String],
                required: true,
            },
            defaultLang: {
                type: String,
                default: null
            },
        },
        emits: ['submit'],
        data() {
            return {
                role: {
                    name: '',
                    // Not including slug as it's not updatable
                },
                lang: this.defaultLang,
                disabled: false,
                JSValidator: undefined,
            }
        },
        mounted() {
            this.fetchRole();
            this.JSValidator = new JSValidator(this.formId).init();
            this.JSValidator.status = true;
        },
        methods: {
            setLang(lang) {
                this.lang = lang;
                this.fetchRole();
            },
            async fetchRole() {
                let role = await showModel(this.roleId, [], [], { lang: this.lang });
                this.role = this.translateModel(role);
            },
            onSubmit() {
                if(this.JSValidator.status) {
                    this.disabled = true;
                    updateModel(this.role.id, {
                        name: this.role.name,
                        lang: this.lang
                    }).then(res => {
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
