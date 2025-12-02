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
    '/images/banners/banner1.webp',
    '/images/banners/banner2.webp',
    '/images/banners/banner3.webp',
    '/images/banners/banner4.webp',
    '/images/banners/banner5.webp',
    '/images/banners/banner6.webp',
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
