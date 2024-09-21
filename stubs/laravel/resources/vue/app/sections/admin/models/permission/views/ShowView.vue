<template>

	<div v-if="dataLoaded">

		<breadcrumb-component :items="items" />
	    
	    <div class="uk-container uk-container-expand">

	    	<div class="uk-grid-small" uk-grid>
	    		
	    		<div class="uk-width-1-3@m uk-width-1-1@s">

					<model-card 
						:permission="permission" />

	    		</div>

	    		<div class="uk-width-expand uk-width-1-2@m uk-width-1-1@s">

	    			<div v-if="this.isShowView">

	    				<model-profile 
	    					:permission="permission" />
	    				
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

	import { showModel } from '@models/permission'
	import ModelCard from '@models/permission/widgets/ModelCard.vue'
	import ModelProfile from '@models/permission/widgets/ModelProfile.vue'

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

				permissionId: this.$route.params.id,

				permission: {},

			}
		
		},

		computed: {

			isShowView() {

				return (this.$route.name == 'AdminShowPermission');

			},

			items() {

				if(this.$route.name == 'AdminShowPermission') {

					return [
						{ text: 'Permissions', path: '/admin/permission'},
						{ text: this.permission.name ?? 'Permission', path: '/admin/permission/' + this.permission.id}
					];

				} else if(this.$route.name == 'AdminEditPermission') {

					return [
						{ text: 'Permissions', path: '/admin/permission'},
						{ text: this.permission.name ?? 'Permission' , path: '/admin/permission/' + this.permission.id},
						{ text: 'Editar permission', path: '/admin/permission/' + this.permission.id + '/edit'}	
					];

				}

			}

		},

		methods: {

			async fetchData() {

				await this.fetchPermission()

				this.dataLoaded = true;
				
				this.title = this.permission.name;

				document.title = this.title;

			},

			async fetchPermission() {

				let res = await showModel(this.permissionId);

				this.permission = res;

            },

		}

	}

</script>