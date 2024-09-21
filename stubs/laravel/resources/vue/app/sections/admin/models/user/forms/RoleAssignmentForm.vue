<template>
	
	<form :id="formId" @submit.prevent="onSubmit">

        <!-- COURSE_ID INPUT -->
        <model-search-input-component 
            custom-class=""
            :label-str="__('Role')"
            :placeholder-str="__('Search role by name')"
            :route="roleRoute"
            q="name"
            :get-option-label="option => `${option.name}`"
            :no-options-text="__('No roles found')"
            @submit="setRole" /> 

        <button-component
            :custom-class="buttonClass"
            :disabled="disabled"
            :value="__('Assign Role')" />
        
    </form>

</template>

<script>

    import { showModel, assignRole} from '@models/user'
    import JSValidator from 'innoboxrr-js-validator'
    import {
        ModelSearchInputComponent,
        ButtonComponent,
    } from 'innoboxrr-form-elements'
    
	
	export default {

        components: {
            ModelSearchInputComponent,
            ButtonComponent,
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
            refUser: {
                type: Object,
                required: false,
                default: null,
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
                roleRoute: route('api.role.index') + '?loader=false',
                role_id: null,
                disabled: false,
                JSValidator: undefined,
            }
        },

        methods: {

            fetchData() {
                this.fetchUser();
            },

            setRole(roleId) {
                this.role_id = roleId;
            },

            fetchUser() {
                if (this.refUser != null) {
                    this.user = this.translateModel(this.refUser);
                } else {
                    showModel(this.userId, [], [], { lang: this.lang })
                        .then((res) => {
                            this.user = this.translateModel(res); // Assuming showModel directly returns the user object
                        })
                        .catch((error) => {
                            // Handle error
                        });
                }
            },

            onSubmit() {
                if(this.JSValidator.status) {
                    this.disabled = true;
                    assignRole(this.user.id, this.role_id).then( res => {
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