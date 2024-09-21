<template>

	<div v-if="dataLoaded">

		<breadcrumb-component :pages="pages" />
	    
	    <div class="uk-container uk-container-expand">

	    	<div class="uk-grid-small" uk-grid>
	    		
	    		<div class="uk-width-1-3@m uk-width-1-1@s">

					<model-card 
						:language="language" />

	    		</div>

	    		<div class="uk-width-expand">

	    			<div v-if="this.isShowView">

	    				<model-profile 
	    					:language="language" />
	    				
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

	import { showModel } from '@models/language'
	import ModelCard from '@models/language/widgets/ModelCard.vue'
	import ModelProfile from '@models/language/widgets/ModelProfile.vue'

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

				languageId: this.$route.params.id,

				language: {},

			}
		
		},

		computed: {

			isShowView() {

				return (this.$route.name == 'AdminShowLanguage');

			},

			pages() {

				if(this.$route.name == 'AdminShowLanguage') {

					return [
						{ title: 'Languages', link: '/admin/language'},
						{ title: this.language.name ?? 'Language', link: '/admin/language/' + this.language.id}
					];

				} else if(this.$route.name == 'AdminEditLanguage') {

					return [
						{ title: 'Languages', link: '/admin/language'},
						{ title: this.language.name ?? 'Language' , link: '/admin/language/' + this.language.id},
						{ title: 'Editar language', link: '/admin/language/' + this.language.id + '/edit'}	
					];

				}

			}

		},

		methods: {

			async fetchData() {

				await this.fetchLanguage()

				this.dataLoaded = true;
				
				this.title = this.language.name;

				document.title = this.title;

			},

			async fetchLanguage() {

				let res = await showModel(this.languageId);

				this.language = res;

            },

		}

	}

</script>