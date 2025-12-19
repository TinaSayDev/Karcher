<template>
    <ul class="products-grid">
        <li v-for="product in products" :key="product.id" class="product-card">
            <a :href="`/products/${product.slug}`">
                <img
                    :src="product.image_main
                        ? `/storage/${product.image_main}`
                        : '/images/noimg.png'"
                />
                <h4>{{ product.name }}</h4>

                <div class="prices">
                    <span v-if="product.price_new">
                        {{ product.price_new }} сум
                    </span>
                    <span v-else>
                        {{ product.price_old }} сум
                    </span>
                </div>
            </a>
        </li>
    </ul>
</template>

<script>
export default {
    props: {
        products: {
            type: Array,
            required: true
        }
    }
}
</script>
