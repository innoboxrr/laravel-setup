<template>

	<div v-if="dataLoaded">

		<breadcrumb-component :items="items" />
	    
	    <div class="uk-container uk-container-expand">

	    	<div class="uk-grid-small" uk-grid>
	    		
	    		<div class="uk-width-1-3@m uk-width-1-1@s">

					<model-card 
						:tracking-event="trackingEvent" />

	    		</div>

	    		<div class="uk-width-expand uk-width-1-2@m uk-width-1-1@s">

	    			<div v-if="this.isShowView">

	    				<model-profile 
	    					:tracking-event="trackingEvent" />
	    				
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

	import { showModel } from '@models/tracking-event'
	import ModelCard from '@models/tracking-event/widgets/ModelCard.vue'
	import ModelProfile from '@models/tracking-event/widgets/ModelProfile.vue'

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

				trackingEventId: this.$route.params.id,

				trackingEvent: {},

			}
		
		},

		computed: {

			isShowView() {

				return (this.$route.name == 'AdminShowTrackingEvent');

			},

			items() {

				if(this.$route.name == 'AdminShowTrackingEvent') {

					return [
						{ text: 'TrackingEvents', path: '/admin/tracking-event'},
						{ text: this.tracking-event.name ?? 'TrackingEvent', path: '/admin/tracking-event/' + this.tracking-event.id}
					];

				} else if(this.$route.name == 'AdminEditTrackingEvent') {

					return [
						{ text: 'TrackingEvents', path: '/admin/tracking-event'},
						{ text: this.tracking-event.name ?? 'TrackingEvent' , path: '/admin/tracking-event/' + this.tracking-event.id},
						{ text: 'Editar tracking-event', path: '/admin/tracking-event/' + this.tracking-event.id + '/edit'}	
					];

				}

			}

		},

		methods: {

			async fetchData() {

				await this.fetchTrackingEvent()

				this.dataLoaded = true;
				
				this.title = this.trackingEvent.name;

				document.title = this.title;

			},

			async fetchTrackingEvent() {

				let res = await showModel(this.trackingEventId);

				this.trackingEvent = res;

            },

		}

	}

</script>