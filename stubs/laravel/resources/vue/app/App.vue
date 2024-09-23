<template>
	<div id="AppWrapper" class="line-numbers" v-highlight>
		<router-view></router-view>
		<verification-modal />
	</div>
</template>

<script>
	export default {
		mounted() {
			this.$store.dispatch('authPages/checkAuth');
		}
	}
</script>