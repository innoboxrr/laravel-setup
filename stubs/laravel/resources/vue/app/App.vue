<template>
	<div id="AppWrapper" class="line-numbers" v-highlight>
		<router-view></router-view>
		<verification-modal />
		<wishlist-manager-modal 
			v-if="$store.state.authPages.isAuth"
			:open="$store.state.wishlistStore.openManager"
			:data="$store.state.wishlistStore.managerData"
			@close="$store.dispatch('wishlistStore/toggleWishlistItem', {})"
			@itemAdded="$store.dispatch('wishlistStore/addItem', $event)"
			@itemRemoved="$store.dispatch('wishlistStore/removeItem', $event)"
			@wishlistCreated="$store.dispatch('wishlistStore/addWishlist', $event)" />
	</div>
</template>

<script>
	export default {
		async mounted() {
			await this.$store.dispatch('langStore/langSetup');
			this.$store.dispatch('optionsStore/optionsSetup');
			await this.$store.dispatch('authPages/checkAuth');
		}
	}
</script>
