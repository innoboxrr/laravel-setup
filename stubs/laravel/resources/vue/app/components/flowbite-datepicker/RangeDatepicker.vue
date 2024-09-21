<template>
    <div class="uk-margin">
        <div class="uk-inline uk-width-1-1">
            <label class=" ml-2 text-sm font-medium text-gray-900 dark:text-white">
				<span v-if="help" class="cursor-pointer">
					<i :uk-tooltip="`title: ${help}`" class="fa-solid fa-circle-question"></i>
				</span>
				{{ label }}
			</label>
            
            <div 
                ref="dateRangeDatepicker" 
                date-rangepicker 
                class="flex items-center"
                ate-rangepicker-format="dd/mm/yyyy">
                <div class="relative">
                    <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                        <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z"/>
                        </svg>
                    </div>
                    <input 
                        name="start" 
                        type="text" 
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" 
                        placeholder="Select date start"
                        v-model="start_date">
                </div>
                <span class="mx-4 text-gray-500">{{ __('to') }}</span>
                <div class="relative">
                    <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                        <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z"/>
                        </svg>
                    </div>
                    <input 
                        name="end" 
                        type="text" 
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" 
                        placeholder="Select date end"
                        v-model="end_date">
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    import DateRangePicker from 'flowbite-datepicker/DateRangePicker';
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
                type: Object,
                default: () => ({ start_date: '', end_date: '' })
            }
        },

        emits: ['update:modelValue'],

        mounted() {
            new DateRangePicker(this.$refs.dateRangeDatepicker, {
                // options
            }); 
        },
        computed: {
            start_date: {
                get() {
                    console.log('Getting  start_date');
                    return this.modelValue.start_date;
                },
                set(value) {
                    console.log('Updating start_date');
                    this.$emit('update:modelValue', { ...this.modelValue, start_date: value });
                }
            },
            end_date: {
                get() {
                    return this.modelValue.end_date;
                },
                set(value) {
                    this.$emit('update:modelValue', { ...this.modelValue, end_date: value });
                }
            }
        }
    }
</script>