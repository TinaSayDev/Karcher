<template>
    <nav class="catalog-nav">
        <h3>Лучшие предложения</h3>
        <ul class="right">
            <li
                v-for="(item, index) in items"
                :key="item.key"
                :class="{ active: activeIndex === index }"
                @click="setActive(index)"
            >
                <a href="#" @click.prevent>{{ item.label }}</a>
            </li>
        </ul>
    </nav>

    <div v-if="loading">Загрузка...</div>
    <div v-else-if="error">{{ error }}</div>
    <div v-else class="products-grid">
        <ProductCard
            v-for="product in products"
            :key="product.id"
            :product="product"
            :activeFilter="items[activeIndex].key"
            @open="openProduct"
        />
    </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import ProductCard from './ProductCard.vue';

// Пункты меню
const items = [
    { key: 'hit', label: 'ХИТ ПРОДАЖ' },
    { key: 'recommended', label: 'СОВЕТУЕМ' },
    { key: 'new', label: 'НОВИНКА' },
    { key: 'sale', label: 'УЦЕНКА' },
    { key: 'all', label: 'ВЕСЬ КАТАЛОГ' },
];

const activeIndex = ref(0);
const products = ref([]);
const loading = ref(true);
const error = ref(null);

// Загрузка продуктов по фильтру
async function loadProducts(filterKey) {
    loading.value = true;
    error.value = null;
    try {
        const response = await fetch(`/api/products/filter?filter=${filterKey}`);
        const json = await response.json();
        products.value = json.data || [];
    } catch (e) {
        error.value = 'Ошибка загрузки данных';
    } finally {
        loading.value = false;
    }
}

// Клик по пункту меню
function setActive(index) {
    activeIndex.value = index;
    loadProducts(items[index].key);
}

// Начальная загрузка
onMounted(() => {
    loadProducts(items[activeIndex.value].key);
});

// Обработчик открытия продукта
function openProduct(product) {
    console.log('Открыть продукт', product);
}
</script>
