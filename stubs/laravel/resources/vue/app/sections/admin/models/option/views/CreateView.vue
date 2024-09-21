<template>

	<div class="mt-4">

		<breadcrumb-component 
			:pages="[
				{ link: $router.resolve({ name: 'AdminOptions' }).fullPath, title: 'Options'},
				{ link: $router.resolve({ name: 'AdminCreateOption' }).fullPath, title: 'Create Options'}
			]"/>
			
		<div class="flex justify-center items-center mt-8">
			
			<div class="max-w-2xl w-full">
				
				<div class="card bg-white dark:bg-slate-600 border rounded-lg px-8 pt-6 pb-8 mb-4 dark:border-slate-800">

					<h2 class="text-2xl font-bold dark:text-white mb-6">Create Options</h2>
					
					<create-form 
						@submit="formSubmit"/>

				</div>

			</div>

		</div>

	</div>

</template>

<script>

	import { getPolicy } from '@models/option'
	import CreateForm from '@models/option/forms/CreateForm.vue'

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

					name: "AdminShowOption", 

					params: { 

						id: payload.id 

					} 

				});

			}

		}

	}

</script>