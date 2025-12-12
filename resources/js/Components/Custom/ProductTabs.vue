<template>
    <div class="tabs-container">
        <div class="tabs-header">
            <div
                v-for="tab in tabList"
                :key="tab.key"
                class="tab-item"
                :class="{ active: activeTab === tab.key }"
                @click="activeTab = tab.key"
            >
                {{ tab.label }}
            </div>
        </div>

        <div class="tabs-content">
            <div v-if="activeTab === 'description'" v-html="description"></div>
            <div v-if="activeTab === 'specifications'" v-html="specifications"></div>
            <div v-if="activeTab === 'equipment'" v-html="equipment"></div>
        </div>
    </div>
</template>

<script>
export default {
    name: "ProductTabs",

    props: {
        description: {
            type: String,
            default: ''
        },
        specifications: {
            type: String,
            default: ''
        },
        equipment: {
            type: String,
            default: ''
        }
    },

    data() {
        return {
            activeTab: 'description',
            tabList: [
                { key: 'description', label: 'Описание' },
                { key: 'specifications', label: 'Характеристики' },
                { key: 'equipment', label: 'Комплектация' },
            ]
        };
    },

    computed: {

    }
};
</script>

<style scoped>
.tabs-container {
    margin-top: 40px;
}

.tabs-header {
    display: flex;
    gap: 20px;
    margin-bottom: 15px;
}

.tab-item {
    cursor: pointer;
    font-size: 16px;
    color: #333;
    padding: 8px 12px;
    border-radius: 6px;
    transition: background 0.3s, color 0.3s;
}

.tab-item.active {
    background: #FFD740; /* жёлтый подсвет */
    color: black;
}

.tabs-content {
    font-size: 16px;
    color: #333;
    line-height: 1.6;
}
</style>
