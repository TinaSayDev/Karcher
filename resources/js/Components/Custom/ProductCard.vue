<template>
    <div class="card" @mouseleave="reset" @click="openProduct">

        <!-- Превью слайдов -->
        <div class="image-wrapper" ref="wrapper">
            <img
                v-for="(src, i) in images"
                :key="i"
                class="image-slide"
                :src="`/storage/products/${src}`"
                :class="{ active: i === index }"
                loading="lazy"
                draggable="false"
            />
        </div>

        <!-- Бейджи -->
        <div
            v-for="(badge, i) in badges"
            :key="i"
            class="badge"
            :class="badge.color"
            @click.stop
            :style="{ top: `${15 + i*28}px` }"
        >
            {{ badge.text }}
        </div>

        <!-- Навигация по слайдам -->
        <div class="stars" @click.stop>
            <div
                v-for="(img, i) in images"
                :key="i"
                :style="{ background: i === index ? '#F1DE04' : '#dddddd' }"
            ></div>
        </div>

        <Stars/>
        <div class="title">{{ product.name }}</div>

        <div class="stock">
            <div class="dot"></div>
            <div class="text">В наличии</div>
        </div>

        <div class="price">{{ formatPrice(product.price) }} сум/шт</div>

        <div class="details">
            <div class="details-btn">Подробнее</div>
        </div>
    </div>
</template>

<script>

import Stars from "./Parts/Stars.vue";
import { formatPrice } from '@/utils/formatPrice.js';

export default {
    name: "ProductCard",
    components: { Stars },

    props: {
        product: { type: Object, required: true },
        activeFilter: { type: String, default: 'all' } // фильтр из родителя
    },

    data() {
        return {
            index: 0,
            touchX: null,
        };
    },

    computed: {
        images() {
            return this.product.images ?? [];
        },

        badges() {
            const badgeMap = {
                hit: { text: 'ХИТ', color: 'badge-blue' },
                recommended: { text: 'СОВЕТУЕМ', color: 'badge-purple' },
                new: { text: 'НОВИНКА', color: 'badge-green' },
                sale: { text: 'УЦЕНКА', color: 'badge-red' }
            };

            // Если выбран фильтр и есть соответствующее поле, выводим один бейдж
            if (this.activeFilter !== 'all' && badgeMap[this.activeFilter]) {
                return [badgeMap[this.activeFilter]];
            }

            // Для "весь каталог" можно оставить пустой массив, чтобы бейджей не было
            return [];
        }
    },

    mounted() {
        const zoneCount = this.images.length;
        const wrapper = this.$refs.wrapper;

        wrapper.addEventListener("mousemove", (e) => {
            const rect = wrapper.getBoundingClientRect();
            const x = e.clientX - rect.left;
            const zoneWidth = rect.width / zoneCount;
            const newIndex = Math.floor(x / zoneWidth);
            if (newIndex !== this.index && newIndex >= 0 && newIndex < zoneCount) {
                this.index = newIndex;
            }
        });

        wrapper.addEventListener("touchstart", (e) => {
            this.touchX = e.touches[0].clientX;
        });

        wrapper.addEventListener("touchmove", (e) => {
            const x = e.touches[0].clientX;
            const rect = wrapper.getBoundingClientRect();
            const zoneWidth = rect.width / zoneCount;
            const newIndex = Math.floor((x - rect.left) / zoneWidth);
            if (newIndex !== this.index && newIndex >= 0 && newIndex < zoneCount) {
                this.index = newIndex;
            }
        });
    },

    methods: {
        reset() { this.index = 0; },
        openProduct() { this.$emit("open", this.product); },
        formatPrice
    }
};
</script>

<style scoped>
.card { position: relative; height: 469px; font-family: 'Montserrat', sans-serif; border: 1px solid #f5f4f4; padding: 20px; background: #fff; transition: box-shadow 0.25s ease, transform 0.15s ease; cursor: pointer; }
.image-wrapper { position: absolute; width: 258px; height: 288px; overflow: hidden; left: 25px; }
.image-slide { position: absolute; width: 100%; height: 100%; object-fit: cover; opacity: 0; transition: opacity 0.35s ease; pointer-events: none; }
.image-slide.active { opacity: 1; }

.badge { position: absolute; left: 25px; padding: 2px 6px; border-radius: 2px; color: white; font-size: 12px; font-weight: bold; display: flex; align-items: center; justify-content: center; cursor: default; }

/* Цвета бейджей */
.badge-blue { background: #2992d9; }
.badge-green { background: #28a745; }
.badge-purple { background: #6f42c1; }
.badge-red { background: #dc3545; }

.stars { position: absolute; left: 25px; top: 312.5px; width: 258px; display: flex; }
.stars div { flex: 1; height: 1px; background: #dddddd; border-radius: 2px; margin-right: 4px; }
.stars div:last-child { margin-right: 0; }

.title { position: absolute; left: 25px; top: 359px; font-size: 14px; color: #333; }

.stock { position: absolute; left: 25px; top: 390px; display: flex; align-items: center; gap: 10px; }
.stock .dot { width: 5px; height: 5px; background: #5fa800; border-radius: 50%; }
.stock .text { font-size: 12px; color: #5fa800; }

.price { position: absolute; left: 25px; top: 418px; font-size: 17px; font-weight: 700; }

.details{
    position: absolute;
    bottom: -35px;
    left: 50%;
    transform: translateX(-50%);
    width: 100%;
    text-align: center;
    opacity: 0;
}
.details-btn {
    background: #F1DE04;
    color: black;
    padding: 8px 16px;
    font-size: 14px;
    font-weight: bold;
    cursor: pointer;
    position: relative;
    overflow: hidden;
    transition: background 0.3s, transform 0.2s;
}
.details-btn::after {
    content: "";
    position: absolute;
    width: 100%;
    height: 100px;
    background: rgba(54, 43, 43, 0.4);
    display: block;
    border-radius: 50%;
    pointer-events: none;
    transform: scale(0);
    opacity: 0;
    transition: transform 0.6s ease-out, opacity 0.6s ease-out;
    top: 50%;
    left: 50%;
    transform-origin: center;
}
.card:hover .details-btn::after {
    transform: scale(4);
    opacity: 1;
    transition: transform 0.6s ease-out, opacity 0.6s ease-out;
}

.card:hover {
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.12), 0 2px 6px rgba(0, 0, 0, 0.08);
    z-index: 2;
}
.card:hover .details { opacity: 1; }
@media (max-width: 800px) {
    .card:hover .details { opacity: 0; }

}
</style>
