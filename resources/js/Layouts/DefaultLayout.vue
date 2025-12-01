<template>
    <div>
        <TopMenu />
        <MainMenu />

        <!-- Заголовок страницы -->
        <h1 v-if="title" class="page-title">{{ title }}</h1>

        <!-- Контент страницы -->
        <slot></slot>

        <Footer />
    </div>
</template>

<script>
import TopMenu from './TopMenu.vue';
import MainMenu from './MainMenu.vue';
import Footer from './Footer.vue';

export default {
    name: 'DefaultLayout',
    props: ['title'],
    components: {
        TopMenu,
        MainMenu,
        Footer,
    }
};

</script>

