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
            v-model="user.name" />

        <!-- EMAIL INPUT -->
        <text-input-component
            :custom-class="inputClass"
            type="email"
            name="email"
            label="Email"
            placeholder="Email"
            validators="required email"
            v-model="user.email" />

        <!-- DOB INPUT -->
        <text-input-component
            :custom-class="inputClass"
            type="date"
            name="dob"
            label="Fecha de Nacimiento"
            validators="required date"
            v-model="user.payload.dob" />

        <!-- STATUS INPUT -->
        <select-input-component
            v-if="$store.getters['authPages/isAdmin']"
            :custom-class="inputClass"
            name="status"
            label="Estado"
            validators="required"
            v-model="user.payload.status">
            <option value="">Seleccione un estado</option>
            <option :value="'active'">Activo</option>
            <option :value="'inactive'">Inactivo</option>
            <option :value="'blocked'">Bloqueado</option>
        </select-input-component>

        <p class="text-sm text-gray-500 mb-4 text-right">* Campos obligatorios</p>

        <button-component
            :custom-class="buttonClass"
            :disabled="disabled"
            value="Actualizar" />
    </form>
</template>

<script>
    import { showModel, updateModel } from '@models/user'
    import JSValidator from 'innoboxrr-js-validator'
    import {
        TextInputComponent,
        SelectInputComponent,
        ButtonComponent
    } from 'innoboxrr-form-elements'

    export default {
        components: {
            TextInputComponent,
            SelectInputComponent,
            ButtonComponent
        },
        props: {
            formId: {
                type: String,
                default: 'editUserForm'
            },
            userId: {
                type: [Number, String],
                required: true
            }
        },
        emits: ['submit'],
        data() {
            return {
                user: {
                    name: '',
                    email: '',
                    password: '',
                    country_id: null,
                    payload: {
                        dob: '',
                        status: ''
                    }
                },
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
                    this.user = res.data;
                    // Aquí se mapean los campos adicionales
                    if (!this.user.payload) {
                        this.user.payload = {
                            dob: '',
                            status: 'active'
                        };
                    }
                });
            },
            onSubmit() {
                if (this.JSValidator.status) {
                    this.disabled = true;
                    updateModel(this.user.id, {
                        name: this.user.name,
                        email: this.user.email,
                        password: this.user.password,
                        country_id: this.user.country_id,
                        dob: this.user.payload.dob,
                        status: this.user.payload.status
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
