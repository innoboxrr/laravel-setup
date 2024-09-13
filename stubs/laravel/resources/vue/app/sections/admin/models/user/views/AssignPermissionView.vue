<template>
    <permission-role-assignment-table  
        type="user"
        :roles-filter="{
            user_id: $route.params.id
        }" 
        @permissionToggled="onPermissionToggled" />
</template>

<script>
    import { assignUser, deallocateUser } from '@models/permission';
    import PermissionRoleAssignmentTable from '@models/permission/widgets/PermissionRoleAssignmentTable.vue';
    export default {
        components: {
            PermissionRoleAssignmentTable
        },
        methods: {
            onPermissionToggled(data) {
                if(data.value){
                    assignUser(data.permission, this.$route.params.id, data.role);
                } else {
                    deallocateUser(data.permission, this.$route.params.id, data.role);
                }
            }
        }
    }
</script>