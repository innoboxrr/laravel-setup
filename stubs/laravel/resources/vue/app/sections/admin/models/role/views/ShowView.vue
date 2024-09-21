<template>

	<div v-if="dataLoaded">

		<breadcrumb-component :pages="pages" />
	    
	    <div class="uk-container uk-container-expand">

	    	<div class="uk-grid-small" uk-grid>
	    		
	    		<div class="uk-width-1-3@m uk-width-1-1@s">

					<model-card 
						:role="role" />

	    		</div>

	    		<div class="uk-width-expand">

	    			<div v-if="this.isShowView">

	    				<model-profile 
	    					:role="role" />
	    				
	    			</div>

	    			<div v-else>
	    				
	    				<router-view @updateData="fetchData"></router-view>

	    			</div>

	    		</div>

	    	</div>

	    </div>

	</div>

</template>

<script>

	import { showModel } from '@models/role'
	import ModelCard from '@models/role/widgets/ModelCard.vue'
	import ModelProfile from '@models/role/widgets/ModelProfile.vue'

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

				roleId: this.$route.params.id,

				role: {},

			}
		
		},

		computed: {

			isShowView() {

				return (this.$route.name == 'AdminShowRole');

			},

			pages() {

				if(this.$route.name == 'AdminShowRole') {

					return [
						{ title: 'Roles', link: '/admin/role'},
						{ title: this.role.name ?? 'Role', link: '/admin/role/' + this.role.id}
					];

				} else if(this.$route.name == 'AdminEditRole') {

					return [
						{ title: 'Roles', link: '/admin/role'},
						{ title: this.role.name ?? 'Role' , link: '/admin/role/' + this.role.id},
						{ title: 'Editar role', link: '/admin/role/' + this.role.id + '/edit'}	
					];

				}

			}

		},

		methods: {

			async fetchData() {

				await this.fetchRole()

				this.dataLoaded = true;
				
				this.title = this.role.name;

				document.title = this.title;

			},

			async fetchRole() {

				let res = await showModel(this.roleId);

				this.role = res;

            },

		}

	}

</script>