<template>
    <AuthenticatedLayout>
        <div class="container mx-auto p-4">
            <div>
                <OrderCard
                    v-for="order in orderStore.orders"
                    :key="order.id"
                    :order="order"
                />
            </div>
        </div>
    </AuthenticatedLayout>

    <Head title="Orders" />
</template>

<script>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { useOrderStore } from "@/store/orderStore";
import { onMounted, computed } from "vue";
import { Head, usePage } from "@inertiajs/vue3";
import OrderCard from "@/Components/Cart/OrderCard.vue";

export default {
    name: "Orders",
    components: {
        AuthenticatedLayout,
        OrderCard,
        Head,
    },
    data() {
        return {
            orders: [],
        };
    },
    setup() {
        const orderStore = useOrderStore();
        const page = usePage();
        const userId = computed(() => page.props.auth.user.id);

        const fetchOrders = async () => {
            await orderStore.fetchOrders(userId.value);
        };

        onMounted(async () => {
            await fetchOrders();
        });

        return {
            orderStore,
            userId,
        };
    },
};
</script>
