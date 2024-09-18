<template>
	<div id="AppWrapper" class="line-numbers" v-highlight>
		<router-view></router-view>
		<verification-modal />
	</div>
</template>

<script>
	export default {
		mounted() {
			await this.$store.dispatch('langStore/langSetup');
			this.$store.dispatch('optionsStore/optionsSetup');
			this.$store.dispatch('authPages/checkAuth');
		}
	}
</script>