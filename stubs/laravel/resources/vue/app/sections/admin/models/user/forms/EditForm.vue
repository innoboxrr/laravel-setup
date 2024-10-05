<template>
    <form :id="formId" @submit.prevent="onSubmit">

        <avatar-input-component 
            :avatar-url="user.avatar_url" 
            :upload-url="fileUploadUrl" 
            @upload="handleAvatarUpload"  />

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
            v-model="user.name" />

        <!-- SURNAME INPUT -->
        <text-input-component
            :custom-class="inputClass"
            type="text"
            name="surname"
            :label="__('Surname')"
            :placeholder="__('Surname')"
            validators="required length"
            min_length="3"
            max_length="130"
            v-model="user.surname" />

        <!-- EMAIL INPUT -->
        <text-input-component
            :custom-class="inputClass"
            type="email"
            name="email"
            :label="__('Email')"
            :placeholder="__('Email')"
            validators="required email"
            v-model="user.email" />

        <!-- DOB INPUT -->
        <text-input-component
            :custom-class="inputClass"
            type="date"
            name="dob"
            :label="__('Date of birth')"
            :placeholder="__('Date of birth')"
            validators="required date"
            v-model="user.dob" />

        <select-input-component
            :custom-class="inputClass"
            name="visibility"
            :label="__('Visibility')"
            :validators="'required'"
            v-model="user.payload.visibility">
            <option value="public">{{ __('Public') }}</option>
            <option value="private">{{ __('Private') }}</option>
        </select-input-component>

        <select-input-component
            v-if="$store.getters['authPages/isAdmin']"
            :custom-class="inputClass"
            name="blocked"
            :label="__('Bloqued')"
            :validators="'required'"
            v-model="user.payload.blocked">
            <option :value="0">{{ __('No') }}</option>
            <option :value="1">{{ __('Yes') }}</option>
        </select-input-component>

        <!-- COUNTRY INPUT -->
        <div v-if="showCountrySearchInput">
            <model-search-input-component 
                custom-class=""
                :label-str="__('Country')"
                :placeholder-str="__('Search country')"
                :route="countryRoute"
                q="global"
                :get-option-label="option => `${option.name} (${option.iso})`"
                :no-options-text="__('No countries found')"
                @submit="setCountry" /> 
            <p 
                v-if="countryName" 
                class="text-xs text-gray-300"
                @click="toggleCountrySearchInput"
                style="cursor: pointer; margin-top: -10px; margin-bottom: 10px">
                {{ __('Cancel country change') }}
            </p>
        </div>
        <text-input-component
            v-else
            :custom-class="inputClass"
            type="text"
            name="country"
            :label="__('Country of residence')"
            :placeholder="__('Country')"
            :help="__('Click on the field to change the country of residence')"
            validators="required length"
            min_length="3"
            max_length="130"
            :readonly="true"
            v-model="countryName"
            @click="toggleCountrySearchInput" />

        <hr class="my-4" />

        <!-- EMAIL INPUT -->
        <text-input-component
            v-if="can('updatePassword')"
            :custom-class="inputClass"
            type="text"
            name="password"
            :label="__('Fill in to change password')"
            :placeholder="__('Leave empty to keep the same password')"
            v-model="user.password" />

        <p class="text-sm text-gray-500 mb-4 text-right dark:text-gray-200">* {{ __('Mandatory fields') }}</p>

        <button-component
            :custom-class="buttonClass"
            :disabled="disabled"
            :value="__('Update')" />
    </form>
</template>

<script>
    import { showModel, updateModel } from '@models/user'
    import JSValidator from 'innoboxrr-js-validator'
    import {
        TextInputComponent,
        ButtonComponent,
        ModelSearchInputComponent,
        AvatarInputComponent
    } from 'innoboxrr-form-elements'

    export default {
        components: {
            TextInputComponent,
            ButtonComponent,
            ModelSearchInputComponent,
            AvatarInputComponent
        },
        props: {
            formId: {
                type: String,
                default: 'editUserForm'
            },
            userId: {
                type: [Number, String],
                required: true
            },
            defaultLang: {
                type: String,
                default: null
            },
        },
        emits: ['submit'],
        data() {
            return {
                user: {
                    name: '',
                    surname: '',
                    email: '',
                    dob: '',
                    country_id: null,
                    payload: {
                        visibility: '',
                        blocked: '',
                    }
                },
                avatar: '',
                lang: this.defaultLang,
                showCountrySearchInput: false,
                countryName: '',
                countryRoute: route('api.country.index') + '?loader=false',
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
                showModel(this.userId, ['country'], [], { lang: this.lang }).then(res => {
                    this.user = this.translateModel(res);
                    this.user.payload = this.user?.payload ?? { visibility: 'public', blocked: 0 };
                    this.countryName = this.user.country ? this.user.country.name : '';
                });
            },
            setCountry(country) {
                this.user.country_id = country;
            },
            toggleCountrySearchInput() {
                this.showCountrySearchInput = !this.showCountrySearchInput;
            },
            handleAvatarUpload(response) {
                this.user.avatar_url = response.uri;
                this.avatar = response.uri;
                this.$store.state.authPages.user.avatar_url = response.uri;
                this.onSubmit();
            },
            onSubmit() {
                if (this.JSValidator.status) {
                    this.disabled = true;
                    updateModel(this.user.id, {
                        name: this.user.name,
                        surname: this.user.surname,
                        email: this.user.email,
                        password: this.user.password,
                        dob: this.user.dob,
                        country_id: this.user.country_id,
                        visibility: this.user.payload.visibility,
                        blocked: this.user.payload.blocked,



                        // Meta fields
                        avatar: this.avatar,
                    }).then(res => {
                        this.$emit('submit', res);
                        this.alert('success');
                        setTimeout(() => { this.disabled = false; }, 2500);
                    }).catch(error => {
                        this.disabled = false;
                        console.log(error);
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
