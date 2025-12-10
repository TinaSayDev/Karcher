<template>
    <DefaultLayout :title="product.name" :breadcrumbs="breadcrumbs">
        <div v-if="loading">Загрузка...</div>
        <div v-else-if="error">{{ error }}</div>

        <div v-else class="product-detail container">
            <div class="product-detail-flex">
                <!-- Слева: Карусель изображений -->
                <div class="product-carousel">
                    <img
                        :src="mainImage ? getImageUrl(mainImage) : '/images/noimg.png'"
                        class="main-img"
                    />

                    <div class="thumbs">
                        <img
                            v-for="(img, index) in allImages"
                            :key="index"
                            :src="getImageUrl(img)"
                            class="thumb-img"
                            :class="{ active: img === mainImage }"
                            @click="mainImage = img"
                        />
                    </div>
                </div>

                <!-- Справа: Текстовая информация -->
                <div class="product-info">
                    <h1>{{ product.name }}</h1>
                    <p><strong>Code:</strong> {{ product.code }}</p>
                    <p><strong>Category:</strong>
                        <a :href="`/categories/${product.category?.slug}`">{{ product.category?.name }}</a>
                    </p>
                    <p v-if="product.short_description">
                        <strong>Description:</strong> {{ product.short_description }}
                    </p>
                    <p><strong>Price:</strong> {{ product.price_new }} €</p>
                </div>
            </div>

            <!-- Related Products -->
            <RelatedProducts v-if="relatedProducts.length" :products="relatedProducts" />
        </div>
    </DefaultLayout>
</template>

<script>
import DefaultLayout from '@/Layouts/DefaultLayout.vue'
import RelatedProducts from "@/Components/Custom/RelatedProducts.vue";
import axios from 'axios'

export default {
    components: { DefaultLayout, RelatedProducts },

    props: {
        slug: { type: String, required: true }
    },

    data() {
        return {
            product: {},
            loading: true,
            error: null,
            breadcrumbs: [],
            mainImage: null,
            relatedProducts: [],
        }
    },

    watch: {
        slug: { handler: 'loadProduct', immediate: true }
    },

    computed: {
        allImages() {
            const imgs = []
            if (this.product.image_main) imgs.push(this.product.image_main)
            if (this.product.images?.length) imgs.push(...this.product.images)
            return imgs.slice(0, 5) // максимум 5 изображений
        }
    },

    methods: {
        getImageUrl(filename) {
            return filename.startsWith('products/')
                ? `/storage/${filename}`
                : `/storage/products/${filename}`
        },

        async loadProduct() {
            this.loading = true
            this.error = null

            try {
                const locale = document.cookie.match(/locale=([^;]+)/)?.[1] || 'ru'
                const headers = { 'X-Locale': locale }

                const res = await axios.get(`/api/products/${this.slug}`, { headers })
                this.product = res.data.data
                this.mainImage = this.product.image_main ?? this.product.images?.[0]

                // Breadcrumbs
                this.breadcrumbs = [
                    { label: 'Главная', href: '/' },
                    { label: 'Каталог', href: '/categories' },
                    { label: this.product.category?.name, href: `/categories/${this.product.category?.slug}` },
                    { label: this.product.name }
                ]

                // Related products из той же категории (не включая текущий продукт)
                if (this.product.category?.products) {
                    this.relatedProducts = this.product.category.products
                        .filter(p => p.id !== this.product.id)
                }

            } catch (e) {
                console.error(e)
                this.error = 'Ошибка загрузки'
            }

            this.loading = false
        }
    }
}
</script>

<style scoped>
.product-detail-flex {
    display: flex;
    flex-wrap: wrap;
    gap: 30px;
}

/* Карусель изображений */
.product-carousel {
    flex: 1;
    max-width: 578px;
}

.main-img {
    width: 100%;
    border-radius: 5px;
    border: 1px solid #ccc;
    margin-bottom: 10px;
}

.thumbs {
    display: flex;
    gap: 10px;
}

.thumb-img {
    width: 100px;
    height: 80px;
    object-fit: cover;
    cursor: pointer;
    border-radius: 5px;
    border: 2px solid transparent;
}

.thumb-img.active {
    border-color: #007bff;
}

/* Текстовая информация */
.product-info {
    flex: 1;
    min-width: 300px;
}

.product-info h1 {
    margin-bottom: 15px;
}

.product-info a {
    color: #007bff;
    text-decoration: none;
}
</style>
