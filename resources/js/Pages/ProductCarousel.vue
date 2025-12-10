<template>
    <div class="leaf-products">
        <button
            class="arrow left"
            @click="prev"
            :disabled="currentIndex === 0"
        >‹</button>

        <div class="products-wrapper">
            <div class="products-row" :style="{ transform: `translateX(-${currentIndex * cardWidth}px)` }">
                <div class="product-card" v-for="product in products" :key="product.id">
                    <a :href="`/products/${product.slug}`">

                        <img
                            :src="product.image_main ? `/images/products/${product.image_main}` : '/images/noimg.png'"
                            class="product-img"
                        />
                        <h4>{{ product.name }}</h4>
                        <p class="price">{{ product.price }} €</p>
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
export default {
    props: {
        products: {
            type: Array,
            default: () => []
        }
    },
    data() {
        return {
            currentIndex: 0,
            cardWidth: 220,
            visibleCards: 3
        }
    },
    computed: {
        maxIndex() {
            return Math.max(0, this.products.length - this.visibleCards)
        }
    },
    methods: {
        prev() {
            if (this.currentIndex > 0) this.currentIndex--
        },
        next() {
            if (this.currentIndex < this.maxIndex) this.currentIndex++
        },
        updateVisibleCards() {
            const width = window.innerWidth
            if (width < 600) {
                this.visibleCards = 1
                this.cardWidth = 180
            } else if (width < 900) {
                this.visibleCards = 2
                this.cardWidth = 200
            } else {
                this.visibleCards = 3
                this.cardWidth = 220
            }
        }
    },
    mounted() {
        this.updateVisibleCards()
        window.addEventListener('resize', this.updateVisibleCards)
    },
    beforeUnmount() {
        window.removeEventListener('resize', this.updateVisibleCards)
    }
}
</script>

<style scoped>
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
