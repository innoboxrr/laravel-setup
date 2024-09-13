<template>

	<div v-if="dataLoaded">

		<breadcrumb-component :pages="pages" />
	    
	    <div class="uk-container uk-container-expand">

	    	<div class="uk-grid-small" uk-grid>
	    		
	    		<div class="uk-width-1-3@m uk-width-1-1@s">

					<model-card 
						:translation="translation" />

	    		</div>

	    		<div class="uk-width-expand">

	    			<div v-if="this.isShowView">

	    				<model-profile 
	    					:translation="translation" />
	    				
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

	import { showModel } from '@models/translation'
	import ModelCard from '@models/translation/widgets/ModelCard.vue'
	import ModelProfile from '@models/translation/widgets/ModelProfile.vue'

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

				translationId: this.$route.params.id,

				translation: {},

			}
		
		},

		computed: {

			isShowView() {

				return (this.$route.name == 'AdminShowTranslation');

			},

			pages() {

				if(this.$route.name == 'AdminShowTranslation') {

					return [
						{ title: 'Translations', link: '/admin/translation'},
						{ title: this.translation.name ?? 'Translation', link: '/admin/translation/' + this.translation.id}
					];

				} else if(this.$route.name == 'AdminEditTranslation') {

					return [
						{ title: 'Translations', link: '/admin/translation'},
						{ title: this.translation.name ?? 'Translation' , link: '/admin/translation/' + this.translation.id},
						{ title: 'Editar translation', link: '/admin/translation/' + this.translation.id + '/edit'}	
					];

				}

			}

		},

		methods: {

			async fetchData() {

				await this.fetchTranslation()

				this.dataLoaded = true;
				
				this.title = this.translation.name;

				document.title = this.title;

			},

			async fetchTranslation() {

				let res = await showModel(this.translationId);

				this.translation = res;

            },

		}

	}

</script>