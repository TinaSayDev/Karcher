<template>
    <DefaultLayout :title="pageTitle" :breadcrumbs="breadcrumbs">
        <div v-if="!cats && !category">Загрузка...</div>
        <CategoryGrid
            v-if="forceGrid"
            :products="category.products"
        />
        <!-- Категории верхнего уровня или дочерние категории -->
        <ul v-else-if="displayCategories.length && !hasProducts(displayCategories[0])" class="products-grid">
            <li v-for="cat in displayCategories" :key="cat.id">
                <a :href="`/categories/${cat.slug}`" class="cat-title">
                    <img
                        v-if="cat.image"
                        :src="getImageUrl(cat.image, 'categories')"
                        class="cat-img"
                    />

                </a>
                <p>{{ cat.name }}</p>
            </li>
        </ul>


        <!-- Крайние категории с продуктами -->
        <div v-else class="leaf-wrapper container">
            <div v-for="cat in displayCategories" :key="cat.id" class="leaf-category flex">
                <div class="leaf-header">
                    <h2>{{ cat.name }}</h2>
                    <p v-if="cat.description">{{ cat.description }}</p>
                    <p>The RoboCleaner robot vacuum cleaner from Kercher is capable of cleaning any floor coverings common in everyday life, even in your absence.</p>
                    <a :href="`/categories/${cat.slug}?grid=1`" class="btn-1">Подробнее</a>
                </div>

                <ProductCarousel v-if="cat.products?.length" :products="cat.products" />
            </div>
        </div>

        <div class="home-link products-grid container"><a href="/">Back to home</a></div>

    </DefaultLayout>
</template>

<script>
import DefaultLayout from '@/Layouts/DefaultLayout.vue'
import ProductCarousel from "@/Pages/ProductCarousel.vue";
import CategoryGrid from "@/Pages/CategoryGrid.vue";

export default {
    props: {
        locale: String,
        cats: Array,          // категории верхнего уровня
        category: Object,     // текущая категория (если выбран дочерний уровень)
    },

    components: { DefaultLayout, ProductCarousel,CategoryGrid },
    mounted() {
       console.log(this.$page.props)
    },

    computed: {
        pageTitle() {
            const mainmenu = this.$page.props.mainmenu || {};
            return this.category?.name ?? mainmenu.catalog
        },

        breadcrumbs() {
            const base = [
                { label: this.$page.props.mainmenu.home, href: '/' },
                { label: this.$page.props.mainmenu.catalog, href: '/categories' }
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
        },
        forceGrid() {
            return this.category?.forceGrid
        },

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
<style scoped>
.home-link{
    text-align: right;
    color: #333333;
    margin: 50px 5px;
}
.leaf-header{
    width: 375px;
    padding: 0 10px;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
}
.leaf-header h2{
    font-size: 32px;
    color: #000000;
    font-weight: 500;
}
.leaf-header a{
    display: flex;
    align-content: center;
    background: #FFF000;
    color: #000000;
    padding: 16px 32px;
    width: 156px;
    border-radius: 16px;
    margin-top: 32px;
}
.leaf-category{
    margin-bottom: 20px;
}

@media (max-width: 900px) {
    .leaf-category {
        flex-direction: column;
    }
}
</style>
