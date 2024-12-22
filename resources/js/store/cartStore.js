import { defineStore } from "pinia";
import axios from "axios";

export const useCartStore = defineStore("cartStore", {
    state: () => ({
        cart: null,
        loading: false,
        error: null,
    }),
    actions: {
        async fetchCart(userId) {
            this.loading = true;
            try {
                const response = await axios.get(`/api/cart/${userId}`);
                console.log(response.data.cart);

                this.cart = Object.values(response.data.cart);
            } catch (error) {
                this.error = error;
            } finally {
                this.loading = false;
            }
        },

        async addToCart(userId, productData) {
            this.loading = true;
            try {
                const response = await axios.post(
                    `/api/cart/${userId}`,
                    productData
                );
                this.cart = Object.values(response.data.cart);
            } catch (error) {
                this.error = error;
            } finally {
                this.loading = false;
            }
        },

        async removeFromCart(userId, productId) {
            this.loading = true;
            try {
                await axios.delete(`/api/cart/${userId}`, {
                    data: { productId },
                });
                this.cart = this.cart.filter((item) => item.id !== productId);
            } catch (error) {
                this.error = error;
            } finally {
                this.loading = false;
            }
        },
        async updateCartQuantity(userId, productId, change) {
            try {
                const response = await axios.post(
                    `/api/cart/${userId}/update`,
                    {
                        product_id: productId,
                        change: change,
                    }
                );

                this.cart = Object.values(response.data.cart);
            } catch (error) {
                console.error("Failed to update cart:", error);
            }
        },
    },
});
