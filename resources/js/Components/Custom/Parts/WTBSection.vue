<template>
    <div class="wtb-section">
        <a
            v-for="(item, index) in items"
            :key="index"
            class="wtb-card"
            :href="item.link"
        >
            <div
                class="wtb-img"
                :style="{ backgroundImage: `url(${item.image})` }"
            ></div>

            <div class="wtb-text">
                <h3>{{ item.title }}</h3>
                <p>{{ item.text }}</p>
            </div>
        </a>
    </div>
</template>

<script setup>
const items = [
    {
        image: '/images/wtb/Gde-kupit.webp',
        title: 'Где купить',
        text: 'Здесь Вы можете быстро и легко найти ближайшую торговую организацию или сервисный центр.',
        link: '#',
    },
    {
        image: '/images/wtb/Internet-magazin.webp',
        title: 'Интернет магазин',
        text: 'Здесь Вы можете быстро и легко найти ближайшую торговую организацию или сервисный центр.',
        link: '#',
    },
    {
        image: '/images/wtb/Prodlenie-garantii.webp',
        title: 'Продление гарантии',
        text: 'Здесь Вы можете быстро и легко найти ближайшую торговую организацию или сервисный центр.',
        link: '#',
    },
];
</script>

<style scoped>
.wtb-section {
    width: 80%;
    margin: 0 auto;
    padding: 40px 0;
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 30px;
}

.wtb-card {
    cursor: pointer;
    overflow: hidden;
    text-align: left;
    text-decoration: none;
}

.wtb-img {
    position: relative;
    height: 195px;
    background-size: cover;
    background-position: center;
    transition: all 0.4s ease;
    overflow: hidden;
}

.wtb-img::after {
    content: 'Где купить';
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #000;
    font-size: 18px;
    font-weight: 700;
    background: rgba(241, 222, 4, 0);
    opacity: 0;
    transition: all 0.4s ease;
}

.wtb-card:hover .wtb-img::after {
    background: #ffed00;
    opacity: 1;
    top: 10px;
}

.wtb-text {
    padding: 10px 0;
    color: #2b2b2b;
}

.wtb-text h3 {
    margin: 0 0 6px;
    font-size: 15.6px;
    font-weight: 700;
}

.wtb-text p {
    margin: 0;
    font-size: 12px;
    line-height: 1.4;
}

@media (max-width: 900px) {
    .wtb-section {
        grid-template-columns: 1fr;
    }
}
</style>
