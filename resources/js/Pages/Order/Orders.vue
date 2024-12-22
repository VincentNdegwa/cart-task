<template>
    <AuthenticatedLayout>
        <LoadingUI v-if="orderStore.loading" />
        <div
            v-if="orderStore?.orders?.length > 0"
            class="container mx-auto p-4"
        >
            <div>
                <OrderCard
                    v-for="order in orderStore.orders"
                    :key="order.id"
                    :order="order"
                />
            </div>
        </div>

        <NoData v-else message="No orders available." />
    </AuthenticatedLayout>

    <Head title="Orders" />
</template>

<script>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { useOrderStore } from "@/store/orderStore";
import { onMounted, computed } from "vue";
import { Head, usePage } from "@inertiajs/vue3";
import OrderCard from "@/Components/Cart/OrderCard.vue";
import NoData from "@/Components/Cart/NoData.vue";
import LoadingUI from "@/Components/LoadingUI.vue";

export default {
    name: "Orders",
    components: {
        AuthenticatedLayout,
        OrderCard,
        Head,
        NoData,
        LoadingUI,
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
