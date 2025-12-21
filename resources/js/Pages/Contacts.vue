<template>
    <DefaultLayout title="Контакты">
        <div class="contacts-wrapper container">
            <!-- Левая часть: вкладки с адресами -->
            <div class="contacts-left">
                <div class="tabs-header">
                    <div
                        v-for="tab in tabList"
                        :key="tab.key"
                        :class="['tab-item', { active: activeTab === tab.key }]"
                        @click="activeTab = tab.key"
                    >
                        {{ tab.label }}
                    </div>
                </div>

                <div class="tab-content" v-if="tabData">
                    <p><strong>Адрес:</strong> {{ tabData.address }}</p>
                    <p><strong>Телефон:</strong> {{ tabData.phone }}</p>
                    <p><strong>Email:</strong> {{ tabData.email }}</p>
                    <p><strong>График:</strong> {{ tabData.schedule }}</p>
                </div>

            </div>
            <!-- Карта -->
            <div class="map-container">
                <iframe
                    src="https://maps.google.com/maps?q=Tashkent&t=&z=13&ie=UTF8&iwloc=&output=embed"
                    width="100%"
                    height="400"
                    style="border:0;"
                    allowfullscreen=""
                    loading="lazy"
                ></iframe>
            </div>



        </div>
        <!--форма обратной связи -->
        <div class="contacts-right container">
            <h2>Get in touch</h2>
            <form class="contact-form flex" @submit.prevent="submit">
                <div class="form-left">
                    <input type="text" v-model="form.name" placeholder="Name" required />
                    <input type="text" v-model="form.phone" placeholder="Phone" />
                    <input type="email" v-model="form.email" placeholder="Email" required />
                </div>
                <div class="form-right">
                    <textarea v-model="form.message" placeholder="Message" required></textarea>
                    <button type="submit" :disabled="loading">
                        {{ loading ? 'Sending...' : 'Send' }}
                    </button>
                </div>
            </form>
            <div v-if="success" class="success-message">Message sent successfully!</div>
        </div>

    </DefaultLayout>
</template>

<script setup>
import { ref, computed } from 'vue'
import axios from 'axios'
import DefaultLayout from '@/Layouts/DefaultLayout.vue'

const props = defineProps({
    contacts: {
        type: Array,
        required: true,
    }
})

const activeTab = ref(props.contacts[0]?.key ?? null)

const tabList = computed(() =>
    props.contacts.map(c => ({
        key: c.key,
        label: c.label,
    }))
)

const tabData = computed(() =>
    props.contacts.find(c => c.key === activeTab.value)
)

// Форма
const form = ref({
    name: '',
    phone: '',
    email: '',
    message: ''
})

const loading = ref(false)
const success = ref(false)

const submit = async () => {
    loading.value = true
    success.value = false

    try {
        await axios.post('/contacts/send', form.value)
        success.value = true
        form.value = { name: '', phone: '', email: '', message: '' }
    } catch (e) {
        console.error(e)
        alert('Error sending message')
    } finally {
        loading.value = false
    }
}
</script>


<style scoped>
.contacts-wrapper {
    display: flex;
    gap: 30px;
    flex-wrap: wrap;
    padding: 100px 10px 30px 10px;
}

.contacts-left {
    flex: 1;
    min-width: 280px;
}

.tabs-header {
    display: flex;
    gap: 10px;
    margin-bottom: 15px;
}

.tab-item {
    padding: 8px 12px;
    cursor: pointer;
    border-radius: 6px;
}

.tab-item.active {
    background: #FFF000;
    color: #000000;
}

.tab-content p {
    margin: 5px 0;
}

.contacts-right {
    flex: 1;
    min-width: 280px;
    display: flex;
    flex-direction: column;
    gap: 10px;
}

.contacts-right input,
.contacts-right textarea {
    width: 100%;
    padding: 8px;
    border-radius: 4px;
    border: 1px solid #ccc;
}

.contacts-right button {
    padding: 10px 20px;
    border: none;
    background: #FFF000;
    color: #000000;
    border-radius: 5px;
    cursor: pointer;
    width: 100%;
}

.contacts-right button:disabled {
    background: #aaa;
}

.success-message {
    color: green;
    margin-top: 5px;
}
.contact-form{
    gap:20px;
    margin-bottom: 100px;
}
.map-container,.tabs-header{
    flex:1;
}
.map-container iframe {
    width: 100%;
    border-radius: 8px;
}

.form-right,.form-left{
    flex:1;
}
.form-left input{
    margin-bottom:10px;
}
.form-left input:last-child{
    margin-bottom: 0;
}
</style>
