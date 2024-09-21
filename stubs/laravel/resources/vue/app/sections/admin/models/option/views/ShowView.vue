<template>

	<div v-if="dataLoaded">

		<breadcrumb-component :pages="pages" />
	    
	    <div class="uk-container uk-container-expand">

	    	<div class="uk-grid-small" uk-grid>
	    		
	    		<div class="uk-width-1-3@m uk-width-1-1@s">

					<model-card 
						:option="option" />

	    		</div>

	    		<div class="uk-width-expand">

	    			<div v-if="this.isShowView">

	    				<model-profile 
	    					:option="option" />
	    				
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

	import { showModel } from '@models/option'
	import ModelCard from '@models/option/widgets/ModelCard.vue'
	import ModelProfile from '@models/option/widgets/ModelProfile.vue'

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

				optionId: this.$route.params.id,

				option: {},

			}
		
		},

		computed: {

			isShowView() {

				return (this.$route.name == 'AdminShowOption');

			},

			pages() {

				if(this.$route.name == 'AdminShowOption') {

					return [
						{ title: 'Options', link: '/admin/option'},
						{ title: this.option.name ?? 'Option', link: '/admin/option/' + this.option.id}
					];

				} else if(this.$route.name == 'AdminEditOption') {

					return [
						{ title: 'Options', link: '/admin/option'},
						{ title: this.option.name ?? 'Option' , link: '/admin/option/' + this.option.id},
						{ title: 'Editar option', link: '/admin/option/' + this.option.id + '/edit'}	
					];

				}

			}

		},

		methods: {

			async fetchData() {

				await this.fetchOption()

				this.dataLoaded = true;
				
				this.title = this.option.name;

				document.title = this.title;

			},

			async fetchOption() {

				let res = await showModel(this.optionId);

				this.option = res;

            },

		}

	}

</script>