<template>
    <div class="shadow-xl rounded-lg overflow-hidden mb-6">
        <div class="p-6">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-xl font-bold text-indigo-600">
                    Order #{{ order.id }}
                </h2>
                <span
                    class="status-badge px-3 py-1 text-sm font-medium rounded-full"
                    :class="statusClass(order.status)"
                >
                    {{ order.status }}
                </span>
            </div>
            <div class="order-details mb-4">
                <p class="flex items-center text-gray-700">
                    <i class="mdi mdi-cash-multiple mr-2 text-indigo-500"></i>
                    <span>Total Price:</span> {{ order.total_price }}
                </p>
                <p class="flex items-center text-gray-700">
                    <i class="mdi mdi-calendar-clock mr-2 text-indigo-500"></i>
                    <span>Date:</span>
                    {{ new Date(order.created_at).toLocaleDateString() }}
                </p>
            </div>
            <div v-if="order.order_products?.length">
                <h3 class="font-semibold text-gray-800 mb-2">Products:</h3>
                <ul class="space-y-2">
                    <li
                        v-for="product in order.order_products"
                        :key="product.id"
                        class="flex justify-between items-center text-gray-600 bg-gray-100 rounded-md px-4 py-2"
                    >
                        <span class="font-medium text-gray-800">
                            {{ product.product.name }}
                        </span>
                        <span>Qty: {{ product.quantity }}</span>
                        <span>{{ product.price }}</span>
                    </li>
                </ul>
            </div>
            <div v-else class="mt-4 text-gray-500 text-center">
                No products in this order.
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "OrderCard",
    props: {
        order: {
            type: Object,
            required: true,
        },
    },
    methods: {
        statusClass(status) {
            switch (status?.toLowerCase()) {
                case "paid":
                    return "bg-green-100 text-green-600";
                case "pending":
                    return "bg-yellow-100 text-yellow-600";
                case "cancelled":
                    return "bg-red-100 text-red-600";
                default:
                    return "bg-gray-100 text-gray-600";
            }
        },
    },
};
</script>

<style scoped></style>
