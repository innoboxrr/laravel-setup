<template>
	
	<form id="translationFilterForm" @submit.prevent="onSubmit">
		
		<div class="uk-flex uk-flex-left uk-child-width-1-4@m uk-child-width-1-1@s" uk-grid>
			
			<div>
				
				<text-input-component
					:custom-class="inputClass"
					type="number"
					name="id"
					label="ID"
					placeholder="ID" 
					v-model="id" />

			</div>

			<!-- Add more inputs -->
			<div>

                <text-input-component
                    :custom-class="inputClass"
                    type="number"
                    name="language_id"
                    :label="__('Language Id')"
                    :placeholder="__('Language Id')"
                    v-model="language_id" />

            </div>
			<div>

                <text-input-component
                    :custom-class="inputClass"
                    type="text"
                    name="map"
                    :label="__('map')"
                    :placeholder="__('map')"
                    v-model="map" />

            </div>

			<div>

                <text-input-component
                    :custom-class="inputClass"
                    type="number"
                    name="translationable_id"
                    :label="__('Translationable Id')"
                    :placeholder="__('Translationable Id')"
                    v-model="translationable_id" />

            </div>
			<div>

                <text-input-component
                    :custom-class="inputClass"
                    type="text"
                    name="translationable_type"
                    :label="__('Translationable Type')"
                    :placeholder="__('Translationable Type')"
                    v-model="translationable_type" />

            </div>

		</div>

		<div class="uk-flex uk-flex-right uk-child-width-auto@m uk-child-width-1-1@m" uk-grid>
			
			<div>
						
				<button :class="buttonClass">
			
					Buscar

				</button>

			</div>

			<div>

				<button 
					:class="buttonClass + ' bg-gray-400'"
					@click.prevent="resetForm()">
			
					Reiniciar

				</button>

			</div>

		</div>

	</form>

</template>

<script>
	
	import { TextInputComponent } from 'innoboxrr-form-elements'

	export default {

		components: {

			TextInputComponent

		},

		emits: ['submit'],

		data() {

			return {

				id: null,
				language_id: null,
				map: null,
				translationable_id: null,
				translationable_type: null,

				// Add more inputs names

			}

		},

		methods: {

			onSubmit() {

				this.$emit('submit', this.$data);

			},

			resetForm() {

				this.id = null;
				this.language_id = null;
				this.map = null;
				this.translationable_id = null;
				this.translationable_type = null;
				
				// Reset inputs

				this.onSubmit();

			}

		}

	}

</script>