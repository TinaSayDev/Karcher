<template>
    <div class="carousel">
        <button
            class="arrow left"
            @click="prev"
            :disabled="currentIndex === 0"
        >‹</button>

        <div class="viewport">
            <div
                class="row"
                :style="{ transform: `translateX(-${currentIndex * (cardWidth + gap)}px)` }"
            >
                <div
                    class="product-card"
                    v-for="product in products"
                    :key="product.id"
                >
                    <a :href="`/products/${product.slug}`">
                        <img
                            :src="product.image_main ? `/storage/${product.image_main}` : '/images/noimg.png'"
                            class="product-img"
                        />
                        <h4 class="title">{{ product.name }}</h4>

                        <div class="product-prices">
                            <p v-if="product.price_new" class="price-new">
                                {{ formatPrice(product.price_new) }} сум
                            </p>
                            <p v-if="product.price_new" class="price-old">
                                {{ formatPrice(product.price_old) }} сум
                            </p>
                            <p v-else class="price">
                                {{ formatPrice(product.price_old) }} сум
                            </p>
                        </div>
                    </a>
                </div>
            </div>
        </div>

        <button
            class="arrow right"
            @click="next"
            :disabled="currentIndex >= maxIndex"
        >›</button>
    </div>
</template>


<script>
import { formatPrice } from '@/utils/formatPrice.js'

export default {
    props: {
        products: Array
    },
    data() {
        return {
            currentIndex: 0,
            cardWidth: 220,
            gap: 20,
            visible: 3
        }
    },
    computed: {
        maxIndex() {
            return Math.max(0, this.products.length - this.visible)
        }
    },
    methods: {
        prev() {
            if (this.currentIndex > 0) this.currentIndex--
        },
        next() {
            if (this.currentIndex < this.maxIndex) this.currentIndex++
        },
        formatPrice
    }
}
</script>


<style scoped>
.carousel {
    position: relative;
    display: flex;
    align-items: center;
    padding-left: 90px;
    padding-right: 90px;
}

/* Окно — строго на 3 карточки */
.viewport {
    overflow: hidden;
    width: calc(3 * 200px + 2 * 20px);
}

/* Лента */
.row {
    display: flex;
    gap: 20px;
    transition: transform 0.3s ease;
}

/* Карточка */
.product-card {
    width: 220px;
    flex-shrink: 0;
    border: none;
    padding: 10px;
    border-radius: 8px;
}

.product-img {
    width: 100%;
    height: 150px;
    object-fit: cover;
}

/* Стрелки — ВНЕ контента */
.arrow {
    background: #fff;
    border: 1px solid #ddd;
    font-size: 24px;
    width: 36px;
    height: 36px;
    cursor: pointer;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
}

.arrow.left {
    margin-right: 10px;
}

.arrow.right {
    margin-left: 10px;
}

.arrow:disabled {
    opacity: 0.3;
    cursor: default;
}

.leaf-products {
    flex: 1;
    position: relative;
    overflow: hidden;
}

.products-wrapper {
    overflow: hidden;
    width: 100%;
}

.products-row {
    display: flex;
    gap: 20px;
    transition: transform 0.3s ease;
}

.product-card {
    width: 200px;
    border: 1px solid #eee;
    padding: 10px;
    border-radius: 8px;
    flex-shrink: 0;
}

.product-img {
    width: 100%;
    height: 150px;
    object-fit: cover;
}

.price {
    font-weight: bold;
    margin-top: 5px;
}
.price-old {
    text-decoration: line-through;
    color: red;
    margin-left: 10px;
}

.price-new {
    font-weight: bold;
    color: #333;
}
.arrow {
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    background: rgba(0,0,0,0.5);
    color: #fff;
    border: none;
    padding: 5px 10px;
    cursor: pointer;
    font-size: 24px;
    z-index: 10;
    border-radius: 3px;
}

.arrow.left { left: 0; }
.arrow.right { right: 0; }

.arrow:disabled {
    opacity: 0.3;
    cursor: default;
}
</style>
