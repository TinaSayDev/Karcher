<template>
    <DefaultLayout :title="product.name" :breadcrumbs="breadcrumbs">
        <div v-if="loading">Загрузка...</div>
        <div v-else-if="error">{{ error }}</div>

        <div v-else class="product-detail container">
            <div class="product-detail-flex">
                <!-- Карусель изображений -->
                <div class="product-carousel">
                    <img
                        :src="mainImage ? `/images/products/${mainImage}` : '/images/noimg.png'"
                        class="main-img"
                    />

                    <div class="thumbs">
                        <img
                            v-for="(img, index) in product.images"
                            :key="index"
                            :src="`/images/products/${img}`"
                            class="thumb-img"
                            @click="mainImage = img"
                        />
                    </div>
                </div>

                <!-- Текстовый блок -->
                <div class="product-info">
                    <h1>{{ product.name }}</h1>
                    <p><strong>Code:</strong> {{ product.code }}</p>
                    <p><strong>Category:</strong> {{ product.category?.name }}</p>
                    <p v-if="product.short_description"><strong>Description:</strong> {{ product.short_description }}</p>
                </div>
            </div>

            <!-- Tabs -->
            <ProductTabs :tabs="product.tabs" />

            <RelatedProducts :products="relatedProducts" />

        </div>
    </DefaultLayout>
</template>

<script>
import DefaultLayout from '@/Layouts/DefaultLayout.vue'
import ProductTabs from "@/Components/Custom/ProductTabs.vue";
import RelatedProducts from "@/Components/Custom/RelatedProducts.vue";
import axios from 'axios'

export default {
    components: { DefaultLayout, ProductTabs, RelatedProducts },

    props: {
        slug: {
            type: String,
            required: true,
        },
    },

    data() {
        return {
            product: {},
            loading: true,
            error: null,
            breadcrumbs: [],
            mainImage: null,
            relatedProducts: [], // <-- сюда будут подтягиваться товары из той же категории
        }
    },

    watch: {
        slug: {
            handler() {
                this.loadProduct()
            },
            immediate: true
        }
    },

    methods: {
        async loadProduct() {
            this.loading = true
            this.error = null

            try {
                const headers = { 'X-Locale': document.cookie.match(/locale=([^;]+)/)?.[1] || 'ru' }
                const res = await axios.get(`/api/products/${this.slug}`, { headers })

                this.product = res.data.data
                this.mainImage = this.product.image_main ?? this.product.images?.[0]
                // Подтягиваем связанные товары из этой же категории
                const related = await axios.get(`/api/categories/${this.product.category_id}/products`, { headers })
                console.log(related);       // что приходит
                console.log(related.data);  // должно быть массив
                // Фильтруем, чтобы не было текущего продукта в списке

                this.relatedProducts = related.data.data.filter(p => p.id !== this.product.id)



                this.breadcrumbs = [
                    { label: 'Главная', href: '/' },
                    { label: 'Каталог', href: '/categories' },
                    { label: this.product.category?.name, href: `/categories/${this.product.category?.slug}` },
                    { label: this.product.name },
                ]
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

.product-carousel {
    flex: 1;
    max-width: 578px;
}

.main-img {
    width: 100%;
    margin-bottom: 10px;
    border-radius: 5px;
    border: 1px solid #cccccc;
}

.thumbs {
    display: flex;
    gap: 10px;
    justify-content: space-between;
}

.thumb-img {
    width: 121px;
    cursor: pointer;
    border-radius: 5px;
}

.product-info {
    flex: 1;
    min-width: 300px;
}

.product-info h1 {
    margin-bottom: 15px;
}

.product-info ul {
    padding-left: 20px;
}

.product-info ul li {
    margin-bottom: 5px;
}
</style>
