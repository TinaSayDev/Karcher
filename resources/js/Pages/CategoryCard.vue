<template>
    <div class="category-card" @click="go">
        <h3>{{ category.name }}</h3>
    </div>
</template>

<script setup>
import { useRouter } from 'vue-router'
const router = useRouter()

const props = defineProps({
    category: Object
})

function go() {
    router.push(`/category/${props.category.slug}`)
}
</script>

<style scoped>
.category-card {
    cursor: pointer;
    padding: 20px;
    border: 1px solid #eee;
    border-radius: 6px;
}
</style>
