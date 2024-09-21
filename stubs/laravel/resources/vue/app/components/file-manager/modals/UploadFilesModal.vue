<template>
    <modal-component
        ref="modalRef" 
        id="uploadFilesModal"
        :open="modalStatus"
        @close="modalClosed"
        title="Upload Files"
        :large-modal="false">
        <template v-slot:body>
            <div class="p-4">
                <upload-files-form />
            </div>
        </template>
    </modal-component>
</template>

<script>
    import UploadFilesForm from '../forms/UploadFilesForm.vue';
    export default {
        components: {
            UploadFilesForm
        },
        computed: {
            modalStatus: {
                get() {
                    return this.$store.state.fileManagerStore.uploadFilesModalOpen;
                },
                set(value) {
                    this.$store.state.fileManagerStore.uploadFilesModalOpen = value;
                }
            }
        },
        methods: {
            modalClosed() {
                this.$store.state.fileManagerStore.uploadFilesModalOpen = false;
            },
            closeModal() {
                this.$refs.modalRef.closeModal();
            },
        }
    }
</script>