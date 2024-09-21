<template>
    <modal-component
        ref="modalRef" 
        id="createDirectoryModal"
        :open="modalStatus"
        @close="modalClosed"
        title="Create Directory"
        :large-modal="false">
        <template v-slot:body>
            <div class="p-4">
                <create-directory-form />
            </div>
        </template>
    </modal-component>
</template>

<script>
    import CreateDirectoryForm from '../forms/CreateDirectoryForm.vue';
    export default {
        components: {
            CreateDirectoryForm
        },
        computed: {
            modalStatus: {
                get() {
                    return this.$store.state.fileManagerStore.createDirectoryModalOpen;
                },
                set(value) {
                    this.$store.state.fileManagerStore.createDirectoryModalOpen = value;
                }
            }
        },
        methods: {
            modalClosed() {
                this.$store.state.fileManagerStore.createDirectoryModalOpen = false;
            },
            closeModal() {
                this.$refs.modalRef.closeModal();
            },
        }
    }
</script>