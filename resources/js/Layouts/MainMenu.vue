<template>
    <nav class="main-menu">
        <a href="#"><img src="/storage/karcher_logo.png" width="123" height="32" alt=""></a>
        <ul>
            <li v-for="item in items" :key="item.label">
                <Link :href="item.url">
                    <span>{{ item.label }}</span>
                    <div class="line top"></div>
                    <div class="line bottom"></div>
                </Link>
            </li>
        </ul>
    </nav>
</template>

<script setup>
import { Link } from '@inertiajs/vue3'
const items = [
    { label: "КАТАЛОГ", url: "/catalog" },
    { label: "ДЛЯ ДОМА И САДА", url: "/home" },
    { label: "ПРОФЕССИОНАЛЬНАЯ ТЕХНИКА", url: "/professional" },
    { label: "ПОКУПКА И СЕРВИС", url: "/service" },
    { label: "О КОМПАНИИ", url: "/about" },
    { label: "БЛОГ", url: "/blog" }
];
</script>

<style scoped>
.main-menu {
    display: flex;
    justify-content: space-between;
    padding: 20px 128px;
    font-size: 14px;
    background: #fff;
    align-items: center;
    justify-self: center;
    width: 100%;
}
ul {
    display: flex;
    gap: 40px;
}
li {
    position: relative;
    list-style: none;
}
a {
    display: block;
    padding: 5px 0;
    position: relative;
}
.line {
    position: absolute;
    height: 2px;
    background: #ffd800; /* Karcher yellow */
    width: 0%;
    transition: width 0.35s ease;
}
.line.top {
    top: 0;
    right: 0;                 /* анимация справа → налево */
    transform-origin: right;
}
.line.bottom {
    bottom: 0;
    left: 0;                 /* анимация слева → направо */
    transform-origin: left;
}
a:hover .line {
    width: 100%;
}
@media (max-width: 800px) {
    .main-menu, .main-menu ul {
        flex-direction: column;
        align-items: flex-start;
        gap:5px;
        padding: 10px;
    }
}
</style>
