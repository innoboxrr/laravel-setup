<template>
    <div v-flowbite>
        <button 
            type="button" 
            data-drawer-target="cart-drawer" 
            data-drawer-show="cart-drawer" 
            data-drawer-placement="right" 
            aria-controls="cart-drawer"
            data-drawer-backdrop="false"
            class="relative p-2 mr-1 text-gray-500 rounded-lg hover:text-gray-900 hover:bg-gray-100 dark:text-gray-400 dark:hover:text-white dark:hover:bg-gray-700 focus:ring-4 focus:ring-gray-300 dark:focus:ring-gray-600">
            <span class="sr-only">Open cart</span>
            <svg class="w-6 h-6" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                <path fill-rule="evenodd" d="M4 4a1 1 0 0 1 1-1h1.5a1 1 0 0 1 .979.796L7.939 6H19a1 1 0 0 1 .979 1.204l-1.25 6a1 1 0 0 1-.979.796H9.605l.208 1H17a3 3 0 1 1-2.83 2h-2.34a3 3 0 1 1-4.009-1.76L5.686 5H5a1 1 0 0 1-1-1Z" clip-rule="evenodd"/>
            </svg>
            <div 
                v-if="cart?.cart_items?.length > 0" 
                class="absolute inline-flex items-center justify-center w-5 h-5 font-bold text-white bg-red-500 border-2 border-white rounded-full -top-1 -end-1 dark:border-gray-900" 
                style="font-size: 9px;">
                {{ cart?.cart_items?.length }}
            </div>
        </button>
        <div 
            id="cart-drawer" 
            class="fixed top-0 right-0 z-40 h-screen p-4 overflow-y-auto transition-transform translate-x-full bg-white dark:bg-gray-800 w-80" 
            tabindex="-1" 
            aria-labelledby="drawer-right-label"
            :aria-hidden="showDrawer">
            <div class="fixed inset-0 overflow-hidden">
                <div class="absolute inset-0 overflow-hidden">
                    <div class="pointer-events-none fixed inset-y-0 right-0 flex max-w-full pl-10">
                        <div class="pointer-events-auto w-screen max-w-md">
                            <div class="flex h-full flex-col overflow-y-scroll bg-white dark:bg-gray-700 shadow-xl">
                                <div class="flex-1 overflow-y-auto px-4 py-6 sm:px-6">
                                    <div class="flex items-start justify-between">
                                        <h2 
                                            class="text-lg font-medium text-gray-900 dark:text-white" 
                                            id="slide-over-title">
                                            {{ __('Shopping cart') }}
                                        </h2>
                                        <div class="ml-3 flex h-7 items-center">
                                            <button 
                                                type="button" 
                                                class="relative -m-2 p-2 text-gray-400 hover:text-gray-500 dark:text-gray-300 dark:hover:text-white" 
                                                data-drawer-hide="cart-drawer"  
                                                aria-controls="cart-drawer" >
                                                <span class="sr-only">Close panel</span>
                                                <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                                            </button>
                                        </div>
                                    </div>
                                    <!-- Remove all -->
                                    <div v-if="cart?.cart_items?.length > 0" class="mt-8">
                                        <div class="flex justify-between items-center">
                                            <h3 class="text-sm font-medium text-gray-900 dark:text-white">
                                                {{ __('Cart items') }}
                                            </h3>
                                            <button 
                                                type="button" 
                                                class="text-sm font-medium text-red-600 dark:text-red-500"
                                                @click="removeAllCartItems">
                                                {{ __('Remove all') }}
                                            </button>
                                        </div>
                                    </div>
                                    <div v-else>
                                        <div class="mt-8">
                                            <div class="flex justify-between items-center">
                                                <h3 class="text-sm font-medium text-gray-900 dark:text-white">
                                                    {{ __('Cart items') }}
                                                </h3>
                                            </div>
                                            <p class="mt-4 text-sm text-gray-500 dark:text-gray-300">
                                                {{ __('Your cart is empty.') }}
                                            </p>
                                        </div>
                                    </div>
                                    <!-- Cart Items -->
                                    <div class="mt-8">
                                        <div class="flow-root">
                                            <ul role="list" class="-my-6 divide-y divide-gray-200 dark:divide-gray-700">
                                                <li 
                                                    v-for="item in cart?.cart_items"
                                                    :key="item.id"
                                                    class="flex py-6">
                                                    <div class="h-24 w-24 flex-shrink-0 overflow-hidden rounded-md">
                                                        <img 
                                                            :src="item?.product?.productable?.feature_image" 
                                                            :alt="item?.product?.productable?.name" 
                                                            class="h-full w-full object-contain object-center rounded-md" />
                                                    </div>

                                                    <div class="ml-4 flex flex-1 flex-col">
                                                        <div>
                                                            <div class="flex justify-between text-base font-medium text-gray-900 dark:text-white">
                                                                <h3>
                                                                    <a href="#" class="dark:text-white">
                                                                        {{ item?.product?.productable?.name }}
                                                                    </a>
                                                                </h3>
                                                                <p class="ml-2">
                                                                    <template v-if="item.discount > 0">
                                                                        <span class="line-through">
                                                                            ${{ numberFormat(item.subtotal, 2) }}
                                                                        </span>
                                                                        <span class="text-red-500 font-bold ml-2">
                                                                            ${{ numberFormat(item.subtotal - item.discount, 2) }}
                                                                        </span>
                                                                    </template>
                                                                    <template v-else>
                                                                        ${{ numberFormat(item.subtotal, 2) }}
                                                                    </template>
                                                                </p>
                                                            </div>
                                                            <p v-if="item.discount > 0" class="mt-1 flex items-center text-sm font-semibold">
                                                                <span class="mr-2">
                                                                    <i class="fa-solid fa-tags text-red-600"></i>
                                                                </span>
                                                                <span class="text-red-600">{{ __('Discount') }}: ${{ numberFormat(item.discount, 2) }}</span>
                                                            </p>
                                                        </div>
                                                        <div 
                                                            class="flex flex-1 items-end justify-between text-sm">
                                                            <div
                                                                v-if="['voucher'].includes(item.product.type)" 
                                                                class="flex items-center">
                                                                <label for="quantity" class="text-gray-500 dark:text-gray-300 mr-2">
                                                                    {{ __('Qty.') }}
                                                                </label>
                                                                <input 
                                                                    id="quantity"
                                                                    type="number" 
                                                                    class="w-16 px-2 py-1 border rounded text-gray-700 dark:text-gray-300 dark:bg-gray-800 dark:border-gray-600"
                                                                    min="1" 
                                                                    max="100"
                                                                    :value="item.quantity" 
                                                                    @change="updateQuantity(item, $event.target.value)"
                                                                />
                                                            </div>
                                                            <div class="flex">
                                                                <button 
                                                                    type="button" 
                                                                    class="font-medium text-indigo-600 hover:text-indigo-500 dark:hover:text-indigo-400
                                                                    dark:text-indigo-300"
                                                                    @click="toggleCartItem(item?.product?.productable_id, item?.product?.productable_type)">
                                                                    {{ __('Remove') }}
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>

                                <div class="border-t border-gray-200 dark:border-gray-600 px-4 py-6 sm:px-6">
                                    <div class="flex justify-between text-base font-medium text-gray-900">
                                        <p class="dark:text-white">{{ __('Subtotal') }}</p>
                                        <p class="dark:text-white">
                                            ${{ numberFormat(cart?.amount ?? 0,2) }}
                                        </p>
                                    </div>
                                    <p class="mt-0.5 text-sm text-gray-500 dark:text-gray-300">
                                        {{ __('Discounts and taxes calculated at checkout.') }}
                                    </p>
                                    <div 
                                        class="mt-6" 
                                        data-drawer-hide="cart-drawer"  
                                        aria-controls="cart-drawer">
                                        <router-link
                                            :to="{
                                                name: 'CheckoutPayment'
                                            }"
                                            class="flex items-center justify-center rounded-md border border-transparent bg-indigo-600 px-6 py-3 text-base font-medium text-white shadow-sm hover:bg-indigo-700 hover:text-white"
                                            data-drawer-hide="cart-drawer"  
                                            aria-controls="cart-drawer"
                                            @click="showDrawer = false">
                                            {{ __('Continue to checkout') }}
                                        </router-link>
                                    </div>
                                    <div class="mt-6 flex justify-center text-center text-sm text-gray-500">
                                        <p class="dark:text-white">
                                        {{ __('or') }} 
                                        <button 
                                            type="button" 
                                            class="font-medium text-indigo-600 hover:text-indigo-500 dark:text-indigo-300"
                                            data-drawer-hide="cart-drawer"  
                                            aria-controls="cart-drawer">
                                            {{ __('Continue shopping') }}
                                            <span aria-hidden="true"> &rarr;</span>
                                        </button>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>  
        </div>
    </div>
</template>

<script>

    import { mapState, mapActions } from 'vuex';
    import { debounce } from 'innoboxrr-js-libs/libs/utils'

    export default {
        data() {
            return {
                showDrawer: false,
            }
        },
        mounted() {
            this.$store.dispatch('cartStore/initCart');
        },  
        computed: {
            ...mapState('cartStore', [
                'cart',
            ]),
        },
        methods: {
            ...mapActions('cartStore', [
                'updateCartItemPrice',
                'removeAllCartItems',
            ]),
            updateQuantity: debounce(function(item, quantity) {
                this.updateCartItemPrice({
                    item: item,
                    price: item.price,
                    quantity: quantity,
                });
            }, 500),
        }
    }
</script>