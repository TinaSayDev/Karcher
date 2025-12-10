<template>
    <div class="top-menu">
        <div class="container flex justify-between items-center">
            <div class="left">
                <div class="socials">
                    <a href="#">
                        <svg class="fb" width="24" height="24" viewBox="0 0 24 24" fill="none"
                             xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                            <rect width="24" height="24" fill="url(#pattern0_28_6)"/>
                            <defs>
                                <pattern id="pattern0_28_6" patternContentUnits="objectBoundingBox" width="1"
                                         height="1">
                                    <use xlink:href="#image0_28_6" transform="scale(0.01)"/>
                                </pattern>
                                <image id="image0_28_6" width="100" height="100" preserveAspectRatio="none"
                                       xlink:href="data:image/png;base64,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"/>
                            </defs>
                        </svg>
                    </a>

                    <a href="#">
                        <svg class="inst" width="24" height="24" viewBox="0 0 24 24" fill="none"
                             xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                            <rect width="24" height="24" fill="url(#pattern0_28_7)"/>
                            <defs>
                                <pattern id="pattern0_28_7" patternContentUnits="objectBoundingBox" width="1"
                                         height="1">
                                    <use xlink:href="#image0_28_7" transform="scale(0.01)"/>
                                </pattern>
                                <image id="image0_28_7" width="100" height="100" preserveAspectRatio="none"
                                       xlink:href="data:image/png;base64,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"/>
                            </defs>
                        </svg>
                    </a>
                </div>
                <div class="phone">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"
                         xmlns:xlink="http://www.w3.org/1999/xlink">
                        <rect width="24" height="24" fill="url(#pattern0_28_8)"/>
                        <defs>
                            <pattern id="pattern0_28_8" patternContentUnits="objectBoundingBox" width="1" height="1">
                                <use xlink:href="#image0_28_8" transform="scale(0.01)"/>
                            </pattern>
                            <image id="image0_28_8" width="100" height="100" preserveAspectRatio="none"
                                   xlink:href="data:image/png;base64,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"/>
                        </defs>
                    </svg>

                    <span class="phone">+998 97 455 71 54</span>
                </div>
            </div>

            <div class="right">
                <SearchMenu/>
                <LanguageSwitcher/>
            </div>
        </div>
    </div>
</template>

<script setup>
import {ref} from "vue";
import SearchMenu from './SearchMenu.vue';
import LanguageSwitcher from './LanguageSwitcher.vue'


</script>

<style scoped>
.top-menu {
    padding: 15px 5px;
    font-size: 14px;
    box-shadow: 0 4px 14px rgba(0, 0, 0, 0.1);
    margin-bottom: 10px;
    width: 100%;
}

.socials, .phone, .left, .right {
    display: flex;
}

.fb {
    margin-right: 20px;
}

.inst {
    margin-right: 50px;
}

.phone {
    margin-left: 10px;
    margin-right: 10px;
    white-space: nowrap;
}

.lang-switcher {
    position: relative;
    cursor: pointer;
}

.search-icon {
    margin-right: 100px;
}

.current {
    display: flex;
    align-items: center;
    gap: 8px;
}

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

@media (max-width: 800px) {
    .top-menu {
        flex-direction: column; /* Элементы располагаются в столбец на маленьких экранах */
        padding: 10px;
        align-items: flex-start;
        gap: 10px;
    }

    .fb, .inst {
        margin-right: 10px;
    }

    .flex-item {
        flex-basis: 100%; /* Полная ширина на мобильных */
    }
    .container{
        min-width: auto;
    }
}
</style>
