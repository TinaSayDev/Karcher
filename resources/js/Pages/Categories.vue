<template>
    <DefaultLayout :title="pageTitle" :breadcrumbs="breadcrumbs">
            <div v-if="loading">Загрузка...</div>
            <div v-else-if="error">{{ error }}</div>
            <ul v-else class="products-grid">
                <li v-for="item in items" :key="item.id">
                    <a :href="`/categories/${item.slug}`" class="cat-title">
                        <img v-if="item.image" :src="`/images/categories/${item.image}`" class="cat-img" />
                        {{ item.name }}
                    </a>
                </li>
            </ul>
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
                    // корневые категории
                    const res = await axios.get('/api/categories', { headers })
                    this.items = res.data.data
                    this.category = null
                    this.pageTitle = 'Каталог'
                    this.breadcrumbs = [
                        { label: 'Главная', href: '/' },
                        { label: 'Каталог', href: '/categories' }
                    ]
                } else {
                    // дочерние категории
                    const res = await axios.get(`/api/categories/${this.slug}`, { headers })
                    this.category = res.data.category
                    this.items = res.data.items
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
            // получаем выбранный язык из cookie или localStorage
            return document.cookie.match(/locale=([^;]+)/)?.[1] || 'ru'
        }
    }
}
</script>

<style scoped>
.cat-title{
    font-size: 16px;
}
</style>
