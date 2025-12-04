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
            <div v-if="activeTab === 'description'">
                <div v-html="tabs.description"></div>
            </div>

            <div v-if="activeTab === 'specifications'">
                <div v-html="tabs.specifications"></div>
            </div>

            <div v-if="activeTab === 'equipment'">
                <div v-html="tabs.equipment"></div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "ProductTabs",

    props: {
        tabs: {
            type: Object,
            required: true
        }
    },

    data() {
        return {
            activeTab: 'description',

            tabList: [
                { key: 'description', label: 'Description' },
                { key: 'specifications', label: 'Specifications' },
                { key: 'equipment', label: 'Equipment' },
            ]
        };
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
