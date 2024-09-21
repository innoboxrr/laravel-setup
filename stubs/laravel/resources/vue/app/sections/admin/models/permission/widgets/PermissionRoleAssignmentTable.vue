<template>
    <div class="bg-gray-100 dark:bg-slate-800 p-8">
        <div class="overflow-x-auto overflow-y-auto max-h-[calc(100vh-130px)]">
            <table class="min-w-max table-fixed bg-gray-100 dark:bg-slate-800">
                <thead>
                    <tr class="bg-gray-100 dark:bg-slate-700">
                        <th 
                            scope="col" 
                            class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider sticky top-0 left-0 bg-gray-100 dark:bg-slate-700 dark:text-slate-300 text-center"
                            style="width: 200px; z-index: 39;" >
                            {{ __('Permission') }}
                        </th>
                        <th 
                            scope="col" 
                            class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider sticky top-0 bg-gray-100 dark:bg-slate-700 dark:text-slate-300 text-center"
                            v-for="role in roles" 
                            :key="role"
                            :style="{ width: '150px', zIndex: roles.indexOf(role) + 1 }"
                            :uk-tooltip="`${__('Role ID')} ${role.id}`">
                            {{ role.name }}
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200 dark:bg-slate-900 dark:divide-slate-700">
                    <tr 
                        v-for="permission in permissions" 
                        :key="permission">
                        <td 
                            class="px-4 py-4 whitespace-nowrap sticky left-0 bg-gray-100 dark:bg-slate-700 dark:text-slate-300 text-center"
                            :uk-tooltip="`${__('Permission ID')} ${permission.id}`">    
                            {{ permission.name }}
                        </td>
                        <td 
                            v-for="role in roles" 
                            :key="role"
                            class="px-4 py-4 whitespace-nowrap text-center">
                            <input 
                                v-if="showCheckbox(role, permission)"
                                type="checkbox" 
                                class="form-checkbox h-5 w-5 text-indigo-600 focus:ring-indigo-600 dark:text-slate-500 dark:focus:ring-slate-500 cursor-pointer"
                                :value="permission.id"
                                :checked="hasRolePermission(role.id, permission.id)"
                                @change="togglePermission(role.id, permission.id)">
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>


<script>
    import { indexModel as indexPermissions } from '@models/permission';
    import { indexModel as indexRoles } from '@models/role';
    export default {
        props: {
            type: {
                type: String,
                default: 'system', // system, user
                validator: value => ['system', 'user'].includes(value)
            },
            permissionsFilter: {
                type: Object,
                default: () => ({})
            },
            rolesFilter: {
                type: Object,
                default: () => ({})
            }
        },
        emits: [
            'permission-toggled'
        ],
        data() {
            return {
                dataLoaded: false,
                permissions: [],
                roles: [],
                rolePermissions: {}
            };
        },
        async mounted() {
            await this.fetchData();
            this.setRolePermissions();
            this.dataLoaded = true;
        },
        methods: {
            async fetchData() {
                await this.fetchRoles();
                await this.fetchPermissions();
            },
            async fetchRoles() {
                const baseFilter = {
                    paginate: 0,
                    ...this.rolesFilter
                };

                let filter = {};

                if (this.type === 'system') {
                    filter = {
                        ...baseFilter,
                        load_permissions: true
                    };
                } else {
                    filter = {
                        ...baseFilter,
                    };
                }

                const data = await indexRoles(filter);
                this.roles = data;
                this.roles.forEach(role => {
                    this.rolePermissions[role.id] = [];
                });
            },
            async fetchPermissions() {
                const baseFilter = {
                    paginate: 0,
                    load_roles: true,
                    ...this.permissionsFilter
                };

                let filter = {};

                if (this.type === 'system') {
                    filter = {
                        ...baseFilter,
                    };
                } else {
                    filter = {
                        ...baseFilter,
                        role_ids: this.roles.map(role => role.id),
                        load_user_permissions: this.rolesFilter.user_id
                    };
                }

                this.permissions = await indexPermissions(filter);
            },
            async setRolePermissions() {
                if (this.type === 'system') {
                    this.roles.forEach(role => {
                        this.rolePermissions[role.id] = role.permissions.map(permission => permission.id);
                    });
                }
                if (this.type === 'user') {
                    this.permissions.forEach(permission => {
                        permission.users.forEach(user => {
                            this.rolePermissions[user.pivot.role_id].push(permission.id);
                        });
                    });
                }
            },
            hasRolePermission(role, permission) {
                return this.rolePermissions[role].includes(permission);
            },
            togglePermission(role, permission) {
                if (this.hasRolePermission(role, permission)) {
                    this.rolePermissions[role] = this.rolePermissions[role].filter(p => p !== permission);
                    // Remove permission from role
                    this.$emit('permission-toggled', { role, permission, value: false });
                } else {
                    this.rolePermissions[role].push(permission);
                    // Add permission to role
                    this.$emit('permission-toggled', { role, permission, value: true });
                }
            },
            showCheckbox(role, permission) {
                if (this.type === 'system') {
                    return true;
                }
                if (this.type === 'user') {
                    return permission.roles.map(role => role.id).includes(role.id);
                }
            }
        }
    };
</script>

<style scoped>
    table td, table th {
        @apply px-0; 
    }
</style>