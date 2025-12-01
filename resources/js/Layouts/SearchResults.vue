<template>
    <div v-if="results.length" class="results">
        <div v-for="product in results" :key="product.id" class="result-item">
            <img :src="product.image" alt="" class="thumb">
            <div class="info">
                <div class="title">{{ product.title }}</div>
                <div class="price" v-if="product.price">{{ product.price }} сум</div>
            </div>
        </div>
    </div>

    <div v-else-if="searched" class="no-results">
        Ничего не найдено
    </div>
</template>

<script setup>
const props = defineProps({
    results: Array,
    searched: Boolean
});
</script>

<style scoped>
.results {
    margin-top: 20px;
    display: flex;
    flex-direction: column;
    gap: 14px;
}

.result-item {
    display: flex;
    gap: 12px;
    align-items: center;
    padding: 12px;
    border-radius: 8px;
    background: #fff;
    box-shadow: 0 4px 14px rgba(0,0,0,0.08);
}

.thumb {
    width: 70px;
    height: 70px;
    object-fit: cover;
}

.title {
    font-weight: 600;
    font-size: 15px;
}

.price {
    color: #cb9800;
    font-weight: bold;
}

.no-results {
    margin-top: 20px;
    font-size: 15px;
    color: #666;
}
</style>
