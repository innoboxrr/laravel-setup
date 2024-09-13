<template>
    <div class="uk-margin">
        <div class="uk-inline uk-width-1-1">
            <label class=" ml-2 text-sm font-medium text-gray-900 dark:text-white">
				<span v-if="help" class="cursor-pointer">
					<i :uk-tooltip="`title: ${help}`" class="fa-solid fa-circle-question"></i>
				</span>
				{{ label }}
			</label>
            <div class="absolute inset-y-0 start-0 top-5 flex items-center ps-3.5 pointer-events-none">
                <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z"/>
                </svg>
            </div>
            <input 
                ref="datepicker"
                datepicker 
                type="text" 
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" 
                placeholder="Select date"
                v-model="value">
        </div>
    </div>
</template>
<script>
    import Datepicker from 'flowbite-datepicker/Datepicker';
    export default {
        name: 'FlowbiteDatepicker',
        props: {
            label: {
				type: String,
				required: false,
				default: ''
			},
			help: {
				type: String,
				required: false,
				default: null
			},
            modelValue: {
				default: ""
			}
        },

        emits: ['update:modelValue'],

        mounted() {
            new Datepicker(this.$refs.datepicker, {
                // options
            }); 
        },

        computed: {
            value: {
                get() {
                    return this.modelValue;
                },
                set(value) {
                    this.$emit('update:modelValue', value);
                }
            }
        }
    }
</script>