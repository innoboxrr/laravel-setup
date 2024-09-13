<template>
	
	<data-table
		title="Role" 
		:data-url="dataUrl"
		data-method="get"
		:policy-url="policyUrl"
		policy-method="get"
		:model="model"
		:external-filters="roleExternalFilters"
		:form-filters="formFilters"
		:extra-params="extraParams"
		:hide-columns="hideColumns"
		:card-wrapper="cardWrapper"
		:show-topbar="showTopbar"
		:show-title="showTitle"
		:has-actions="hasActions" 
		:has-filter="hasFilter" >

		<template v-slot:filterForm>
			
			<filter-form @submit="updateFormFilters" />

		</template>

	</data-table>

</template>

<script>
	
	import DataTable from 'innoboxrr-vue-datatable'
	import FilterForm from '@models/role/forms/FilterForm.vue'
	import * as model from '@models/role' 

	export default {

		components: {
			
			DataTable,
			
			FilterForm ,

		},

		props: {

			showTopbar:{
				type: Boolean,
				default: true
			},
			
			showTitle: {
				type: Boolean,
				default: true
			},

			showBreadcrumb: {
				type: Boolean,
				default: false
			},

			hasActions: {
				type: Boolean,
				default: true
			},

			hasFilter: {
				type: Boolean,
				default: true
			},

			externalFilters: {
				type: Object,
				default: {}
			},

			extraParams: {
				type: Object,
				default: {}
			},

			hideColumns: {
				type: Array,
				default: []
			},

			cardWrapper: {
				type: Boolean,
				default: true
			},

		},		

		data() {

			return {
			
				dataUrl: route(`${model.API_ROUTE_PREFIX}index`),

				policyUrl: route(`${model.API_ROUTE_PREFIX}policies`),

				model: model,

				formFilters: {}
			
			}

		},

		computed: {

			roleExternalFilters() {

				let filters = {/* Add custom filters */}

				return {
					...this.externalFilters,
					...filters
				}

			}

		},

		methods: {

			updateFormFilters(filters) {

				this.formFilters = filters;

			},

		}

	}

</script>