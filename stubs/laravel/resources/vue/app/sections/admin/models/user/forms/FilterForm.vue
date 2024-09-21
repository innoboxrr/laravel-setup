<template>
    <form id="userFilterForm" @submit.prevent="onSubmit">
        <div
            class="uk-flex uk-flex-left uk-child-width-1-4@m uk-child-width-1-1@s"
            uk-grid >
            <div>
                <text-input-component
                    :custom-class="inputClass"
                    type="number"
                    name="id"
                    label="ID"
                    placeholder="ID"
                    v-model="id" />
            </div>

            <div>
                <text-input-component
                    :custom-class="inputClass"
                    type="email"
                    name="email"
                    label="Email"
                    placeholder="Email"
                    v-model="email" />
            </div>

            <div>
                <text-input-component
                    :custom-class="inputClass"
                    type="text"
                    name="name"
                    :label="__('Name')"
                    :placeholder="__('Name')"
                    v-model="name" />
            </div>

            <div>
                <text-input-component
                    :custom-class="inputClass"
                    type="text"
                    name="surname"
                    :label="__('Surname')"
                    :placeholder="__('Surname')"
                    v-model="surname" />
            </div>

            <div>
                <text-input-component
                    :custom-class="inputClass"
                    type="date"
                    name="dob"
                    :label="__('Day of birth')"
                    :placeholder="__('Day of birth')"
                    v-model="dob" />
            </div>

            <div>
                <text-input-component
                    :custom-class="inputClass"
                    type="number"
                    name="country_id"
                    :label="__('Country ID')"
                    :placeholder="__('Country ID')"
                    v-model="country_id" />
            </div>
            <!-- Add more inputs -->
        </div>

        <div
            class="uk-flex uk-flex-right uk-child-width-auto@m uk-child-width-1-1@m"
            uk-grid >
            <div>
                <button :class="buttonClass">
					{{  __('Search') }}
				</button>
            </div>

            <div>
                <button
                    :class="buttonClass + ' bg-gray-400'"
                    @click.prevent="resetForm()" >
                    Reiniciar
                </button>
            </div>
        </div>
    </form>
</template>

<script>
import { TextInputComponent } from "innoboxrr-form-elements";

export default {
    components: {
        TextInputComponent,
    },

    emits: ["submit"],

    data() {
        return {
            id: null,
			email: null,
            name: null,
            surname: null,
            dob: null,
            country_id: null,
            // Add more inputs names
        };
    },

    methods: {
        onSubmit() {
            this.$emit("submit", this.$data);
        },

        resetForm() {
            this.id = null;
			this.email = null;
            this.name = null;
            this.surname = null;
            this.dob = null;
            this.country_id = null;
            // Reset inputs
            this.onSubmit();
        },
    },
};
</script>
