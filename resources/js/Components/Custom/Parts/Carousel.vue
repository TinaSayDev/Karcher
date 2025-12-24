<template>
    <div class="carousel-wrapper">
        <div class="carousel-track">
            <a
                v-for="(slide, i) in slides"
                :key="i"
                :href="slide.link"
                class="slide"
                :class="{ active: index === i }"
                :style="{ backgroundImage: `url(${slide.image})` }"
            ></a>

        </div>

        <div class="dots">
            <div
                v-for="(s, i) in slides"
                :key="i"
                class="dot"
                :class="{ active: index === i }"
                @click="goTo(i)"
            ></div>
        </div>
    </div>
</template>

<script setup>
import { ref, onMounted, onBeforeUnmount } from 'vue';
import axios from 'axios';

const locale = document.documentElement.lang || 'ru';

const slides = ref([]); // <--- реативный массив для баннеров из API
const index = ref(0);
let interval = null;

function goTo(i) {
    index.value = i;
}

// Подгружаем баннеры с API
async function loadBanners() {
    try {
        const { data } = await axios.get(`/api/banners?locale=${locale}`);
        slides.value = data.map(b => ({
            image: b.image,
            link: b.link || '#'
        }));
    } catch (error) {
        console.error('Ошибка загрузки баннеров', error);
    }
}

onMounted(() => {
    loadBanners().then(() => {
        if (!slides.value.length) return;

        interval = setInterval(() => {
            index.value = (index.value + 1) % slides.value.length;
        }, 4000);
    });
});

onBeforeUnmount(() => {
    clearInterval(interval);
});

</script>

<style scoped>
.carousel-wrapper {
    position: relative;
    width: 100%;
    height: 510px;
    overflow: hidden;
}

/* Slides */
.carousel-track {
    width: 100%;
    height: 100%;
    position: relative;
}

.slide {
    position: absolute;
    inset: 0;
    background-size: cover;
    background-position: center;

    opacity: 0;
    transform: translateX(20px);
    transition: opacity 0.8s ease, transform 0.8s ease;
}

.slide.active {
    opacity: 1;
    transform: translateX(0);
}

/* dots */
.dots {
    position: absolute;
    bottom: 28px;
    left: 50%;
    transform: translateX(-50%);
    display: flex;
    gap: 10px;
}

.dot {
    width: 12px;
    height: 12px;
    border-radius: 50%;
    background: rgba(255,255,255,0.5);
    cursor: pointer;
    transition: 0.3s;
}

.dot.active {
    background: #fff;
}
</style>
