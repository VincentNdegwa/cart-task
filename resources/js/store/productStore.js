import { defineStore } from "pinia";

export const useProductStore = defineStore("productStore", {
    state: () => ({
        products: [],
        product: null,
        loading: false,
        error: null,
    }),
    actions: {
        async fetchProducts() {
            this.loading = true;
            try {
                const response = await axios.get("/api/products");
                this.products = response.data?.products;
            } catch (error) {
                this.error = error;
            } finally {
                this.loading = false;
            }
        },

        async createProduct(productData) {
            this.loading = true;
            try {
                const response = await axios.post("/api/products", productData);
                this.products.push(response.data);
            } catch (error) {
                this.error = error;
            } finally {
                this.loading = false;
            }
        },

        async updateProduct(id, productData) {
            this.loading = true;
            try {
                const response = await axios.put(
                    `/api/products/${id}`,
                    productData
                );
                const index = this.products.findIndex(
                    (product) => product.id === id
                );
                if (index !== -1) {
                    this.products[index] = response.data;
                }
            } catch (error) {
                this.error = error;
            } finally {
                this.loading = false;
            }
        },

        async deleteProduct(id) {
            this.loading = true;
            try {
                await axios.delete(`/api/products/${id}`);
                this.products = this.products.filter(
                    (product) => product.id !== id
                );
            } catch (error) {
                this.error = error;
            } finally {
                this.loading = false;
            }
        },
    },
});
