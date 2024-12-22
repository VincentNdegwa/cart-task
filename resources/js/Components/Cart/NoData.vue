<template>
    <div class="no-data">
        <div class="content">
            <slot name="icon">
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke-width="1.5"
                    stroke="currentColor"
                    class="icon"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-3a2.25 2.25 0 00-2.25 2.25V9m10.5 12V10.5M6.75 21V10.5m0 0h10.5m-10.5 0h10.5M9.75 13.5h4.5m-4.5 3h4.5"
                    />
                </svg>
            </slot>
            <p class="message">{{ message }}</p>
        </div>
    </div>
</template>

<script>
export default {
    name: "NoData",
    props: {
        message: {
            type: String,
            required: true,
        },
    },
};
</script>

<style scoped>
.no-data {
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100%;
    text-align: center;
    color: #888;
    font-size: 1.2em;
    padding: 1rem;
}

.content {
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
}

.icon {
    width: 50px;
    height: 50px;
    margin-bottom: 10px;
    color: #aaa;
}

.message {
    font-size: 1.5em;
    font-weight: 500;
}
</style>
