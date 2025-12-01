<template>
    <div>
        <topmenu />
        <mainmenu />

        <!-- Заголовок страницы -->
        <h1 v-if="title" class="page-title">{{ title }}</h1>

        <!-- Контент страницы -->
        <slot></slot>

        <footer-component />
    </div>
</template>

<script>
import TopMenu from './TopMenu.vue';
import MainMenu from './MainMenu.vue';
import FooterComponent from './Footer.vue';

export default {
    name: 'DefaultLayout',
    props: {
        title: String
    },
    components: {
        TopMenu,
        MainMenu,
        FooterComponent,
    }
};
</script>

<style scoped>
.page-title {
    font-family: 'Montserrat', sans-serif;
    text-align: center;
    margin: 40px 0;
    font-size: 36px;
    color: #333;
}
</style>
