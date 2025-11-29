<template>
    <div class="top-menu">

        <div class="left">
        <div class="socials">
         <svg class="fb" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                <rect width="24" height="24" fill="url(#pattern0_28_6)"/>
                <defs>
                    <pattern id="pattern0_28_6" patternContentUnits="objectBoundingBox" width="1" height="1">
                        <use xlink:href="#image0_28_6" transform="scale(0.01)"/>
                    </pattern>
                    <image id="image0_28_6" width="100" height="100" preserveAspectRatio="none" xlink:href="data:image/png;base64,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"/>
                </defs>
            </svg>

         <svg class="inst" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                <rect width="24" height="24" fill="url(#pattern0_28_7)"/>
                <defs>
                    <pattern id="pattern0_28_7" patternContentUnits="objectBoundingBox" width="1" height="1">
                        <use xlink:href="#image0_28_7" transform="scale(0.01)"/>
                    </pattern>
                    <image id="image0_28_7" width="100" height="100" preserveAspectRatio="none" xlink:href="data:image/png;base64,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"/>
                </defs>
            </svg>
        </div>
        <div class="phone">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                <rect width="24" height="24" fill="url(#pattern0_28_8)"/>
                <defs>
                    <pattern id="pattern0_28_8" patternContentUnits="objectBoundingBox" width="1" height="1">
                        <use xlink:href="#image0_28_8" transform="scale(0.01)"/>
                    </pattern>
                    <image id="image0_28_8" width="100" height="100" preserveAspectRatio="none" xlink:href="data:image/png;base64,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"/>
                </defs>
            </svg>

            <span class="phone">+998 97 455 71 54</span>
        </div>
        </div>

        <div class="right">
            <svg class="search" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                <rect width="24" height="24" fill="url(#pattern0_28_10)"/>
                <defs>
                    <pattern id="pattern0_28_10" patternContentUnits="objectBoundingBox" width="1" height="1">
                        <use xlink:href="#image0_28_10" transform="scale(0.01)"/>
                    </pattern>
                    <image id="image0_28_10" width="100" height="100" preserveAspectRatio="none" xlink:href="data:image/png;base64,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"/>
                </defs>
            </svg>

            <div class="lang-switcher">
            <div class="current" @click="toggle">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                    <circle cx="12" cy="12" r="12" fill="url(#pattern0_28_15)"/>
                    <circle cx="12" cy="12" r="11.5" stroke="black" stroke-opacity="0.2"/>
                    <defs>
                        <pattern id="pattern0_28_15" patternContentUnits="objectBoundingBox" width="1" height="1">
                            <use xlink:href="#image0_28_15" transform="scale(0.01)"/>
                        </pattern>
                        <image id="image0_28_15" width="100" height="100" preserveAspectRatio="none" xlink:href="data:image/png;base64,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"/>
                    </defs>
                </svg>

                {{ current.toUpperCase() }}  <span class="arrow"><svg width="8" height="17" viewBox="0 0 8 17" fill="none" xmlns="http://www.w3.org/2000/svg">
<path d="M3.32833 16.3536C3.52359 16.5488 3.84018 16.5488 4.03544 16.3536L7.21742 13.1716C7.41268 12.9763 7.41268 12.6597 7.21742 12.4645C7.02216 12.2692 6.70557 12.2692 6.51031 12.4645L3.68188 15.2929L0.853458 12.4645C0.658195 12.2692 0.341613 12.2692 0.146351 12.4645C-0.0489113 12.6597 -0.0489113 12.9763 0.146351 13.1716L3.32833 16.3536ZM3.68188 0L3.18188 0L3.18188 16H3.68188H4.18188L4.18188 0L3.68188 0Z" fill="black"/>
</svg>
</span>
            </div>

            <div class="dropdown" v-if="open">
                <div
                    v-for="l in langs"
                    :key="l"
                    class="item"
                    @click="select(l)"
                >
                    {{ l.toUpperCase() }}
                </div>
            </div>
        </div>
        </div>
    </div>
</template>

<script setup>
import { ref } from "vue";

const langs = ["eng", "uzb", "rus"];
const current = ref("rus");
const open = ref(false);

const toggle = () => (open.value = !open.value);
const select = lang => {
    current.value = lang;
    open.value = false;
};
</script>

<style scoped>
.top-menu {
    display: flex;
    justify-content: space-between;
    padding: 20px 0;
    font-size: 14px;
    background: #fff;
    width: 80%;
    align-items: center;
    justify-self: center;
}
.socials, .phone,.left,.right{
    display: flex;
}

.fb{
    margin-right: 20px;
}
.inst{
    margin-right: 50px;
}
.phone{
    margin-left: 10px;
}
.lang-switcher {
    position: relative;
    cursor: pointer;
}
.search{
    margin-right: 100px;
}
.current { display: flex; align-items: center; gap: 8px; }
.dropdown {
    position: absolute;
    right: 0;
    top: 22px;
    background: white;
    border: 1px solid #ddd;
    border-radius: 4px;
}
.item {
    padding: 6px 12px;
}
.item:hover {
    background: #f2f2f2;
}
</style>
