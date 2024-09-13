<template>

    <form :id="formId" @submit.prevent="onSubmit">

        <!-- PASSWORD INPUT -->
        <text-input-component
            :custom-class="inputClass"
            type="password"
            name="password"
            :label="__('Passsword')"
            :placeholder="__('Enter your password')"
            validators="required"
            v-model="password" />

        <button-component
            :custom-class="buttonClass"
            :disabled="disabled"
            value="Logout other sessions" />
    </form>
</template>

<script>
    import { showModel, logoutOtherDevices } from '@models/user'
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
                default: 'logoutOtherDevicesForm'
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
                password: '',
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
                    logoutOtherDevices(this.user.id, this.password).then(res => {
                        this.$emit('submit', res);
                        setTimeout(() => { this.disabled = false; }, 2500);
                    }).catch(error => {
                        this.disabled = false;
                        if (error?.response?.status == 422)
                            this.JSValidator.appendExternalErrors(error.response.data.errors);
                        this.alert('error');
                    });
                } else {
                    this.disabled = false;
                }
            }
        }
    }
</script>
