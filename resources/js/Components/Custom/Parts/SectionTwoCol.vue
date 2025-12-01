<template>
    <section class="section-2col">
        <div
            class="col"
            :style="{ backgroundImage: `url(${col1})` }"
        >
            <a class="info-block" href="#">
                <h3>Бытовая техника</h3>
                <p>Техника для уборки дома и сада</p>
            </a>
        </div>

        <div
            class="col"
            :style="{ backgroundImage: `url(${col2})` }"
        >
            <a class="info-block" href="#">
                <h3>Бытовая техника</h3>
                <p>Техника для уборки дома и сада</p>
            </a>
        </div>
    </section>
</template>

<script setup>
const col1 = '/images/col1.webp'
const col2 = '/images/col2.webp'
</script>

<style scoped>
.section-2col {
    width: 100%;
    height: 720px;
    display: flex;
}

.col {
    flex: 1;
    position: relative;
    background-size: cover;
    background-position: center;
}

.info-block {
    position: absolute;
    left: 0;
    bottom: 50px;
    width: 80%;
    height: 98px;
    background: rgba(255, 255, 255, 0.8);
    transition: background 0.3s ease;
    padding: 20px 25px;
    box-sizing: border-box;
    cursor: pointer;
    text-decoration: none;
    display: flex;
    flex-direction: column;
    justify-content: center;
}

.info-block h3 {
    margin: 0;
    font-size: 28px;
    font-weight: 700;
    color: #000;
}

.info-block p {
    margin: 6px 0 0;
    font-size: 16px;
    color: #000;
}

.info-block:hover {
    background: rgba(255, 255, 255, 0.6);
}

@media (max-width: 800px) {
    .section-2col {
        flex-direction: column;
    }
}
</style>
