<template>
    <div class="search-wrapper">
        <!-- Лупа в меню (исчезает, когда open = true) -->
        <div v-if="!open" class="search-icon" @click="toggle">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24">
                <circle cx="11" cy="11" r="8" stroke="black" stroke-width="2" fill="none"/>
                <line x1="16" y1="16" x2="22" y2="22" stroke="black" stroke-width="2"/>
            </svg>
        </div>

        <!-- Поле поиска -->
        <transition name="fade">
            <div v-if="open" class="search-box">
                <input
                    type="text"
                    v-model="query"
                    class="search-input"
                    placeholder="Поиск по каталогу..."
                    @keydown.enter="submit"
                >

                <!-- Лупа внутри поля (кнопка поиска) -->
                <button class="search-btn" @click="submit">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24">
                        <circle cx="11" cy="11" r="8" stroke="black" stroke-width="2" fill="none"/>
                        <line x1="16" y1="16" x2="22" y2="22" stroke="black" stroke-width="2"/>
                    </svg>
                </button>
            </div>
        </transition>
    </div>
</template>

<script setup>
import { ref } from 'vue';
import axios from 'axios';

const emit = defineEmits(['results']);

const open = ref(false);
const query = ref('');
const loading = ref(false);

const toggle = () => {
    open.value = !open.value;

    if (open.value) {
        setTimeout(() => {
            document.querySelector('.search-input')?.focus();
        }, 10);
    }
};

const searchProducts = async (query) => {
    try {
        const res = await axios.get('/api/search', {
            params: { q: query }
        });
        return res.data.data;
    } catch (e) {
        console.error(e);
        return [];
    }
};

const submit = async () => {
    const q = query.value.trim();
    if (!q) return;

    loading.value = true;

    try {
        const results = await searchProducts(q);
        emit('results', results);
    } catch (err) {
        console.error(err);
        emit('results', []);
    } finally {
        loading.value = false;
    }
};

</script>

<style scoped>
.search-wrapper {
    position: relative;
    display: flex;
    align-items: center;
}

/* Лупа в меню */
.search-icon {
    cursor: pointer;
    display: flex;
    justify-content: center;
    align-items: center;
    margin: 0 100px 0 0;
}

/* Контейнер поля поиска */
.search-box {
    position: absolute;
    right: 0;
    top: 0px;
    width: 260px;
    display: flex;
    align-items: center;
    background: white;
    border: 1px solid #dcdcdc;
    border-radius: 6px;
    box-shadow: 0 6px 20px rgba(0, 0, 0, 0.12);
    padding: 0 8px;
    margin: -10px 20px 5px 5px;
}


/* Сам input */
.search-input {
    flex: 1;
    padding: 8px 6px;
    border: none;
    outline: none;
    font-size: 14px;
}

/* Кнопка-лупа внутри поля */
.search-btn {
    background: none;
    border: none;
    padding: 4px;
    cursor: pointer;
    display: flex;
}

/* Анимация */
.fade-enter-active,
.fade-leave-active {
    transition: 0.25s ease;
}

.fade-enter-from,
.fade-leave-to {
    opacity: 0;
    transform: translateY(-6px);
}

@media (max-width: 800px) {
    .search-icon{
        margin-right: 10px;
    }
}
</style>
