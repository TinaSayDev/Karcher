<template>
    <nav class="catalog-nav">
        <h3>Лучшие предложения</h3>
        <ul class="right">
            <li v-for="item in items" :key="item">
                <a href="#">
                    <span>{{ item }}</span>
                    <div class="line bottom"></div>
                </a>
            </li>
        </ul>
    </nav>

    <div v-if="loading">Загрузка...</div>
    <div v-else-if="error">{{ error }}</div>
    <div v-else class="products-grid">
        <ProductCard :product="product"
                     v-for="product in products"
                     :key="product.id"/>

    </div>
</template>

<style scoped>
.products-grid {
    width: 80%;
    margin: 0 auto;
    display: grid;
    grid-template-columns: repeat(4, 1fr);
}
.catalog-nav h3{
    color:#333333;
    font-size: 24px;
}
.catalog-nav{
    width: 80%;
    display: flex;
    justify-content: space-between;
    align-content: center;
    margin:0 auto;
    padding: 10px;
    align-items: center;
}
ul.right{
    display: flex;
    gap:30px;
    color:#666666;
    font-size: 13px;
}

ul.right a{
    position: relative;
    padding-bottom: 5px;
}

ul.right li:last-child a {
    font-size: 10px;
    color:#999999;
    margin-left:30px;
}

.line {
    position: absolute;
    height: 2px;
    background: #ffd800; /* Karcher yellow */
    width: 0%;
    transition: width 0.35s ease;}

.line.bottom {
    bottom: 0;
    left: 0;                 /* анимация слева → направо */
    transform-origin: left;
}
a:hover .line {
    width: 100%;
}

@media (max-width: 1200px) {
    .products-grid {
        grid-template-columns: repeat(3, 1fr);
    }
}

@media (max-width: 900px) {
    .products-grid {
        grid-template-columns: repeat(2, 1fr);
    }
}

@media (max-width: 600px) {
    .products-grid {
        grid-template-columns: repeat(1, 1fr);
    }
}
</style>

<script setup>
import {ref, onMounted} from 'vue'
import ProductCard from "./ProductCard.vue";

// Массив продуктов
const products = ref([])
// Флаги загрузки и ошибок
const loading = ref(true)
const error = ref(null)

// Слайдер: для каждого продукта текущий индекс слайда
const currentIndex = ref({}) // { productId: index }

// Для хранения lastX и touchX для мыши/тача каждого продукта
const lastX = ref({})
const touchX = ref({})

// Для меню
const items = [
    "ХИП ПРОДАЖ",
    "СОВЕТУЕМ",
    "НОВИНКА",
    "УЦЕНКА",
    "ВЕСЬ КАТАЛОГ"
];

// Загрузка данных с API
onMounted(async () => {
    try {
        const response = await fetch('/api/products/hits')
        const json = await response.json()
        products.value = json.data || []

        // Инициализация индексов слайдеров для каждого продукта
        products.value.forEach(product => {
            currentIndex.value[product.id] = 0
            lastX.value[product.id] = null
            touchX.value[product.id] = null
        })
    } catch (e) {
        error.value = 'Ошибка загрузки данных'
    } finally {
        loading.value = false
    }
})

</script>

