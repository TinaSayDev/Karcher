<template>
    <DefaultLayout :title="pageTitle" :breadcrumbs="breadcrumbs">
        <div v-if="!cats && !category">Загрузка...</div>

        <!-- Категории верхнего уровня или дочерние категории -->
        <ul v-if="displayCategories.length && !hasProducts(displayCategories[0])" class="products-grid">
            <li v-for="cat in displayCategories" :key="cat.id">
                <a :href="`/categories/${cat.slug}`" class="cat-title">
                    <img
                        v-if="cat.image"
                        :src="getImageUrl(cat.image, 'categories')"
                        class="cat-img"
                    />
                    {{ cat.name }}
                </a>
            </li>
        </ul>
        <!-- Листовые категории с продуктами -->
        <div v-else class="leaf-wrapper container">
            <div v-for="cat in displayCategories" :key="cat.id" class="leaf-category flex">
                <div class="leaf-header">
                    <h2>{{ cat.name }}</h2>
                    <p v-if="cat.description">{{ cat.description }}</p>
                    <a :href="`/categories/${cat.slug}`" class="btn-1">Подробнее</a>
                </div>

                <ProductCarousel v-if="cat.products?.length" :products="cat.products" />
            </div>
        </div>

    </DefaultLayout>
</template>

<script>
import DefaultLayout from '@/Layouts/DefaultLayout.vue'
import ProductCarousel from "@/Pages/ProductCarousel.vue";

export default {
    props: {
        locale: String,
        cats: Array,          // категории верхнего уровня
        category: Object,     // текущая категория (если выбран дочерний уровень)
    },

    mounted() {
        console.log(this.$props);
    },

    components: { DefaultLayout, ProductCarousel },

    computed: {
        pageTitle() {
            return this.category?.name || 'Каталог'
        },

        breadcrumbs() {
            const base = [
                { label: 'Главная', href: '/' },
                { label: 'Каталог', href: '/categories' }
            ]
            if (this.category) {
                base.push({ label: this.category.name })
            }
            return base
        },

        // категории для отображения на текущем уровне
        displayCategories() {
            if (this.category?.children?.length) {
                return this.category.children.map(cat => ({ ...cat, currentIndex: 0 }))
            }
            return this.cats?.map(cat => ({ ...cat, currentIndex: 0 })) || []
        }
    },

    methods: {
        // проверка: есть ли продукты у категории
        hasProducts(cat) {
            return cat.products && cat.products.length > 0
        },

        getImageUrl(filename, folder) {
            if (!filename) return '/images/noimg.png'
            if (filename.startsWith(folder + '/')) return `/storage/${filename}`
            return `/storage/${folder}/${filename}`
        }
    }
}
</script>
