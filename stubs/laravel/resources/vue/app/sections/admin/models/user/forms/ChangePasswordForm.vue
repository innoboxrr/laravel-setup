<template>

    <form :id="formId" @submit.prevent="onSubmit">

        <!-- PASSWORD INPUT -->
        <text-input-component
            :custom-class="inputClass"
            type="password"
            name="old_password"
            label="Contraseña actual"
            placeholder="Contraseña"
            validators="required"
            v-model="old_password" />

        <!-- PASSWORD INPUT -->
        <text-input-component
            :custom-class="inputClass"
            type="password"
            name="password"
            label="Nueva contraseña"
            placeholder="Nueva contraseña"
            validators="required"
            v-model="password" />

        <!-- PASSWORD INPUT -->
        <text-input-component
            :custom-class="inputClass"
            type="password"
            name="password_confirmation"
            label="Confirmar contraseña"
            placeholder="Confirmar contraseña"
            validators="required"
            v-model="password_confirmation" />

        <button-component
            :custom-class="buttonClass"
            :disabled="disabled"
            value="Cambiar contraseña" />
    </form>
</template>

<script>
    import { showModel, updatePassword } from '@models/user'
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
                default: 'changePasswordForm'
            },
            userId: {
                type: [Number, String],
                required: true
            }
        },
        emits: ['submit'],
        data() {
            return {
                user: {},
                old_password: '',
                password: '',
                password_confirmation: '',
                disabled: false,
                JSValidator: undefined,
            }
        },
        mounted() {
            this.fetchUser();
            this.JSValidator = new JSValidator(this.formId).init();
            this.JSValidator.status = true;
        },
        methods: {
            fetchUser() {
                showModel(this.userId).then(res => {
                    this.user = res;
                    // Aquí se mapean los campos adicionales
                });
            },
            onSubmit() {
                if (this.JSValidator.status) {
                    this.disabled = true;
                    updatePassword(this.user.id, {
                        old_password: this.old_password,
                        password: this.password,
                        password_confirmation: this.password_confirmation
                    }).then(res => {
                        this.$emit('submit', res);
                        this.alert('success');
                        setTimeout(() => { this.disabled = false; }, 2500);
                    }).catch(error => {
                        this.disabled = false;
                        if (error?.response?.status == 422)
                            this.JSValidator.appendExternalErrors(error.response.data.errors);
                    });
                } else {
                    this.disabled = false;
                }
            }
        }
    }
</script>
