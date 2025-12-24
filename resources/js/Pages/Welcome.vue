<script setup>
import DefaultLayout from '@/Layouts/DefaultLayout.vue';
import Carousel from '@/Components/Custom/Parts/Carousel.vue';
import SectionTwoCol from '@/Components/Custom/Parts/SectionTwoCol.vue'
import OffersSection from '@/Components/Custom/Parts/OffersSection.vue'
import WTBSection from '@/Components/Custom/Parts/WTBSection.vue';
import Adresses from "@/Components/Custom/Adresses.vue";
import LocationSection from "@/Components/Custom/Parts/LocationSection.vue";
import { ref, onMounted } from 'vue'
import axios from 'axios'

const chosenArticle = ref(null)

function getImageUrl(path) {
    return path ? `/storage/${path}` : '/images/window-cleaning.webp'
}
onMounted(async () => {
    try {
        const { data } = await axios.get('/homepage') // путь к твоему API
        chosenArticle.value = data.chosenArticle
    } catch (e) {
        console.error(e)
    }
})

defineOptions({
    layout: DefaultLayout
})

document.querySelectorAll('.ripple').forEach(btn => {
    btn.addEventListener('click', function (e) {
        const rect = this.getBoundingClientRect();
        this.style.setProperty('--x', e.clientX - rect.left + 'px');
        this.style.setProperty('--y', e.clientY - rect.top + 'px');
    });
});
</script>

<template>
    <Carousel/>
    <SectionTwoCol/>
    <section class="gray">
        <catalog-component/>
    </section>
    <OffersSection/>
    <WTBSection />
    <section class="window-cleaning" v-if="chosenArticle">
        <a :href="chosenArticle.link">
            <img :src="getImageUrl(chosenArticle.image)" alt="Chosen Article">
        </a>
    </section>

    <LocationSection />
    <Adresses />
</template>

<style scoped>
/* location section */

.text p {
    color: #666;
    font-size: 15px;
    line-height: 1.5;
    margin-bottom: 18px;
}


.text strong {
    color: #333;
    font-weight: 600;
}


.image img {
    width: 100%;
    display: block;
}


/* hover animations */
.window-cleaning {
    position: relative;
    display: inline-block;
    overflow: hidden;
    cursor: pointer;
}

.window-cleaning img {
    display: block;
    width: 100%;
}

/* Псевдоэлемент для засветления */
.window-cleaning::after {
    content: "";
    position: absolute;
    inset: 0;
    background: rgba(255, 255, 255, 0.6); /* степень засветления */
    opacity: 0;
    pointer-events: none;
}

/* Анимация засветления */
@keyframes flashLight {
    0% { opacity: 0; }
    40% { opacity: 1; }   /* плавное появление */
    100% { opacity: 0; }  /* плавное исчезновение */
}

/* Запуск анимации */
.window-cleaning:hover::after {
    animation: flashLight 0.5s ease forwards;
}

</style>
