<template>
    <div v-if="loading">Загрузка...</div>
    <div v-else-if="error">{{ error }}</div>
    <div v-else class="products-grid">

        <div class="card" v-for="product in products" :key="product.id">
            <div class="image image-slider" :style="`background-image: url(/storage/products/${product.images[0]})`"></div>
            <div class="badge">Хит</div>
            <div class="stars">
                <svg width="15" height="13" viewBox="0 0 15 13" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M14.3699 5.5L10.1599 7.90799L10.2699 8.254L12.3398 12.999H11.6199L7.49988 9.99899L3.40991 12.999H2.65991L4.69983 8.29199L4.81982 7.897L0.629883 5.49701V5H5.74988L7.27991 0H7.65991L9.22986 5H14.3699V5.5Z" fill="#DDDDDD"/>
                </svg>
                <svg width="15" height="13" viewBox="0 0 15 13" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M14.3699 5.5L10.1599 7.90799L10.2699 8.254L12.3398 12.999H11.6199L7.49988 9.99899L3.40991 12.999H2.65991L4.69983 8.29199L4.81982 7.897L0.629883 5.49701V5H5.74988L7.27991 0H7.65991L9.22986 5H14.3699V5.5Z" fill="#DDDDDD"/>
                </svg>
                <svg width="15" height="13" viewBox="0 0 15 13" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M14.3699 5.5L10.1599 7.90799L10.2699 8.254L12.3398 12.999H11.6199L7.49988 9.99899L3.40991 12.999H2.65991L4.69983 8.29199L4.81982 7.897L0.629883 5.49701V5H5.74988L7.27991 0H7.65991L9.22986 5H14.3699V5.5Z" fill="#DDDDDD"/>
                </svg>
                <svg width="15" height="13" viewBox="0 0 15 13" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M14.3699 5.5L10.1599 7.90799L10.2699 8.254L12.3398 12.999H11.6199L7.49988 9.99899L3.40991 12.999H2.65991L4.69983 8.29199L4.81982 7.897L0.629883 5.49701V5H5.74988L7.27991 0H7.65991L9.22986 5H14.3699V5.5Z" fill="#DDDDDD"/>
                </svg>
                <svg width="15" height="13" viewBox="0 0 15 13" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M14.3699 5.5L10.1599 7.90799L10.2699 8.254L12.3398 12.999H11.6199L7.49988 9.99899L3.40991 12.999H2.65991L4.69983 8.29199L4.81982 7.897L0.629883 5.49701V5H5.74988L7.27991 0H7.65991L9.22986 5H14.3699V5.5Z" fill="#DDDDDD"/>
                </svg>

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

