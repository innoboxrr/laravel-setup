<template>

	<div class="mt-4">

		<breadcrumb-component 
			:pages="[
				{ link: $router.resolve({ name: 'AdminRoles' }).fullPath, title: 'Roles'},
				{ link: $router.resolve({ name: 'AdminCreateRole' }).fullPath, title: 'Create Roles'}
			]"/>
			
		<div class="flex justify-center items-center mt-8">
			
			<div class="max-w-2xl w-full">
				
				<div class="card bg-white dark:bg-slate-600 border rounded-lg px-8 pt-6 pb-8 mb-4 dark:border-slate-800">

					<h2 class="text-2xl font-bold dark:text-white mb-6">Create Roles</h2>
					
					<create-form 
						@submit="formSubmit"/>

				</div>

			</div>

		</div>

	</div>

</template>

<script>

	import { getPolicy } from '@models/role'
	import CreateForm from '@models/role/forms/CreateForm.vue'

	export default {

		components: {
			
			CreateForm

		},
		
		emits: ['updateData'],

		mounted(){

			this.fetchCreatePolicy();

		},

		methods: {

			fetchCreatePolicy() {

				getPolicy('create').then( res => {

					if(!res.create) {

						// this.$router.push({name: "NotAuthorized" });
						
					}

                });

			},

			formSubmit(payload) {	

				this.$emit('updateData', payload);

				this.$router.push({

					name: "AdminShowRole", 

					params: { 

						id: payload.id 

					} 

				});

			}

		}

	}

</script>