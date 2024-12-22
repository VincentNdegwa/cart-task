<template>
    <AuthenticatedLayout>
        <Head title="Create Product" />
        <div class="max-w-2xl mx-auto p-6 bg-white shadow-md rounded-lg">
            <h1 class="text-2xl font-bold mb-6">Create Product</h1>
            <form @submit.prevent="submitForm" class="space-y-4">
                <div>
                    <label
                        for="name"
                        class="block text-sm font-medium text-gray-700"
                        >Name:</label
                    >
                    <input
                        type="text"
                        v-model="product.name"
                        id="name"
                        required
                        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                    />
                </div>
                <div>
                    <label
                        for="description"
                        class="block text-sm font-medium text-gray-700"
                        >Description:</label
                    >
                    <textarea
                        v-model="product.description"
                        id="description"
                        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                    ></textarea>
                </div>
                <div>
                    <label
                        for="price"
                        class="block text-sm font-medium text-gray-700"
                        >Price:</label
                    >
                    <input
                        type="number"
                        v-model="product.price"
                        id="price"
                        required
                        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                    />
                </div>
                <div>
                    <label
                        for="quantity"
                        class="block text-sm font-medium text-gray-700"
                        >Quantity:</label
                    >
                    <input
                        type="number"
                        v-model="product.quantity"
                        id="quantity"
                        required
                        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                    />
                </div>
                <button
                    type="submit"
                    class="w-full bg-indigo-600 text-white py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                >
                    Create Product
                </button>
            </form>
        </div>
    </AuthenticatedLayout>
</template>

<script>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, router } from "@inertiajs/vue3";
import { useProductStore } from "@/store/productStore";

export default {
    data() {
        return {
            product: {
                name: "",
                description: "",
                price: 0,
                quantity: 0,
            },
        };
    },
    methods: {
        async submitForm() {
            const productStore = useProductStore();
            try {
                await productStore.createProduct(this.product);
                router.visit(route("dashboard"));
            } catch (error) {
                console.error("Product creation failed:", error);
            }
        },
    },
    components: {
        AuthenticatedLayout,
        Head,
    },
};
</script>
