<template>
    <AuthenticatedLayout>
        <div class="cart-view p-6 bg-gray-100 min-h-screen">
            <h1 class="text-3xl font-bold mb-6">Shopping Cart</h1>
            <div v-if="cartStore?.cart?.length > 0">
                <div
                    v-for="product in cartStore.cart"
                    :key="product.id"
                    class="cart-item bg-white p-4 rounded-lg shadow-md mb-4"
                >
                    <h2 class="text-xl font-semibold">{{ product.name }}</h2>
                    <p class="text-gray-600">{{ product.description }}</p>
                    <p class="text-gray-800 font-bold">
                        Price: {{ product.price }}
                    </p>

                    <div class="flex items-center space-x-4">
                        <button
                            class="text-sm bg-gray-300 rounded px-2 py-1"
                            @click="updateQuantity(product.id, -1)"
                            :disabled="product.quantity <= 1"
                        >
                            -
                        </button>
                        <p class="text-gray-800">
                            Quantity: {{ product.quantity }}
                        </p>
                        <button
                            class="text-sm bg-gray-300 rounded px-2 py-1"
                            @click="updateQuantity(product.id, 1)"
                        >
                            +
                        </button>

                        <button
                            class="text-sm bg-red-500 text-white rounded px-2 py-1"
                            @click="deleteProduct(product.id)"
                        >
                            Delete
                        </button>
                    </div>
                </div>

                <div class="total-price bg-white p-4 rounded-lg shadow-md mt-4">
                    <h2 class="text-xl font-semibold">
                        Total Price: {{ totalPrice }}
                    </h2>
                </div>

                <div class="checkout-button mt-6">
                    <button
                        class="bg-blue-500 text-white py-2 px-4 rounded-md hover:bg-blue-600"
                        @click="checkout"
                    >
                        Checkout
                    </button>
                </div>
            </div>
            <div v-else>
                <p class="text-gray-600">Your cart is empty.</p>
            </div>
        </div>
    </AuthenticatedLayout>
    <Head title="Cart" />
</template>

<script>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { useCartStore } from "@/store/cartStore";
import { useOrderStore } from "@/store/orderStore";
import { Head, router, usePage } from "@inertiajs/vue3";
import { computed, onMounted } from "vue";

export default {
    components: {
        AuthenticatedLayout,
        Head,
    },
    setup() {
        const cartStore = useCartStore();
        const orderStore = useOrderStore();

        const page = usePage();
        const userId = computed(() => page.props.auth.user.id);

        const fetch = async () => {
            await cartStore.fetchCart(userId.value);
        };

        const updateQuantity = async (productId, change) => {
            await cartStore.updateCartQuantity(userId.value, productId, change);
        };

        const deleteProduct = async (productId) => {
            await cartStore.removeFromCart(userId.value, productId);
        };

        const totalPrice = computed(() => {
            return cartStore?.cart.reduce((total, product) => {
                return total + product.price * product.quantity;
            }, 0);
        });

        const orderProducts = computed(() => {
            return cartStore.cart.map((product) => ({
                id: product.id,
                quantity: product.quantity,
                price: product.price,
            }));
        });

        const checkout = async () => {
            const orderData = {
                user_id: userId.value,
                total_price: totalPrice.value,
                products: orderProducts.value,
            };

            await orderStore.createOrder(orderData);
            if (!orderStore.error) {
                router.visit(route("orders"));
            }
        };

        onMounted(async () => {
            await fetch();
        });

        return {
            cartStore,
            updateQuantity,
            deleteProduct,
            checkout,
            totalPrice,
            orderProducts,
        };
    },
};
</script>
