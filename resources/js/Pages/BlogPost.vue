<template>
    <DefaultLayout :title="post.title">
        <div class="container">
            <h1 class="text-3xl font-bold mb-4">{{ post.title }}</h1>

            <p class="mb-6 text-gray-600">{{ post.excerpt }}</p>

            <div v-html="post.content" class="prose max-w-full"></div>
        </div>
    </DefaultLayout>
</template>

<script>
import DefaultLayout from '@/Layouts/DefaultLayout.vue'

export default {
    components: { DefaultLayout },
    props: {
        post: Object
    }
}
</script>

<style scoped>
/* если нужно, добавь свои стили */
</style>
