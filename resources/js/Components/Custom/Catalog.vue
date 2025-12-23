<template>
    <section>
        <!-- Фильтры -->
        <nav class="catalog-nav">
        <h3>Лучшие предложения</h3>
        <div class="filters">
            <button
                v-for="item in items"
                :key="item.key"
                :class="{ active: currentFilter === item.key }"
                @click="loadProducts(item.key, true)"
            >
                {{ item.label }}
            </button>
        </div>
        </nav>
        <!-- Продукты -->
        <div class="products-grid">
            <ProductCard
                v-for="product in products"
                :key="product.id"
                :product="product"
            />
        </div>

        <!-- Ошибка -->
        <div v-if="error" class="error">
            {{ error }}
        </div>

        <!-- Загрузка -->
        <div v-if="loading" class="loading">
            Загрузка...
        </div>

        <!-- Кнопка загрузки -->
        <button
            v-if="hasMore && !loading"
            class="load-more"
            @click="loadProducts(currentFilter)"
        >
            Загрузить ещё
        </button>
    </section>
</template>

<script>
import ProductCard from './ProductCard.vue'

export default {
    components: { ProductCard },
    data() {
        return {
            items: [
                { key: 'hit', label: this.$page.props.catalog_menu.hit },
                { key: 'new', label: this.$page.props.catalog_menu.new },
                { key: 'recommended', label: this.$page.props.catalog_menu.recommended},
                { key: 'sale', label: this.$page.props.catalog_menu.sale },
                { key: 'all', label: this.$page.props.catalog_menu.all_catalog },
            ],
            products: [],
            loading: false,
            error: null,
            limit: 8,
            offset: 0,
            hasMore: true,
            currentFilter: 'hit',
        }
    },
    methods: {
        async loadProducts(filterKey, reset = false) {
            if (this.loading) return

            this.loading = true
            this.error = null

            try {
                if (reset) {
                    this.products = []
                    this.offset = 0
                    this.hasMore = true
                    this.currentFilter = filterKey
                }

                const response = await fetch(
                    `/api/products/filter?filter=${filterKey}&limit=${this.limit}&offset=${this.offset}`
                )
                const json = await response.json()

                this.products.push(...json.data)
                this.hasMore = json.hasMore
                this.offset += this.limit
            } catch (e) {
                this.error = 'Ошибка загрузки данных'
            } finally {
                this.loading = false
            }
        },
    },
    mounted() {
        this.loadProducts(this.currentFilter, true)
    }
}
</script>

<style scoped>
.products-block {
    margin-top: 30px;
}

.filters {
    display: flex;
    gap: 16px;
}

.filters button {
    background: none;
    border: none;
    cursor: pointer;
    padding-bottom: 4px;
    border-bottom: 2px solid transparent;
    color:#666666;
}

.filters button.active {
    border-color: #ffd800;
}

.products-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 20px;
    max-width: 1348px;
}

.loading,
.error {
    margin-top: 20px;
    text-align: center;
}
.load-more {
    display: block;
    margin: 30px auto 0;
    padding: 10px 20px;
    border: 1px solid #ffd800;
    font-weight: 400;
    cursor: pointer;
    border-radius: 5px;
    background: transparent;
    color: #000;
    transition:
        background 0.3s ease,
        color 0.3s ease,
        transform 0.2s ease,
        box-shadow 0.2s ease;
}

.load-more:hover {
    background: #ffd800;
    color: #000;
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(0,0,0,0.2);
}

.load-more:active {
    transform: translateY(0);
    box-shadow: 0 2px 4px rgba(0,0,0,0.2);
}


@media (max-width: 1000px) {
    .products-grid {
        grid-template-columns: repeat(2, 1fr);
    }
}
@media (max-width: 800px) {
    .products-grid {
        grid-template-columns: repeat(1, 1fr);
    }
    .filters{
        gap: 5px;
        flex-direction: column;
        align-items: flex-start;
        margin-top: 15px;
    }
}
</style>
