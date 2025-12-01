<script setup>
import DefaultLayout from '@/Layouts/DefaultLayout.vue';
import Carousel from '@/Components/Custom/Parts/Carousel.vue';
import SectionTwoCol from '@/Components/Custom/Parts/SectionTwoCol.vue'
import OffersSection from '@/Components/Custom/Parts/OffersSection.vue'
import WTBSection from '@/Components/Custom/Parts/WTBSection.vue';


defineOptions({
    layout: DefaultLayout
})

const banners = [
    new URL('@/images/banners/banner1.jpg', import.meta.url).href,
    new URL('@/images/banners/banner2.jpg', import.meta.url).href,
    new URL('@/images/banners/banner3.jpg', import.meta.url).href,
    new URL('@/images/banners/banner4.jpg', import.meta.url).href,
    new URL('@/images/banners/banner5.jpg', import.meta.url).href,
    new URL('@/images/banners/banner6.jpg', import.meta.url).href,
];

</script>

<template>
    <Carousel :slides="banners"/>
    <SectionTwoCol/>
    <section class="gray">
        <catalog-component/>
    </section>
    <OffersSection/>
    <WTBSection />
</template>
