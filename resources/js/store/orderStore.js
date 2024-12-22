import { defineStore } from "pinia";
import axios from "axios";

export const useOrderStore = defineStore("orderStore", {
    state: () => ({
        orders: [],
        order: null,
        loading: false,
        error: null,
    }),
    actions: {
        async fetchOrders(userId) {
            this.loading = true;
            try {
                const response = await axios.get(`/api/orders/${userId}`);
                this.orders = response.data?.orders;
            } catch (error) {
                this.error = error;
            } finally {
                this.loading = false;
            }
        },

        async createOrder(orderData) {
            this.loading = true;
            try {
                const response = await axios.post("/api/orders", orderData);
                this.orders.push(response.data?.order);
            } catch (error) {
                this.error = error;
            } finally {
                this.loading = false;
            }
        },

        async updateOrder(id, orderData) {
            this.loading = true;
            try {
                const response = await axios.put(
                    `/api/orders/${id}`,
                    orderData
                );
                const index = this.orders.findIndex((order) => order.id === id);
                if (index !== -1) {
                    this.orders[index] = response.data;
                }
            } catch (error) {
                this.error = error;
            } finally {
                this.loading = false;
            }
        },

        async deleteOrder(id) {
            this.loading = true;
            try {
                await axios.delete(`/api/orders/${id}`);
                this.orders = this.orders.filter((order) => order.id !== id);
            } catch (error) {
                this.error = error;
            } finally {
                this.loading = false;
            }
        },
    },
});
