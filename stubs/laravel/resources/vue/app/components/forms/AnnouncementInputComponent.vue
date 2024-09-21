<!-- SimpleInputComponent.vue -->
<template>
    <div class="mt-4">
        <text-input-component
            :custom-class="inputClass"
            type="text"
            name="title"
            :help="__('Announcement is intended to be displayed on the homepage, and it is a good way to communicate something important to the users.')"
            :label="__('Announcement title')"
            :placeholder="__('Here goes the announcement title')"
            v-model="inputData.title"
        />
        <editor-input-component
            :id="`announcement-content-editor`"
            :file="true"
            :uploadUrl="fileUploadUrl"
            :on-file-upload-success="handleFileUploadSuccess"
            name="content"
            :label="__('Announcement content')"
            :placeholder="__('Announcement Content')"
            :height="300"
            v-model="inputData.content"
        />
    </div>
</template>

<script>
    import { TextInputComponent, EditorInputComponent } from 'innoboxrr-form-elements';

    export default {
        components: {
            TextInputComponent,
            EditorInputComponent,
        },
        props: {
            modelValue: {
                type: Object,
                required: true
            },
        },
        computed: {
            inputData: {
                get() {
                    return this.modelValue;
                },
                set(value) {
                    this.$emit('update:modelValue', value);
                }
            }
        }
    };
</script>
