<template>
    <div v-if="loading">Загрузка...</div>
    <div v-else-if="error">{{ error }}</div>
    <div v-else class="products-grid">

        <div class="card" v-for="product in products" :key="product.id">
            <div class="image image-slider" :style="`background-image: url(/storage/products/${product.image_main})`"></div>
            <div class="badge">Хит</div>
            <div class="stars">
                <div></div><div></div><div></div><div></div><div></div>
            </div>
            <div class="title">{{ product.name }}</div>
            <div class="stock">
                <div class="dot"></div>
                <div class="text">Достаточно</div>
            </div>
            <div class="price">{{ product.price }}</div>
            <div class="details-btn">Подробнее</div>
        </div>

    </div>
</template>

<style scoped>
.products-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 16px;
}

.product-card {
    border: 1px solid #ccc;
    border-radius: 8px;
    overflow: hidden;
    padding: 8px;
}

.image-slider {
    background-size: cover;
    background-position: center;
    border-radius: 8px;
}

.stars {
    display: flex;
    justify-content: center;
    margin-top: 6px;
}

.stars div {
    width: 10px;
    height: 10px;
    border-radius: 50%;
    margin: 0 3px;
    background: #ddd;
    transition: background 0.2s;
}

.stars div.active {
    background: #F1DE04;
}
</style>


<script setup>
import { ref, onMounted } from 'vue'

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

// Функция для обновления слайда мышью
function onMouseMove(e, product) {
    const id = product.id
    if(lastX.value[id] === null) { lastX.value[id] = e.clientX; return }
    if(e.clientX > lastX.value[id] + 10){
        currentIndex.value[id] = Math.min(product.images.length-1, currentIndex.value[id]+1)
        lastX.value[id] = e.clientX
    }
    if(e.clientX < lastX.value[id] - 10){
        currentIndex.value[id] = Math.max(0, currentIndex.value[id]-1)
        lastX.value[id] = e.clientX
    }
}

// Функции для слайдера на тач-устройствах
function onTouchStart(e, product) {
    touchX.value[product.id] = e.touches[0].clientX
}

function onTouchMove(e, product) {
    const id = product.id
    const x = e.touches[0].clientX
    if(x > touchX.value[id] + 20){
        currentIndex.value[id] = Math.min(product.images.length-1, currentIndex.value[id]+1)
        touchX.value[id] = x
    }
    if(x < touchX.value[id] - 20){
        currentIndex.value[id] = Math.max(0, currentIndex.value[id]-1)
        touchX.value[id] = x
    }
}
</script>

