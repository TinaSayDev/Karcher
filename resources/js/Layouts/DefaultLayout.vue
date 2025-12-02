<template>
    <div>
        <TopMenu/>
        <MainMenu/>

        <!-- Заголовок страницы -->
        <h1 v-if="title" class="page-title">{{ title }}</h1>


        <!-- Breadcrumbs -->
        <Breadcrumbs :items="breadcrumbs"/>

        <!-- Контент страницы -->
        <slot/>
        <Footer/>
    </div>
</template>

<script>
import TopMenu from './TopMenu.vue';
import MainMenu from './MainMenu.vue';
import Footer from './Footer.vue';
import Breadcrumbs from './Breadcrumbs.vue';


export default {
    name: 'DefaultLayout',
    props: {
        title: {type: String, default: ""},
        breadcrumbs: {type: Array, default: () => []}
    },
    components: {
        TopMenu,
        MainMenu,
        Footer,
        Breadcrumbs
    }
};

</script>

