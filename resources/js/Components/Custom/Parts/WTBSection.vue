<template>
    <div class="wtb-section">
        <a
            v-for="item in items"
            :key="item.link"
            class="wtb-card"
            :href="item.link"
        >
            <div
                class="wtb-img"
                :data-title="item.title"
                :style="{ backgroundImage: `url(/storage/${item.image})` }"
            ></div>

            <div class="wtb-text">
                <h3>{{ item.title }}</h3>
                <p v-html="item.text"></p>
            </div>
        </a>
    </div>
</template>

<script setup>
    import { ref, onMounted } from 'vue';

    const items = ref([]);

    onMounted(async () => {
    try {
    const response = await fetch('/homepage');
    const data = await response.json();

    // faq — это объект { faq-1: {}, faq-2: {}, faq-3: {} }
    items.value = Object.values(data.faq ?? {});
} catch (error) {
    console.error('Ошибка загрузки FAQ секций:', error);
}
});
</script>


<style scoped>
.wtb-section {
    max-width: 1260px;
    margin: 0 auto;
    padding: 100px 0 50px 0;
    margin-bottom: 50px;
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 30px;
    border-bottom: 1px solid #eee;
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
    content: attr(data-title);
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
        padding: 0;
        margin-bottom: 0;
    }

    .wtb-text{
        margin: 15px;
    }
}
</style>
