<template>
    <div class="related-products">
        <h3>Related Products</h3>

        <div class="carousel">
            <!-- Левая стрелка -->
            <button
                class="nav prev"
                @click="currentIndex = Math.max(currentIndex - 1, 0)"
                v-if="products.length > 4"
            >
                ‹
            </button>

            <!-- Окно-контейнер -->
            <div class="carousel-window">
                <div
                    class="carousel-track"
                    :style="{ transform: `translateX(-${currentIndex * (100 / 4)}%)` }"
                >
                    <div
                        class="product-card"
                        v-for="product in products"
                        :key="product.id"
                    >
                        <a :href="`/products/${product.slug}`">
                            <img
                                :src="product.image_main ? `/images/products/${product.image_main}` : '/images/noimg.png'"
                                class="product-img"
                            />
                        </a>
                        <h4>{{ product.name }}</h4>
                        <p class="price">{{ product.price_new ?? product.price }} €</p>
                    </div>
                </div>
            </div>

            <!-- Правая стрелка -->
            <button
                class="nav next"
                @click="currentIndex = Math.min(currentIndex + 1, products.length - 4)"
                v-if="products.length > 4"
            >
                ›
            </button>
        </div>
    </div>
</template>

<script>
export default {
    name: "RelatedProducts",
    props: {
        products: {
            type: Array,
            default: () => []
        }
    },
    data() {
        return {
            currentIndex: 0
        };
    }
};
</script>

<style scoped>
.related-products {
    margin-top: 40px;
}

.carousel {
    display: flex;
    align-items: center;
    position: relative;
}

.carousel-window {
    overflow: hidden;
    flex: 1;
}

.carousel-track {
    display: flex;
    transition: transform 0.3s ease;
    justify-content: space-between;
}

.product-card {
    width: 23%;
    margin-right: 1%;
    text-align: center;
}

.product-card:last-child {
    margin-right: 0;
}

.product-img {
    width: 217px;
    border-radius: 8px;
}

.price {
    font-weight: bold;
    margin-top: 5px;
}

.nav {
    background: #333;
    color: #fff;
    border: none;
    padding: 8px 12px;
    font-size: 24px;
    cursor: pointer;
    border-radius: 4px;
    margin: 0 5px;
}

.nav:hover {
    background: #555;
}

h3 {
    font-size: 20px;
    margin-bottom: 15px;
}
</style>
