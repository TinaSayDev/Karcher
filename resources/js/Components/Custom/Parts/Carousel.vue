<template>
    <div class="carousel-wrapper">
        <div class="carousel-track">
            <div
                v-for="(slide, i) in slides"
                :key="i"
                class="slide"
                :class="{ active: index === i }"
                :style="{ backgroundImage: `url(${slide})` }"
            ></div>
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

const props = defineProps({
    slides: {
        type: Array,
        required: true
    }
});

const index = ref(0);
let interval = null;

function goTo(i) {
    index.value = i;
}

onMounted(() => {
    interval = setInterval(() => {
        index.value = (index.value + 1) % props.slides.length;
    }, 4000);
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
