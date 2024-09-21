<template>

	<div v-if="dataLoaded">

		<breadcrumb-component :items="items" />
	    
	    <div class="uk-container uk-container-expand">

	    	<div class="uk-grid-small" uk-grid>
	    		
	    		<div class="uk-width-1-3@m uk-width-1-1@s">

					<model-card 
						:search="search" />

	    		</div>

	    		<div class="uk-width-expand uk-width-1-2@m uk-width-1-1@s">

	    			<div v-if="this.isShowView">

	    				<model-profile 
	    					:search="search" />
	    				
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

	import { showModel } from '@models/search'
	import ModelCard from '@models/search/widgets/ModelCard.vue'
	import ModelProfile from '@models/search/widgets/ModelProfile.vue'

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

				searchId: this.$route.params.id,

				search: {},

			}
		
		},

		computed: {

			isShowView() {

				return (this.$route.name == 'AdminShowSearch');

			},

			items() {

				if(this.$route.name == 'AdminShowSearch') {

					return [
						{ text: 'Searches', path: '/admin/search'},
						{ text: this.search.name ?? 'Search', path: '/admin/search/' + this.search.id}
					];

				} else if(this.$route.name == 'AdminEditSearch') {

					return [
						{ text: 'Searches', path: '/admin/search'},
						{ text: this.search.name ?? 'Search' , path: '/admin/search/' + this.search.id},
						{ text: 'Editar search', path: '/admin/search/' + this.search.id + '/edit'}	
					];

				}

			}

		},

		methods: {

			async fetchData() {

				await this.fetchSearch()

				this.dataLoaded = true;
				
				this.title = this.search.name;

				document.title = this.title;

			},

			async fetchSearch() {

				let res = await showModel(this.searchId);

				this.search = res;

            },

		}

	}

</script>