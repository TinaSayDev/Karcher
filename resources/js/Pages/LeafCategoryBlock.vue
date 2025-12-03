<template>
    <div class="leaf-block">

        <!-- Левая часть: название + описание -->
        <div class="left">
            <h2>{{ category.name }}</h2>
            <p v-if="category.description">{{ category.description }}</p>
        </div>

        <!-- Правая часть: товары -->
        <div class="right">
            <div class="products">
                <div v-for="product in products" :key="product.id" class="product-card">
                    <img :src="product.images[0]" alt="" />
                    <h4>{{ product.name }}</h4>
                </div>
            </div>
        </div>

    </div>
</template>

<script setup>
const props = defineProps({
    category: Object,
    products: Array
})
</script>

<style scoped>
.leaf-block {
    display: flex;
    gap: 40px;
    margin-bottom: 50px;
    padding-bottom: 40px;
    border-bottom: 1px solid #eee;
}

.left {
    width: 30%;
}

.right {
    width: 70%;
}

.products {
    display: flex;
    flex-wrap: wrap;
    gap: 20px;
}

.product-card {
    width: 180px;
}
</style>
