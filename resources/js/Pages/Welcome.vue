<script setup>
import DefaultLayout from '@/Layouts/DefaultLayout.vue';
import Carousel from '@/Components/Custom/Parts/Carousel.vue';
import SectionTwoCol from '@/Components/Custom/Parts/SectionTwoCol.vue'
import OffersSection from '@/Components/Custom/Parts/OffersSection.vue'
import WTBSection from '@/Components/Custom/Parts/WTBSection.vue';
import Adresses from "@/Components/Custom/Adresses.vue";
import Footer from "@/Layouts/Footer.vue";

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
document.querySelectorAll('.ripple').forEach(btn => {
    btn.addEventListener('click', function (e) {
        const rect = this.getBoundingClientRect();
        this.style.setProperty('--x', e.clientX - rect.left + 'px');
        this.style.setProperty('--y', e.clientY - rect.top + 'px');
    });
});
</script>

<template>
    <Carousel :slides="banners"/>
    <SectionTwoCol/>
    <section class="gray">
        <catalog-component/>
    </section>
    <OffersSection/>
    <WTBSection />
    <section class="window-cleaning">
        <img src="/images/window-cleaning.webp">
    </section>

    <section class="location">
            <div class="col text">
                <span class="subtitle">о компании</span>


                <p><strong>ASIA CLEAN CENTER</strong> – официальный дилер бытовой и профессиональной садовой и клининговой техники.</p>


                <p><strong>ООО "ASIA CLEAN CENTER"</strong><br>
                    <strong>Регистрирующий орган:</strong> Хокимият г. Ташкент<br>
                    <strong>Регистрационный номер:</strong> 192294454<br>
                    <strong>Юридический адрес:</strong> 100000, г. Ташкент ул. Мукимий 74<br>
                    <strong>Дата регистрации:</strong> 24.06.2014 г.</p>


                <p><strong>Дата регистрации Интернет-магазина:</strong> 11.07.2017 г.<br>
                    <strong>Регистрационный номер в Торговом реестре РУз:</strong> 387030<br>
                    <strong>Дата регистрации в Торговом реестре РУз:</strong> 17.02.2015 г.</p>


                <button class="btn-yellow ripple">Подробности</button>
            </div>
            <div class="col image" :style="{ backgroundImage: 'url(/images/location.webp)' }">
            </div>
    </section>
    <Adresses />
</template>

<style scoped>
/* location section */
.location {
    color: #999;
    font-size: 10px;
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
