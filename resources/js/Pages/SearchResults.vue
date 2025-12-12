<template>
    <DefaultLayout :title="'Результаты поиска'" :breadcrumbs="breadcrumbs">
        <div class="search-results container">
            <h1>Результаты поиска: "{{ query }}"</h1>

            <div v-if="products.length === 0">
                Нет результатов
            </div>

            <div v-else class="products-grid">
                <div v-for="product in products" :key="product.id" class="product-card">
                    <a :href="`/products/${product.slug}`">
                        <img :src="getImageUrl(product.image_main)" alt="" />
                        <h2>{{ product.name }}</h2>
                        <p v-if="product.price_new">
                            <span class="price-new">{{ formatPrice(product.price_new) }} €</span>
                            <span v-if="product.price_old" class="price-old">{{ formatPrice(product.price_old) }} €</span>
                        </p>
                    </a>
                </div>
            </div>
        </div>
    </DefaultLayout>
</template>

<script setup>
import DefaultLayout from '@/Layouts/DefaultLayout.vue'
import { ref } from 'vue';
import { formatPrice } from '@/utils/formatPrice.js';

const props = defineProps({
    query: String,
    products: Array,
});

const breadcrumbs = [
    { label: 'Главная', href: '/' },
    { label: 'Поиск' }
];

const getImageUrl = (filename) => {
    return filename ? `/storage/${filename}` : '/images/noimg.png';
};
</script>

<style scoped>
h1{
    margin-bottom: 20px;
}

.products-grid {
    display: flex;
    flex-wrap: wrap;
    gap: 40px;
}

.product-card {
    width: 200px;
    text-align: center;
}

.product-card img {
    width: 100%;
    border-radius: 5px;
}

.price-old {
    text-decoration: line-through;
    color: red;
    margin-left: 5px;
}
</style>
