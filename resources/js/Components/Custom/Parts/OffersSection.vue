<template>
    <div class="gray">
    <div class="section-wrapper">
        <h2>Выгодные предложения</h2>

        <div class="offers-row">

            <a
                v-for="(offer, index) in offers"
                :key="index"
                :href="`/blog/${offer.slug}`"
                class="offer-col"
                :style="{ backgroundImage: `url(/storage/${offer.image})` }"
            >
                <div class="offer-info">
                    <div class="date">{{ offer.date }}</div>
                    <div class="title">{{ offer.title }}</div>
                </div>
            </a>
        </div>
    </div>
    </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';

const offers = ref([]);

onMounted(async () => {
    try {
        const response = await fetch('/api/offers'); // API для промо-постов
        offers.value = await response.json();
    } catch (error) {
        console.error('Ошибка при загрузке предложений:', error);
    }
});
</script>

<style scoped>
.section-wrapper {
    padding: 60px 10px;
    max-width: 1348px;
    margin: 0 auto;
}

.section-wrapper h2 {
    margin: 0 0 20px;
    font-weight: 400;
    color: #333333;
    font-size: 24px;
}

.offers-row {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 30px;
    height: 436px;
}
.offer-col {
    cursor: pointer;
    position: relative;
    background-size: cover;
    background-position: center;
    border-radius: 3px;
    overflow: hidden;
    transition: transform 0.3s ease, filter 0.3s ease;
}
.offer-info {
    position: absolute;
    left: 0;
    bottom: 0;
    width: 100%;
    padding: 18px 22px;
    background: linear-gradient(0deg, rgba(0,0,0,0.7), rgba(0,0,0,0));
    color: #fff;
}

.offer-info .date {
    font-size: 14px;
    opacity: 0.9;
}

.offer-info .title {
    font-size: 18px;
    font-weight: 400;
    margin-top: 4px;
}

.offer-col:hover {
    filter: brightness(0.7);
    transform: translateY(-1px); /* поднимаем на 5px */
}

@media (max-width: 1024px) {
    .offers-row {
        grid-template-columns: repeat(2, 1fr);
        height: auto;
    }
    .offer-col {
        height: 300px;
    }
}

@media (max-width: 600px) {
    .offers-row {
        grid-template-columns: 1fr;
    }
    .offer-col {
        height: 260px;
    }
}
</style>
