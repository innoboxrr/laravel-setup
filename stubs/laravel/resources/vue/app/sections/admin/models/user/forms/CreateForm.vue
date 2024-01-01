<template>
    <form :id="formId" @submit.prevent="onSubmit">

        <!-- NAME INPUT -->
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

        <!-- EMAIL INPUT -->
        <text-input-component
            :custom-class="inputClass"
            type="email"
            name="email"
            label="Email"
            placeholder="Email"
            validators="required email"
            v-model="email" />

        <!-- PASSWORD INPUT -->
        <text-input-component
            :custom-class="inputClass"
            type="password"
            name="password"
            label="Contraseña"
            placeholder="Contraseña"
            validators="required"
            v-model="password" />

        <!-- DOB INPUT -->
        <text-input-component
            :custom-class="inputClass"
            type="date"
            name="dob"
            label="Fecha de Nacimiento"
            validators="required date"
            v-model="dob" />

        <p class="text-sm text-gray-500 mb-4 text-right">* Campos obligatorios</p>

        <button-component
            :custom-class="buttonClass"
            :disabled="disabled"
            value="Crear" />
    </form>
</template>

<script>
    import { createModel } from '@models/user'
    import JSValidator from 'innoboxrr-js-validator'
    import {
        TextInputComponent,
        ButtonComponent
    } from 'innoboxrr-form-elements'

    export default {
        components: {
            TextInputComponent,
            ButtonComponent
        },
        props: {
            formId: {
                type: String,
                default: 'createUserForm',
            }
        },
        emits: ['submit'],
        data() {
            return {
                name: '',
                email: '',
                password: '',
                country_id: null,
                dob: '',
                status: '',
                disabled: false,
                JSValidator: undefined,
            }
        },
        mounted() {
            this.JSValidator = new JSValidator(this.formId).init();
        },
        methods: {
            onSubmit() {
                if (this.JSValidator.status) {
                    this.disabled = true;
                    createModel({
                        name: this.name,
                        email: this.email,
                        password: this.password,
                        country_id: this.country_id,
                        dob: this.dob,
                        status: this.status
                    }).then(res => {
                        this.$emit('submit', res);
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
