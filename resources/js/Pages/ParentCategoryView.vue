<template>
    <div class="category-page">

        <h1>{{ category.name }}</h1>
        <p v-if="category.description">{{ category.description }}</p>

        <div v-if="category.children.length">

            <div
                v-for="child in category.children"
                :key="child.id"
                class="child-block"
            >

                <!-- Обычная категория -->
                <CategoryCard
                    v-if="!child.is_leaf"
                    :category="child"
                />

                <!-- Категория без детей -->
                <LeafCategoryBlock
                    v-else
                    :category="child"
                    :products="child.products"
                />

            </div>
        </div>

        <!-- Если сама категория leaf -->
        <LeafCategoryBlock
            v-else-if="category.is_leaf"
            :category="category"
            :products="category.products"
        />
    </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import axios from '@/api/axios'
import CategoryCard from '@/components/CategoryCard.vue'
import LeafCategoryBlock from '@/components/LeafCategoryBlock.vue'

const category = ref(null)

const props = defineProps({
    slug: String
})

onMounted(async () => {
    const { data } = await axios.get(`/categories/${props.slug}`)
    category.value = data.data
})
</script>
