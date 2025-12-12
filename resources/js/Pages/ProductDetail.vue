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
                    <p><strong>Price:</strong> {{ formatPrice(product.price_new) }} €</p>
                </div>
            </div>

            <ProductTabs
                :description="product.description"
                :specifications="product.specifications"
                :equipment="product.equipment" />


            <!-- Related Products -->
            <RelatedProducts v-if="relatedProducts.length" :products="relatedProducts" />
        </div>
    </DefaultLayout>
</template>

<script>
import DefaultLayout from '@/Layouts/DefaultLayout.vue'
import RelatedProducts from "@/Components/Custom/RelatedProducts.vue";
import ProductTabs from "@/Components/Custom/ProductTabs.vue";
import { formatPrice } from '@/utils/formatPrice.js';

export default {
    components: { DefaultLayout, RelatedProducts, ProductTabs },

    props: {
        product: { type: Object, required: true },
        locale: { type: String, required: true }
    },

    data() {
        return {
            mainImage: this.product.image_main ?? this.product.images?.[0],
        }
    },

    computed: {
        allImages() {
            const imgs = []
            if (this.product.image_main) imgs.push(this.product.image_main)
            if (this.product.images?.length) imgs.push(...this.product.images)
            return imgs.slice(0, 5)
        },

        relatedProducts() {
            return this.product.category?.products?.filter(
                p => p.id !== this.product.id
            ) ?? []
        },

        breadcrumbs() {
            return [
                { label: 'Главная', href: '/' },
                { label: 'Каталог', href: '/categories' },
                { label: this.product.category?.name, href: `/categories/${this.product.category?.slug}` },
                { label: this.product.name }
            ]
        }
    },

    methods: {
        getImageUrl(filename) {
            return filename.startsWith('products/')
                ? `/storage/${filename}`
                : `/storage/products/${filename}`
        },
        formatPrice,
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
