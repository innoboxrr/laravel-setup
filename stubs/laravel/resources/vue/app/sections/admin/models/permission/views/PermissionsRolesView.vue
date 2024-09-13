<template>
    <permission-role-assignment-table  
        type="system"
        @permissionToggled="onPermissionToggled" />
</template>

<script>
    import { assignRole, deallocateRole } from '@models/permission';
    import PermissionRoleAssignmentTable from '@models/permission/widgets/PermissionRoleAssignmentTable.vue';
    export default {
        components: {
            PermissionRoleAssignmentTable
        },
        methods: {
            onPermissionToggled(data) {
                if(data.value){
                    assignRole(data.permission, data.role);
                } else {
                    deallocateRole(data.permission, data.role);
                }
            }
        }
    }
</script>