<template>
    <div>
        <h2 class="text-2xl font-bold mb-6">Каталог</h2>

        <div v-if="loading">Загрузка...</div>
        <div v-if="error" class="text-red-500">{{ error }}</div>

        <div v-if="products.length" class="grid grid-cols-4 gap-6">
            <div v-for="product in products" :key="product.id"
                 class="border p-4 rounded shadow hover:shadow-lg transition">
                <img v-if="product.image"
                     :src="product.image"
                     class="mb-2 w-full h-32 object-cover rounded">

                <h3 class="font-semibold text-lg mb-1">{{ product.name }}</h3>
                <p class="text-gray-700">{{ product.price }} ₽</p>
            </div>
        </div>

        <div v-else-if="!loading">
            Нет товаров
        </div>
    </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'

const products = ref([])
const loading = ref(true)
const error = ref(null)

onMounted(async () => {
    try {
        const response = await fetch('/api/products/hits')
        const json = await response.json()

        products.value = json.data || []
    } catch (e) {
        error.value = 'Ошибка загрузки данных'
    } finally {
        loading.value = false
    }
})
</script>
