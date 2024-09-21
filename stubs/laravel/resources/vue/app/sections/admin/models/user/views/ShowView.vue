<template>

	<div v-if="dataLoaded">

		<breadcrumb-component :pages="pages" />
	    
		<div class="mt-4">

			<div class="uk-container uk-container-expand">

				<div class="uk-grid-small" uk-grid>
					
					<div class="uk-width-1-3@m uk-width-1-1@s">

						<div class="sticky top-20">

							<model-card 	
								:user="user" />

						</div>

					</div>

					<div class="uk-width-expand">

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

			pages() {

				if(this.$route.name == 'AdminShowUser') {

					return [
						{ title: 'Usuarios', link: '/admin/user'},
						{ title: this.user.name ?? 'Usuario', link: '/admin/user/' + this.user.id}
					];

				} else if(this.$route.name == 'AdminEditUser') {

					return [
						{ title: 'Usuarios', link: '/admin/user'},
						{ title: this.user.name ?? 'Usuario' , link: '/admin/user/' + this.user.id},
						{ title: 'Editar', link: '/admin/user/' + this.user.id + '/edit'}	
					];

				} else if(this.$route.name == 'AdminRoleAssignmentUser') {

					return [
						{ title: 'Usuarios', link: '/admin/user'},
						{ title: this.user.name ?? 'Usuario' , link: '/admin/user/' + this.user.id},
						{ title: 'Asignar rol', link: '/admin/user/' + this.user.id + '/role-assignment'}	
					];

				}

			}

		},

		methods: {

			async fetchData() {

				let res = await this.fetchUser();

				this.dataLoaded = true;
					
				this.title = this.user.name;

				document.title = this.title;

			},

			async fetchUser() {

				let res = await showModel(this.userId);

				this.user = res;

            },

		}

	}

</script>