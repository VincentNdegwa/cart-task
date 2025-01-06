<template>
    <div
        class="bg-white shadow-md rounded-lg p-4 m-4 text-center min-w-[250px] cursor-pointer hover:shadow-lg hover:bg-gray-50"
    >
        <img
            :src="product.image || defaultImage"
            alt="Product Image"
            class="w-72 border border-red-600 h-72 object-cover rounded-lg mb-4"
        />
        <h2 class="text-xl font-semibold mb-2">{{ product.name }}</h2>
        <p class="text-lg text-gray-700 mb-4">{{ product.price }} KSH</p>
        <p class="text-sm text-slate-400">{{ product.quantity }} Pieces</p>
        <button
            @click="addToCart(product)"
            :disabled="outOfStock(product)"
            class="bg-green-500 text-white py-2 px-4 rounded hover:bg-green-600"
        >
            Add to Cart
        </button>
    </div>
</template>

<script>
export default {
    name: "ProductCard",
    emits: ["addToCart"],
    props: {
        product: {
            type: Object,
            required: true,
        },
    },
    data() {
        return {
            defaultImage:
                "https://www.lg.com/lg5-common/images/common/product-default-list-350.jpg",
        };
    },
    methods: {
        addToCart(product) {
            this.$emit("addToCart", product);
        },
        outOfStock(product) {
            return product.quantity <= 0;
        },
    },
    computed: {},
};
</script>
