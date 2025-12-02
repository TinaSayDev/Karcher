<template>
    <nav class="catalog-nav">
        <h3>Лучшие предложения</h3>
        <ul class="right">
            <li
                v-for="(item, index) in items"
                :key="item.key"
                :class="{ active: activeIndex === index }"
                @click.prevent="setActive(index)"
            >
                <a href="#">
                    <span>{{ item.label }}</span>
                    <div class="line bottom"></div>
                </a>
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
            :current-index="currentIndex[product.id]"
            @update-index="updateIndex(product.id, $event)"
        />
    </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import ProductCard from './ProductCard.vue'

const items = [
    { key: 'hit', label: 'ХИТ ПРОДАЖ' },
    { key: 'recommended', label: 'СОВЕТУЕМ' },
    { key: 'new', label: 'НОВИНКА' },
    { key: 'sale', label: 'УЦЕНКА' },
    { key: 'all', label: 'ВЕСЬ КАТАЛОГ' },
]

// --- Состояние ---
const products = ref([])
const loading = ref(true)
const error = ref(null)
const activeIndex = ref(0)
const currentIndex = ref({}) // текущий слайд для каждого продукта

// --- Загрузка товаров ---
async function loadProducts(filterKey) {
    loading.value = true
    error.value = null

    try {
        const response = await fetch(`/api/products/filter?flag=${filterKey}`)
        const json = await response.json()
        products.value = json.data || []

        // Инициализация индексов слайдов
        products.value.forEach(product => {
            currentIndex.value[product.id] = 0
        })

    } catch (e) {
        error.value = 'Ошибка загрузки товаров'
    } finally {
        loading.value = false
    }
}

// --- Клик по пункту меню ---
function setActive(index) {
    activeIndex.value = index
    loadProducts(items[index].key)
}

// --- Обновление слайда из дочернего компонента ---
function updateIndex(productId, index) {
    currentIndex.value[productId] = index
}

// --- Первая загрузка ---
onMounted(() => {
    loadProducts(items[0].key)
})
</script>
