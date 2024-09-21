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

        <!-- SLUG INPUT -->
        <text-input-component
            :custom-class="inputClass"
            type="text"
            name="slug"
            :label="__('Slug')"
            :placeholder="__('Slug')"
            validators="required length"
            min_length="3"
            max_length="130"
            v-model="slug" />
        
        <button-component
            :custom-class="buttonClass"
            :disabled="disabled"
            :value="__('Create')" />
    </form>
</template>

<script>
    import { createModel } from '@models/role'
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
                default: 'createRoleForm',
            }
        },
        emits: ['submit'],
        data() {
            return {
                name: '',
                slug: '',
                disabled: false,
                JSValidator: undefined,
            }
        },
        mounted() {
            this.JSValidator = new JSValidator(this.formId).init();
        },
        methods: {
            onSubmit() {
                if(this.JSValidator.status) {
                    this.disabled = true;
                    createModel({
                        name: this.name,
                        slug: this.slug,
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
