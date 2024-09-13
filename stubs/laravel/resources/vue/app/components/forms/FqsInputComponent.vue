<!-- FqsInputComponent.vue -->
<template>
    <div>
        <label class="block mb-4 ml-2 text-sm font-medium text-gray-900 dark:text-white">
            {{ __('Add frequency asked questions') }}
        </label> 
        <div 
            v-for="(fq, index) in fqs" 
            :key="index" 
            class="mb-4 relative">
            <text-input-component
            :custom-class="inputClass"
                type="text"
                :name="`question-${index}`"
                :label="__('Question')"
                :placeholder="__('Question')"
                validators="required length"
                min_length="3"
                max_length="130"
                v-model="fq.question"
            />
            <editor-input-component
                :key="`answer-${index}`"
                :id="`answer-${index}`"
                :file="true"
                :uploadUrl="fileUploadUrl"
                :on-file-upload-success="handleFileUploadSuccess"
                :name="`answer-${index}`"
                :label="__('Answer')"
                :placeholder="__('Answer')"
                :height="200"
                validators="required"
                v-model="fq.answer"
            />
            <button 
                v-if="fqs.length - 1 === index"
                @click.prevent="removeFq(index)" 
                class="absolute -bottom-12 right-0 inline-flex items-center gap-x-1.5 rounded-md bg-red-600 px-2.5 py-1.5 text-sm font-semibold text-white shadow-sm hover:bg-red-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-red-600">
                {{ __('Remove question') }}
            </button>
        </div>
        <button 
            @click.prevent="addFq" 
            class="inline-flex items-center gap-x-1.5 rounded-md bg-indigo-600 px-2.5 py-1.5 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
            {{ __('Add Question') }}
        </button>
    </div>
</template>

<script>
    import {
        TextInputComponent,
        EditorInputComponent,
    } from "innoboxrr-form-elements";
    export default {
        components: {
            TextInputComponent,
            EditorInputComponent,
        },
        props: {
            modelValue: {
                type: Array,
                required: true
            },
        },
        computed: {
            fqs: {
                get() {
                    return this.modelValue;
                },
                set(value) {
                    this.$emit('update:modelValue', value);
                }
            }
        },
        methods: {
            addFq() {
                this.fqs.push({ question: '', answer: '' });
            },
            removeFq(index) {
                this.fqs.splice(index, 1);
            },
        }
    };
</script>