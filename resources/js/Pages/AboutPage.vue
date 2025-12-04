<template>
    <DefaultLayout :title="page?.title || 'О нас'">
        <div class="container">
            <h1>{{ page?.title }}</h1>
            <div v-html="page?.content"></div>
        </div>
    </DefaultLayout>
</template>

<script>
import DefaultLayout from '@/Layouts/DefaultLayout.vue'

export default {
    components: { DefaultLayout },
    props: {
        page: Object
    }
}
</script>

<style scoped>
.container {
    max-width: 900px;
    margin: 0 auto;
    padding: 30px;
}
h1 {
    font-size: 28px;
    margin-bottom: 20px;
}
</style>
