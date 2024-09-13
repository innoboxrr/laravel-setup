<template>
    <form :id="formId" @submit.prevent="onSubmit">

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

        <text-input-component
            :custom-class="inputClass"
            type="text"
            name="surname"
            :label="__('Surname')"
            :placeholder="__('Surname')"
            validators="required length"
            min_length="3"
            max_length="130"
            v-model="surname" />

        <!-- EMAIL INPUT -->
        <text-input-component
            :custom-class="inputClass"
            type="email"
            name="email"
            :label="__('Email')"
            :placeholder="__('Email')"
            validators="required email"
            v-model="email" />

        <!-- PASSWORD INPUT -->
        <text-input-component
            :custom-class="inputClass"
            type="password"
            name="password"
            :label="__('Password')"
            :placeholder="__('Password')"
            validators="required"
            v-model="password" />

        <!-- DOB INPUT -->
        <text-input-component
            :custom-class="inputClass"
            type="date"
            name="dob"
            :label="__('Date of birth')"
            :placeholder="__('Date of birth')"
            validators="date"
            v-model="dob" />

        <select-input-component
            :custom-class="inputClass"
            name="visibility"
            :label="__('Visibility')"
            :validators="'required'"
            v-model="visibility">
            <option value="public">{{ __('Public') }}</option>
            <option value="private">{{ __('Private') }}</option>
        </select-input-component>

        <select-input-component
            :custom-class="inputClass"
            name="blocked"
            :label="__('Bloqued')"
            :validators="'required'"
            v-model="blocked">
            <option :value="0">{{ __('No') }}</option>
            <option :value="1">{{ __('Yes') }}</option>
        </select-input-component>

        <model-search-input-component 
            custom-class=""
            :label-str="__('Country')"
            :placeholder-str="__('Search country')"
            :route="countryRoute"
            q="global"
            :get-option-label="option => `${option.name} (Código: ${option.iso})`"
            :no-options-text="__('No countries found')"
            @submit="setCountry" /> 

        <p class="text-sm text-gray-500 mb-4 text-right dark:text-gray-200">* {{ __('Mandatory fields') }}</p>

        <button-component
            :custom-class="buttonClass"
            :disabled="disabled"
            :value="__('Create user')" />
    </form>
</template>

<script>
    import { createModel } from '@models/user'
    import JSValidator from 'innoboxrr-js-validator'
    import {
        TextInputComponent,
        ButtonComponent,
        ModelSearchInputComponent
    } from 'innoboxrr-form-elements'

    export default {
        components: {
            TextInputComponent,
            ButtonComponent,
            ModelSearchInputComponent,
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
                visibility: 'public',
                blocked: 0,
                disabled: false,
                JSValidator: undefined,
                countryRoute: route('api.country.index') + '?loader=false',
            }
        },
        mounted() {
            this.JSValidator = new JSValidator(this.formId).init();
        },
        methods: {
            setCountry(countryId) {
                this.country_id = countryId;
            },
            onSubmit() {
                if (this.JSValidator.status) {
                    this.disabled = true;
                    createModel({
                        name: this.name,
                        surname: this.surname,
                        email: this.email,
                        password: this.password,
                        dob: this.dob,
                        visibility: this.visibility,
                        blocked: this.blocked,
                        country_id: this.country_id,
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
