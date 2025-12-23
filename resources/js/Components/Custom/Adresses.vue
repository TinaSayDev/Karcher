<template>
    <h3 class="container">Адреса магазинов</h3>

    <div class="addresses__wrapper">
        <!-- Левая колонка -->
        <div class="addresses__left">
            <!-- Список адресов -->
            <div v-if="!showDetails">
                <ul>
                    <li
                        v-for="(item, index) in addresses"
                        :key="index"
                        @click="selectAddress(index)"
                    >
                        <h5>{{ item.title }}</h5>
                        <br>
                        <span class="phones" v-for="phone in item.phones" :key="phone">{{ phone }}</span>
                    </li>
                </ul>
            </div>

            <!-- Подробный блок -->
            <div v-else class="address-details">
                <button class="close-btn" @click="closeDetails">✕</button>
                <p><strong>{{ selectedAddress.title }}</strong></p>
                <p>Метро: {{ selectedAddress.metro }}</p>
                <p>Режим работы: {{ selectedAddress.hours }}</p>
                <p>Телефон:</p>
                <ul class="tel">
                    <li v-for="phone in selectedAddress.phones" :key="phone">{{ phone }}</li>
                </ul>
                <p>E-mail: {{ selectedAddress.email }}</p>
                <button class="msg" @click="open">Написать сообщение</button>

            </div>
        </div>

        <!-- Правая колонка с картой -->
        <div class="addresses__right" v-if="selectedAddress">
            <iframe
                :src="selectedAddress.map"
                width="600"
                height="450"
                style="border:0;"
                allowfullscreen=""
                loading="lazy"
                referrerpolicy="no-referrer-when-downgrade"
            ></iframe>
        </div>
    </div>
    <!-- Модалка -->
    <div v-if="isOpen" class="modal-overlay" @click.self="close">
        <div class="modal">
            <button @click="isOpen = true" class="btn-open">Написать сообщение</button>

            <!-- Модалка -->
            <div v-if="isOpen" class="modal-overlay" @click.self="close">
                <div class="modal">
                    <button class="modal-close" @click="close">✕</button>

                    <h3>Написать сообщение</h3>

                    <form @submit.prevent="submit">
                        <!-- Honeypot поле -->
                        <input v-model="form.website" autocomplete="off" tabindex="-1" class="honeypot">

                        <input v-model="form.name" type="text" placeholder="Ваше имя" required>
                        <input v-model="form.phone" type="tel" placeholder="Телефон" required>
                        <input v-model="form.email" type="email" placeholder="E-mail">
                        <textarea v-model="form.message" placeholder="Введите сообщение" required></textarea>

                        <button type="submit" class="btn-submit">Отправить</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, computed } from 'vue'
const isOpen = ref(false)

const form = ref({
    name: '',
    phone: '',
    email: '',
    message: '',
    website: '' // honeypot

})
async function submit() {
    try {
        await axios.post('/contact', form.value)

        alert('Сообщение отправлено!')

        // Очистка формы
        form.value = {
            name: '',
            phone: '',
            email: '',
            message: '',
            website: ''
        }

        close()
    } catch (e) {
        console.error(e)
        alert('Ошибка отправки!')
    }
}
function open() {
    isOpen.value = true
}

function close() {
    isOpen.value = false
}

const addresses = [
    {
        title: 'Центр продаж Штутгарт, Минск - Фаренгейт, ул. Притыцкого 79',
        metro: 'Кунцевщина',
        hours: 'Без выходных, 9:00 — 21:00',
        phones: ['+375 (29) 639 55 20', '+375 (29) 235 79 99'],
        email: 'f1@stuttgart.by',
        map: 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2998.156936782149!2d69.23602309999998!3d41.283688799999986!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x38ae8a5ec5f7584f%3A0xfebedb2d48284dcd!2sMukimi%20Street%2074%2C%20Tashkent%2C%20Uzbekistan!5e0!3m2!1sen!2s!4v1765362715807!5m2!1sen!2s" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade',
    },
    {
        title: 'Центр продаж Ташкент - ул. Мукимий 74',
        metro: 'Н/A',
        hours: 'Без выходных, 9:00 — 21:00',
        phones: ['+998 (97) 455 71 54', '+998 (97) 455 71 54'],
        email: 'info@asiacenter.uz',
        map:  "https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2998.156936782149!2d69.23602309999998!3d41.283688799999986!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x38ae8a5ec5f7584f%3A0xfebedb2d48284dcd!2sMukimi%20Street%2074%2C%20Tashkent%2C%20Uzbekistan!5e0!3m2!1sen!2s!4v1765362715807!5m2!1sen!2s",
    },
    {
        title: 'Центр продаж Самарканд - ул. Мирзо Улугбека, 78',
        metro: 'Н/A',
        hours: 'Без выходных, 9:00 — 21:00',
        phones: ['+998 (97) 455 71 54', '+998 (97) 455 71 54'],
        email: 'info@asiacenter.uz',
        map: "https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3071.473199504278!2d66.93144768728845!3d39.66156889826891!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3f4d19171e3a0a9f%3A0x327b8da4d8a38414!2sMirzo%20Ulugbek%20St%2078%2C%20Samarkand%2C%20Samarqand%20Region%2C%20Uzbekistan!5e0!3m2!1sen!2sus!4v1766432989238!5m2!1sen!2sus",
    },
]

const selectedIndex = ref(0)  // по умолчанию выбран первый адрес
const showDetails = ref(false)

const selectedAddress = computed(() =>
    selectedIndex.value !== null ? addresses[selectedIndex.value] : null
)

function selectAddress(index) {
    selectedIndex.value = index
    showDetails.value = true
}

function closeDetails() {
    showDetails.value = false
}

</script>

<style scoped>
h3{
    font-size: 24px;
    color: #333333;
    max-width: 1260px;
    margin: 0 auto;
    padding: 20px 10px;
}
.addresses__wrapper {
    display: flex;
    gap: 20px;
    max-width: 1260px;
    margin: 0 auto;
    font-size: 14px;
    color: #333;
}

.addresses__left {
    flex: 1;
}

.addresses__left li {
    cursor: pointer;
    padding: 40px;
    border-bottom: 1px solid #ddd;
}
.addresses__left .tel li{
    padding: 10px;
}

.addresses__right {
    flex: 2;
}

.addresses__right iframe {
    width: 100%;
    height: 450px;
    margin-top: 20px;
}

.address-details {
    position: relative;
    padding: 45px;
    border: 1px solid #ddd;
}
.tel,.phones{
    font-size: 13px;
    color: #999999;
}
.close-btn {
    position: absolute;
    top: 5px;
    right: 5px;
    border: none;
    background: transparent;
    font-size: 20px;
    cursor: pointer;
}
.msg{
    border: 1px solid #ccc;
    padding: 10px;
    border-radius: 10px;
    margin-top: 10px;
}
.msg:hover{
    background: #cccccc;
    color: #FFFFFF;
}

/* Modal window */

.modal-overlay {
    position: fixed;
    inset: 0;
    background: rgba(0,0,0,.6);
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 9999;
}

.modal {
    background: #fff;
    padding: 30px;
    width: 100%;
    max-width: 420px;
    border-radius: 10px;
    position: relative;
}

.modal input,
.modal textarea {
    width: 100%;
    padding: 10px;
    margin-bottom: 12px;
    border: 1px solid #ddd;
    border-radius: 6px;
}

.modal textarea {
    min-height: 80px;
}


.btn-submit {
    width: 100%;
    padding: 12px;
    background: #F1DE04;
    border: none;
    font-weight: 700;
    border-radius: 6px;
    cursor: pointer;
}

.modal-close {
    position: absolute;
    top: 10px;
    right: 12px;
    background: none;
    border: none;
    font-size: 20px;
    cursor: pointer;
}
/* honeypot скрытие */
.honeypot {
    position: absolute;
    left: -9999px;
    opacity: 0;
}
@media (max-width: 800px) {

    .addresses__wrapper {
        flex-direction: column;
    }
}
</style>
