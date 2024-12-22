<template>
    <div class="loading">
        <div class="spinner"></div>
        <p class="message">{{ message }}</p>
    </div>
</template>

<script>
export default {
    name: "Loading",
    props: {
        message: {
            type: String,
            default: "Loading, please wait...",
        },
    },
};
</script>

<style scoped>
.loading {
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    height: 100%;
    text-align: center;
    color: #555;
    font-size: 1.2em;
    padding: 1rem;
}

.spinner {
    width: 50px;
    height: 50px;
    border: 5px solid #f3f3f3;
    border-top: 5px solid #3498db;
    border-radius: 50%;
    animation: spin 1s linear infinite;
    margin-bottom: 15px;
}

.message {
    font-size: 1.2em;
    font-weight: 500;
    color: #555;
}

@keyframes spin {
    0% {
        transform: rotate(0deg);
    }
    100% {
        transform: rotate(360deg);
    }
}
</style>
