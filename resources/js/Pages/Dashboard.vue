v
<script>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, router, usePage } from "@inertiajs/vue3";
import { useProductStore } from "@/store/productStore";
import { computed, onMounted } from "vue";
import Products from "@/Components/Cart/Products.vue";
import { useCartStore } from "@/store/cartStore";
import NoData from "@/Components/Cart/NoData.vue";
import LoadingUI from "@/Components/LoadingUI.vue";

export default {
    components: {
        AuthenticatedLayout,
        Head,
        Products,
        NoData,
        LoadingUI,
    },
    setup() {
        const productStore = useProductStore();
        const cartStore = useCartStore();

        const page = usePage();
        const userId = computed(() => page.props.auth.user.id);

        const fetchProducts = async () => {
            await productStore.fetchProducts();
        };

        const addToCart = (product) => {
            cartStore.addToCart(userId.value, {
                ...product,
                quantity: 1,
            });
            if (!cartStore.error) {
                router.visit(route("cart"));
            }
        };

        onMounted(async () => {
            await fetchProducts();
        });

        return {
            productStore,
            cartStore,
            fetchProducts,
            userId,
            addToCart,
        };
    },
    mounted() {
        this.fetchProducts();
    },
    methods: {
        addToCart(product) {
            this.addToCart(product);
        },
    },
};
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <LoadingUI v-if="productStore.loading || cartStore.loading" />
        <div
            v-else-if="productStore.products.length > 0"
            class="overflow-hidden bg-white shadow-sm sm:rounded-lg p-6 flex flex-wrap"
        >
            <Products
                v-for="product in productStore.products"
                :key="product.id"
                :product="product"
                @addToCart="addToCart"
                class="mb-4"
            />
        </div>
        <NoData v-else message="No products available." />
    </AuthenticatedLayout>
</template>
