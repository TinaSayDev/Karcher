<template>
    <DefaultLayout :title="pageTitle" :breadcrumbs="breadcrumbs">
        <div v-if="loading">Загрузка...</div>
        <div v-else-if="error">{{ error }}</div>

        <div v-else>
            <!-- НЕ листовые категории -->
            <ul v-if="items.length && !items[0].products?.length" class="products-grid">
                <li v-for="item in items" :key="item.id">
                    <a :href="`/categories/${item.slug}`" class="cat-title">
                        <img v-if="item.image" :src="`/images/categories/${item.image}`" class="cat-img" />
                        {{ item.name }}
                    </a>
                </li>
            </ul>

            <!-- Листовые категории -->
            <div v-else class="leaf-wrapper container">

                <div
                    v-for="cat in items"
                    :key="cat.id"
                    class="leaf-category flex"
                >
                    <!-- Левая колонка -->
                    <div class="leaf-header">
                        <h2>{{ cat.name }}</h2>
                        <p v-if="cat.description">{{ cat.description }}</p>
                        <a href="" class="btn-1">View more</a>
                    </div>

                    <!-- Карусель -->
                    <div class="carousel">
                        <!-- Левая стрелка -->
                        <button
                            class="nav prev"
                            v-if="cat.products.length > 3"
                            @click="cat.currentIndex = Math.max(cat.currentIndex - 1, 0)"
                        >
                            ‹
                        </button>

                        <div class="carousel-window">
                            <div
                                class="carousel-track"
                                :style="{
                                    transform: `translateX(-${cat.currentIndex * 220}px)`
                                }"
                            >
                                <div
                                    class="product-card"
                                    v-for="product in cat.products"
                                    :key="product.id"
                                >
                                    <img
                                        :src="product.image_main
                                            ? `/images/products/${product.image_main}`
                                            : '/images/noimg.png'"
                                        class="product-img"
                                    />
                                    <h4>{{ product.name }}</h4>
                                    <p class="price">{{ product.price }} €</p>
                                </div>
                            </div>
                        </div>

                        <!-- Правая стрелка -->
                        <button
                            class="nav next"
                            v-if="cat.products.length > 3"
                            @click="cat.currentIndex = Math.min(cat.currentIndex + 1, cat.products.length - 3)"
                        >
                            ›
                        </button>
                    </div>
                </div>

            </div>
        </div>
    </DefaultLayout>
</template>

<script>
import DefaultLayout from '@/Layouts/DefaultLayout.vue'
import axios from 'axios'

export default {
    components: { DefaultLayout },

    props: {
        slug: {
            type: String,
            default: null
        }
    },

    data() {
        return {
            items: [],
            category: null,
            loading: true,
            error: null,
            pageTitle: 'Каталог',
            breadcrumbs: [
                { label: 'Главная', href: '/' },
                { label: 'Каталог', href: '/categories' }
            ]
        }
    },

    watch: {
        slug: {
            handler() {
                this.loadCategories()
            },
            immediate: true
        }
    },

    methods: {
        async loadCategories() {
            this.loading = true
            this.error = null

            try {
                const headers = { 'X-Locale': this.getLocale() }

                if (!this.slug) {
                    const res = await axios.get('/api/categories', { headers })
                    this.items = res.data.data
                    this.category = null
                    this.pageTitle = 'Каталог'
                    this.breadcrumbs = [
                        { label: 'Главная', href: '/' },
                        { label: 'Каталог', href: '/categories' }
                    ]
                } else {
                    const res = await axios.get(`/api/categories/${this.slug}`, { headers })
                    this.category = res.data.category

                    this.items = res.data.items.map(cat => ({
                        ...cat,
                        currentIndex: 0
                    }))

                    this.pageTitle = this.category?.name ?? 'Категория'
                    this.breadcrumbs = [
                        { label: 'Главная', href: '/' },
                        { label: 'Каталог', href: '/categories' },
                        { label: this.category?.name }
                    ]
                }
            } catch (e) {
                console.error(e)
                this.error = 'Ошибка загрузки'
            }

            this.loading = false
        },

        getLocale() {
            return document.cookie.match(/locale=([^;]+)/)?.[1] || 'ru'
        }
    }
}
</script>

<style scoped>
.cat-title {
    font-size: 16px;
}

.leaf-category {
    margin-bottom: 40px;
    padding-bottom: 20px;
    border-bottom: 1px solid #eee;
}

.leaf-header {
    width: 375px;
}
.leaf-header h2 {
    font-size: 22px;
    margin-bottom: 10px;
}

/* ==== КНОПКА VIEW MORE ==== */
.btn-1 {
    display: inline-block;
    background: #ffcc00;
    color: #000;
    padding: 10px 18px;
    border-radius: 4px;
    font-weight: 600;
    text-align: center;
    margin-top: 20px;
    transition: 0.2s;
}

.btn-1:hover {
    background: #e6b800;
    transform: translateY(-2px);
}

/* ==== КАРТОЧКИ ==== */
.product-card {
    width: 200px;
    min-width: 200px;
    max-width: 200px;
    padding: 10px;
    border-radius: 8px;
    flex-shrink: 0;
    box-shadow: 0 0 10px rgba(0,0,0,0.06); /* мягкая тень вместо бордера */
}

.product-img {
    width: 100%;
}

.price {
    font-weight: bold;
    margin-top: 5px;
}

/* ==== КАРУСЕЛЬ ==== */
.carousel {
    position: relative;
    width: 660px; /* 3 карточки */
    /*overflow: hidden;*/
    margin-left: 50px;
}

.carousel-window {
    overflow: hidden;
    width: 100%;
}

.carousel-track {
    display: flex;
    gap: 20px;
    transition: transform 0.3s ease;
    flex-wrap: nowrap !important;
}

/* ==== СТРЕЛКИ ==== */
.nav {
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    background: rgba(255,255,255,0.9);
    border: none;
    padding: 12px 18px;
    cursor: pointer;
    font-size: 28px;
    font-weight: bold;
    border-radius: 50%;
    z-index: 10;
    transition: 0.2s;
}

.nav:hover {
    background: rgba(255,255,255,1);
    transform: translateY(-50%) scale(1.08);
}

.nav.prev {
    left: -40px;
}

.nav.next {
    right: -40px;
}

/* ========================= */
/* АДАПТИВ */
/* ========================= */

/* === Планшеты (2 карточки) === */
@media (max-width: 1024px) {
    .carousel {
        width: 440px; /* 2 карточки */
    }
}

/* === Телефоны (1 карточка) === */
@media (max-width: 640px) {
    .leaf-category {
        flex-direction: column;
    }

    .leaf-header {
        width: 100%;
        margin-bottom: 20px;
    }

    .carousel {
        width: 220px; /* 1 карточка */
        margin: 0 auto;
    }

    .nav.prev {
        left: -25px;
    }
    .nav.next {
        right: -25px;
    }
}
/* === Мобильная версия со свайпом === */
@media (max-width: 640px) {
    /* Скрываем стрелки полностью */
    .nav {
        display: none !important;
    }

    /* Делаем горизонтальный скролл пальцем */
    .carousel-window {
        overflow-x: auto;
        overflow-y: hidden;
        scroll-snap-type: x mandatory;
        -webkit-overflow-scrolling: touch;
    }

    .carousel-track {
        display: flex;
        gap: 16px;
        width: max-content;
        transform: none !important;  /* отключаем translateX — не нужен без стрелок */
    }

    .product-card {
        scroll-snap-align: start;
    }
}

</style>

