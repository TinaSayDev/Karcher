<template>
    <section class="location" v-if="address">
        <div class="col text">
            <span class="subtitle">о компании</span>
            <div v-html="address.text"></div>
            <a :href="addressLink" class="btn-yellow ripple">{{ address.button_text }}</a>
        </div>
        <div
            class="col image"
            :style="{ backgroundImage: 'url(' + getImageUrl(address.image) + ')' }"
        ></div>
    </section>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import axios from 'axios'

const address = ref(null)
const locale = 'ru' // можно динамически менять

const addressLink = '/about' // если ссылка статическая, или можно из API

function getImageUrl(path) {
    return path ? `/storage/${path}` : '/images/location.webp'
}

onMounted(async () => {
    try {
        const { data } = await axios.get('/homepage') // путь к API
        console.log(data)
        // берем locale или общую картинку
        address.value = {
            ...data.address, // или en/uz для текста
            image: data.address.image || data.address?.image || null
        }
    } catch (e) {
        console.error(e)
    }
})
</script>

<style scoped>
.location {
    color: #333;
    font-size: 15px;
    display: flex;
    margin: 0 auto;
    max-width: 1260px;
    padding: 60px 10px;
}

.location .col{
    flex:1;
}

.col.image{
    max-height: 444px;
    min-height: 200px; /* минимальная для маленьких экранов */
    background-size: cover;
    background-position: bottom;
    background-repeat: no-repeat;

}

.btn-yellow {
    background: #F1DE04;
    border: none;
    padding: 12px 22px;
    border-radius: 6px;
    cursor: pointer;
    font-size: 15px;
    transition: background 0.3s;
    color: #2B2B2B;
    font-weight: 700;
    margin-top: 20px;
    display: flex;
    justify-content: center;
    width: 150px;
}


.btn-yellow:hover {
    background: #ffcc00;
}


/* Ripple */
.ripple {
    position: relative;
    overflow: hidden;
}


.ripple:after {
    content: "";
    position: absolute;
    width: 10px;
    height: 10px;
    background: rgba(255,255,255,0.5);
    border-radius: 50%;
    transform: scale(0);
    opacity: 0;
    pointer-events: none;
}


.ripple:active:after {
    transform: scale(15);
    opacity: 1;
    transition: transform 0.5s, opacity 0.8s;
}
@media (max-width: 600px) {
    .location{
        flex-direction: column;
    }

    .col.image{
        width: 100%;
        min-height: 200px; /* чтобы картинка была видна */
        margin-top: 20px;
    }
}
</style>
