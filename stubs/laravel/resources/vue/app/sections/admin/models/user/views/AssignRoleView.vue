<template>

	<div class="flex justify-center items-center">
			
		<div class="max-w-2xl w-full">
			
			<div class="card bg-white dark:bg-slate-600 border rounded-lg px-8 pt-6 pb-8 mb-4 dark:border-slate-800">

				<role-assignment-form 
					:key="$route.params.id"
					:user-id="$route.params.id"
					@submit="formSubmit"/>

                <div class="-mx-4 mt-10 ring-1 ring-gray-300 sm:mx-0 sm:rounded-lg">
                    <table class="min-w-full divide-y divide-gray-300">
                        <thead>
                            <tr>
                            <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6 dark:text-white">Role</th>
                            <th scope="col" class="relative py-3.5 pl-3 pr-4 sm:pr-6">
                                <span class="sr-only">Select</span>
                            </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr 
                                v-for="role in roles"
                                :key="role.id">
                                <td class="relative py-4 pl-4 pr-3 text-sm sm:pl-6">
                                    <div class="font-medium text-gray-900 dark:text-white">{{ role.name }}</div>
                                </td>
                                <td class="relative py-3.5 pl-3 pr-4 text-right text-sm font-medium sm:pr-6">
                                    <button 
                                        type="button" 
                                        class="inline-flex items-center rounded-md bg-white px-2.5 py-1.5 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 disabled:cursor-not-allowed disabled:opacity-30 disabled:hover:bg-white"
                                        @click="deallocateRole(role)">
                                        Remove
                                    </button>
                                </td>
                            </tr>
                            <tr v-if="roles.length === 0">
                                <td class="py-4 pl-4 pr-3 text-sm sm:pl-6">
                                    <div class="font-medium text-gray-900">No roles assigned</div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
			</div>
		</div>
	</div>
</template>

<script>

	import { getPolicy, deallocateRole } from '@models/user'
    import { indexModel as indexRoleModel } from '@models/role'
	import RoleAssignmentForm from '@models/user/forms/RoleAssignmentForm.vue'

	export default {

		components: {
			RoleAssignmentForm
		},

		emits: ['updateData'],

        data() {
            return {
                roles: [],
            }
        },

		mounted() {
			this.fetchAssignRolePolicy();
            this.fetchRoles();
		},

		methods: {

			fetchAssignRolePolicy() {
				getPolicy('assignRole', this.$route.params.id).then( res => {
					if(!res.assignRole) {
						// this.$router.push({name: "NotAuthorized" });	
					}
                });
			},

            async fetchRoles() {
                this.roles = await indexRoleModel({
                    paginate: 0,
                    user_id: this.$route.params.id
                });
            },

            deallocateRole(role) {
                deallocateRole(this.$route.params.id, role.id).then( res => {
                    this.roles = this.roles.filter( r => r.id !== role.id );
                });
            },

			formSubmit(payload) {	
				this.$emit('updateData', payload);
				this.fetchRoles();
			}
		}

	}

</script>