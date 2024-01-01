<template>

	<div id="AdminUsersWrapper">

		<div v-if="isHome">

			<breadcrumb-component :items="[
                { text: 'Usuarios', path: '/admin/user'}
            ]" />

			<div  class="uk-section uk-section-xsmall">

				<data-table 
					:show-title="false"
					:hide-columns="hideColumns"
					:key="crudKey" />

			</div>

		</div>

		<div v-else>

			<router-view @updateData="updateDatatable"></router-view>
			
		</div>

	</div>

</template>

<script>
	
	import DataTable from '@models/user/widgets/DataTable.vue'

	export default {

		components: {

			DataTable

		},

		data() {

			return {

				title: undefined,

				crudKey: 0,

			}

		},

		computed: {

			isHome() {

				return (this.$route.name == 'AdminUsers');

			},

			hideColumns() {

				if(false) {

					this.updateDatatable();

					return [];

				}

				return [];

			}

		},

		methods: {

			updateDatatable() {

				++this.crudKey;

			},

		}

	}

</script>