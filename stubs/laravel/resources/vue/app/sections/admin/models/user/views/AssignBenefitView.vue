<template>

	<div class="flex justify-center items-center">
			
		<div class="max-w-2xl w-full">
			
			<div class="card bg-white dark:bg-slate-600 border rounded-lg px-8 pt-6 pb-8 mb-4 dark:border-slate-800">

				<benefit-assignment-form 
					:key="$route.params.id"
					:user-id="$route.params.id"
					@submit="formSubmit"/>

                <div class="-mx-4 mt-10 ring-1 ring-gray-300 sm:mx-0 sm:rounded-lg">
                    <table class="min-w-full divide-y divide-gray-300">
                        <thead>
                            <tr>
                                <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6 dark:text-white">ID</th>
                                <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6 dark:text-white">Benefit</th>
                                <th scope="col" class="relative py-3.5 pl-3 pr-4 sm:pr-6">
                                    <span class="sr-only">Select</span>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr 
                                v-for="benefit in benefits"
                                :key="benefit.id">
                                <td class="py-4 pl-4 pr-3 text-sm sm:pl-6">
                                    <div class="font-medium text-gray-900 dark:text-white">{{ benefit.id }}</div>
                                </td>
                                <td class="relative py-4 pl-4 pr-3 text-sm sm:pl-6">
                                    <div class="font-medium text-gray-900 dark:text-white">{{ benefit.name }}</div>
                                </td>
                                <td class="relative py-3.5 pl-3 pr-4 text-right text-sm font-medium sm:pr-6">
                                    <button 
                                        type="button" 
                                        class="inline-flex items-center rounded-md bg-white px-2.5 py-1.5 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 disabled:cursor-not-allowed disabled:opacity-30 disabled:hover:bg-white"
                                        @click="deallocateBenefit(benefit)">
                                        Remove
                                    </button>
                                </td>
                            </tr>
                            <tr v-if="benefits.length === 0">
                                <td class="py-4 pl-4 pr-3 text-sm sm:pl-6">
                                    <div class="font-medium text-gray-900">No benefits assigned</div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
			</div>
		</div>
	</div>
</template>

<script>

	import { getPolicy, deallocateBenefit } from '@models/user'
    import { indexModel as indexBenefitModel } from '@models/benefit'
	import BenefitAssignmentForm from '@models/user/forms/BenefitAssignmentForm.vue'

	export default {

		components: {
			BenefitAssignmentForm
		},

		emits: ['updateData'],

        data() {
            return {
                benefits: [],
            }
        },

		mounted() {
			this.fetchAssignBenefitPolicy();
            this.fetchBenefits();
		},

		methods: {

			fetchAssignBenefitPolicy() {
				getPolicy('assignBenefit', this.$route.params.id).then( res => {
					if(!res.assignBenefit) {
						// this.$router.push({name: "NotAuthorized" });	
					}
                });
			},

            async fetchBenefits() {
                this.benefits = await indexBenefitModel({
                    paginate: 0,
                    user_id: this.$route.params.id
                });
            },

            deallocateBenefit(benefit) {
                deallocateBenefit(this.$route.params.id, benefit.id).then( res => {
                    this.benefits = this.benefits.filter( r => r.id !== benefit.id );
                });
            },

			formSubmit(payload) {	
				this.$emit('updateData', payload);
				this.fetchBenefits();
			}
		}
	}
</script>