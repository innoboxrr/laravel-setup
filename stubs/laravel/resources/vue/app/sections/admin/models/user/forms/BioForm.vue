<template>
    <form 
        :id="formId" 
        @submit.prevent="onSubmit">

        <!-- SALUDO -->
        <select-input-component
            :custom-class="inputClass"
            name="salutation"
            :label="__('Salutation')"
            :validators="'required'"
            v-model="user.payload.salutation">
            <option value="">{{ __('Select') }}</option>
            <option value="mr">{{ __('Mr.') }}</option>
            <option value="mrs">{{ __('Mrs.') }}</option>
            <option value="ms">{{ __('Ms.') }}</option>
            <option value="dr">{{ __('Dr.') }}</option>
        </select-input-component>

        <!-- NAME INPUT -->
        <text-input-component
            :custom-class="inputClass"
            type="text"
            name="position"
            :label="__('Position')"
            :placeholder="__('Eg. Software Engineer')"
            validators="required length"
            min_length="3"
            max_length="130"
            v-model="user.payload.position" />

        <!-- DESCRIPTION EDITOR -->
        <editor-input-component
            id="edit-course-editor-description"
            :file="true"
            :uploadUrl="fileUploadUrl"
            :on-file-upload-success="handleFileUploadSuccess"
            name="description"
            :height="300"
            :label="__('Bio')"
            :placeholder="__('Write a short bio about yourself')"
            validators="required"
            v-model="user.payload.bio_about"
        />


        <tags-input-component
            :custom-class="inputClass"
            name="skills"
            :placeholder="__('Add skills')"
            :label="__('Skills')"
            :validators="'required'"
            v-model="user.payload.bio_skills" />

        <dynamic-group-input-component 
            :label="__('Education')"
            v-model="user.payload.bio_education"
            :has-sufix="false"
            :add-button-label="__('Add Education')"
            :remove-button-label="__('Remove')"
            :inputs-config="[{
                key: 'entry',
                type: 'text',
                attributes: {
                    type: 'number',
                    name: 'entry',
                    label: this.__('Entry year'),
                    placeholder: '2019',
                    customClass: inputClass,
                }
            },{
                key: 'graduation',
                type: 'text',
                attributes: {
                    type: 'number',
                    name: 'graduation',
                    label: this.__('Graduation year'),
                    placeholder: this.__('Empty if you are still studying'),
                    customClass: inputClass
                }
            },{
                key: 'institution',
                type: 'text',
                attributes: {
                    name: 'institution',
                    label: this.__('Institution'),
                    placeholder: this.__('Eg. Harvard University'),
                    customClass: inputClass
                }
            },{
                key: 'program',
                type: 'text',
                attributes: {
                    type: 'text',
                    name: 'program',
                    label: this.__('Program'),
                    placeholder: this.__('Eg. Computer Science'),
                    customClass: inputClass
                }
            },{
                key: 'description',
                type: 'textarea',
                attributes: {
                    rows: 3,
                    name: 'description',
                    label: this.__('Description'),
                    placeholder: this.__('Description'),
                    customClass: inputClass
                }
            }]" 
        />

        <dynamic-group-input-component 
            class="mt-6"
            :label="__('Work Experience')"
            v-model="user.payload.bio_experience"
            :has-sufix="false"
            :add-button-label="__('Add Experience')"
            :remove-button-label="__('Remove')"
            :inputs-config="[{
                key: 'entry',
                type: 'text',
                attributes: {
                    type: 'number',
                    name: 'entry',
                    label: this.__('Entry year'),
                    placeholder: '2019',
                    customClass: inputClass
                }
            },{
                key: 'leaving',
                type: 'text',
                attributes: {
                    type: 'number',
                    name: 'leaving',
                    label: this.__('Leaving year'),
                    placeholder: 'Empty if you are still working',
                    customClass: inputClass
                }
            },{
                key: 'company',
                type: 'text',
                attributes: {
                    type: 'text',
                    name: 'company',
                    label: this.__('Company'),
                    placeholder: this.__('Eg. Google'),
                    customClass: inputClass
                }
            },{
                key: 'position',
                type: 'text',
                attributes: {
                    type: 'text',
                    name: 'position',
                    label: this.__('Position'),
                    placeholder: this.__('Eg. Software Engineer'),
                    customClass: inputClass
                }
            },{
                key: 'description',
                type: 'textarea',
                attributes: {
                    rows: 3,
                    name: 'description',
                    label: this.__('Description'),
                    placeholder: this.__('Description'),
                    customClass: inputClass,
                }
            }]" 
        />

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
    //import TagsInputComponent from '@app/components/forms/TagsInputComponent.vue'
    import { 
        DynamicGroupInputComponent
    }  from "@app/components/forms"
    import {
        TagsInputComponent,
        TextInputComponent,
        EditorInputComponent,
        ButtonComponent,
        ModelSearchInputComponent
    } from 'innoboxrr-form-elements'

    export default {
        components: {
            DynamicGroupInputComponent,

            TagsInputComponent,
            TextInputComponent,
            EditorInputComponent,
            ButtonComponent,
            ModelSearchInputComponent
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
                    payload: {
                        locale: '',
                        timezone: '',
                        dark_mode: 0,
                        visibility: 'public',
                    }
                },
                lang: this.defaultLang,
                disabled: false,
                JSValidator: undefined,
            }
        },
        mounted() {
            this.fetchUser();
            this.JSValidator = new JSValidator(this.formId).init();
        },
        watch: {
            'user.payload.teacher_skills': {
                handler(newValue) {
                    console.log(newValue);
                },
                deep: true
            },
        },
        methods: {
            fetchUser() {
                showModel(this.userId, ['country'], [], { lang: this.lang }).then(res => {
                    this.user = this.translateModel(res);

                    if (this.user.payload.bio_skills == null) {
                        this.user.payload.bio_skills = '';
                    }

                    if (this.user.payload.bio_education == null) {
                        this.user.payload.bio_education = [];
                    } else {
                        // Primero codificar a un objeto y después a un array
                        this.user.payload.bio_education = JSON.parse(this.user.payload.bio_education);

                        this.user.payload.bio_education = this.user.payload.bio_education.map(item => {
                            return {
                                entry: item.entry,
                                graduation: item.graduation,
                                institution: item.institution,
                                program: item.program,
                                description: item.description
                            }
                        });
                    }

                    if (this.user.payload.bio_experience == null) {
                        this.user.payload.bio_experience = [];
                    } else {
                        // Primero codificar a un objeto y después a un array
                        this.user.payload.bio_experience = JSON.parse(this.user.payload.bio_experience);

                        this.user.payload.bio_experience = this.user.payload.bio_experience.map(item => {
                            return {
                                year: item.year,
                                description: item.description
                            }
                        });
                    }
                });
            },
            onSubmit() {
                if (this.JSValidator.status) {
                    this.disabled = true;
                    updateModel(this.user.id, {
                        bio_about: this.user.payload.bio_about,
                        bio_skills: this.user.payload.bio_skills.join(','),
                        bio_education: this.user.payload.bio_education,
                        bio_experience: this.user.payload.bio_experience,
                        visibility: this.user.payload.visibility,
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
