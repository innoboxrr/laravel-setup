<template>

	<div v-if="dataLoaded">

		<breadcrumb-component :items="items" />
	    
		<div class="mt-4">

			<div class="uk-container uk-container-expand">

				<div class="uk-grid-small" uk-grid>
					
					<div class="uk-width-1-3@m uk-width-1-1@s">

						<div class="sticky top-20">

							<model-card 	
								:user="user" />

						</div>

					</div>

					<div class="uk-width-expand uk-width-1-2@m uk-width-1-1@s">

						<div v-if="this.isShowView">

							<model-profile 
								:user="user" />
							
						</div>

						<div v-else>
							
							<router-view @updateData="fetchData"></router-view>

						</div>

					</div>

				</div>

			</div>

		</div>

	</div>

</template>

<script>

	import { showModel } from '@models/user'
	import ModelCard from '@models/user/widgets/ModelCard.vue'
	import ModelProfile from '@models/user/widgets/ModelProfile.vue'

	export default {

		components: {

			ModelCard,

			ModelProfile

		},

		mounted() {

			this.fetchData();

		},

		data() {
		
			return {

				dataLoaded: false,

				title: undefined,

				userId: this.$route.params.id,

				user: {},

			}
		
		},

		computed: {

			isShowView() {

				return (this.$route.name == 'AdminShowUser');

			},

			items() {

				if(this.$route.name == 'AdminShowUser') {

					return [
						{ text: 'Usuarios', path: '/admin/user'},
						{ text: this.user.name ?? 'Usuario', path: '/admin/user/' + this.user.id}
					];

				} else if(this.$route.name == 'AdminEditUser') {

					return [
						{ text: 'Usuarios', path: '/admin/user'},
						{ text: this.user.name ?? 'Usuario' , path: '/admin/user/' + this.user.id},
						{ text: 'Editar', path: '/admin/user/' + this.user.id + '/edit'}	
					];

				} else if(this.$route.name == 'AdminRoleAssignmentUser') {

					return [
						{ text: 'Usuarios', path: '/admin/user'},
						{ text: this.user.name ?? 'Usuario' , path: '/admin/user/' + this.user.id},
						{ text: 'Asignar rol', path: '/admin/user/' + this.user.id + '/role-assignment'}	
					];

				}

			}

		},

		methods: {

			fetchData() {

				this.fetchUser().then( res => {

					this.dataLoaded = true;
					
					this.title = this.user.name;

					document.title = this.title;

				});

			},

			fetchUser() {

				return new Promise((resolve, reject) => {

					showModel(this.userId).then( res => {

	                    this.user = res.data;

	                    resolve(res);

	                }).catch( error => {

	                    reject(error);

	                });

				});

            },

		}

	}

</script>