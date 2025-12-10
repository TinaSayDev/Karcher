<template>
    <div class="language-switcher" ref="switcher">
        <!-- Кнопка текущего языка -->
        <button class="current-lang" @click="toggleDropdown">
            <span class="flag" v-html="currentFlag"></span>
            <span class="label">{{ currentLabelShort }}</span>
            <span class="arrow">
        <svg width="8" height="17" viewBox="0 0 8 17" fill="none" xmlns="http://www.w3.org/2000/svg">
          <path
              d="M3.32833 16.3536C3.52359 16.5488 3.84018 16.5488 4.03544 16.3536L7.21742 13.1716C7.41268 12.9763 7.41268 12.6597 7.21742 12.4645C7.02216 12.2692 6.70557 12.2692 6.51031 12.4645L3.68188 15.2929L0.853458 12.4645C0.658195 12.2692 0.341613 12.2692 0.146351 12.4645C-0.0489113 12.6597 -0.0489113 12.9763 0.146351 13.1716L3.32833 16.3536ZM3.68188 0L3.18188 0L3.18188 16H3.68188H4.18188L4.18188 0L3.68188 0Z"
              fill="black"/>
        </svg>
      </span>
        </button>

        <!-- Дропдаун -->
        <ul v-if="open" class="dropdown">
            <li v-for="lang in languages" :key="lang.code">
                <button @click="setLanguage(lang.code)">
                    <span class="flag" v-html="lang.flag"></span>
                    <span class="label">{{ lang.labelShort }}</span>
                </button>
            </li>
        </ul>
    </div>
</template>

<script setup>
import {ref, computed, onMounted, onBeforeUnmount} from 'vue';
import {Inertia} from '@inertiajs/inertia';

const open = ref(false);
const switcher = ref(null);

const languages = [
    {
        code: 'ru',
        labelShort: 'RUS',
        flag: `<svg width="20" height="20" viewBox="0 0 100 100" fill="none" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
<rect width="100" height="100" fill="url(#pattern0_30_9)"/>
<defs>
<pattern id="pattern0_30_9" patternContentUnits="objectBoundingBox" width="1" height="1">
<use xlink:href="#image0_30_9" transform="scale(0.01)"/>
</pattern>
<image id="image0_30_9" width="100" height="100" preserveAspectRatio="none" xlink:href="data:image/png;base64,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"/>
</defs>
</svg>
`
    },
    {
        code: 'uz',
        labelShort: 'UZ',
        flag: `<svg width="20" height="20" viewBox="0 0 100 100" fill="none" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
<rect width="100" height="100" fill="url(#pattern0_30_8)"/>
<defs>
<pattern id="pattern0_30_8" patternContentUnits="objectBoundingBox" width="1" height="1">
<use xlink:href="#image0_30_8" transform="scale(0.01)"/>
</pattern>
<image id="image0_30_8" width="100" height="100" preserveAspectRatio="none" xlink:href="data:image/png;base64,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"/>
</defs>
</svg>
`
    },
    {
        code: 'en',
        labelShort: 'EN',
        flag: `<svg width="20" height="20" viewBox="0 0 100 100" fill="none" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
<rect width="100" height="100" fill="url(#pattern0_30_10)"/>
<defs>
<pattern id="pattern0_30_10" patternContentUnits="objectBoundingBox" width="1" height="1">
<use xlink:href="#image0_30_10" transform="scale(0.01)"/>
</pattern>
<image id="image0_30_10" width="100" height="100" preserveAspectRatio="none" xlink:href="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAGQAAABkCAYAAABw4pVUAAAACXBIWXMAAAsTAAALEwEAmpwYAAANYElEQVR4nO1de3AU9R1f2j/aqdU+nGn7T9uZtjNtp506LdlFUW/N7vGs4h0YlJcCAkbEFgSrYnn64GGpKKLyVkCqohHkLkcIgQQuISARCEkIEAXy4EJ2bx+3d4SEJL/Od8kee3u5vG5v9+7Yz8x35uB33I/v97P7/X1fe4dhFixYsGDBggULFixYsGAhBtCAe7O+/BU52mW/3+l+xuZwLSSdrhWk072OdLg+Ip3uTzpfv2NzuJbaHK4ZNod7ROYoz++zsj79bqxPtdBLkFkHfwgGtTndK0mH65jN6QqSTjfqj3T+22LS4X7L5twzCj7bbP1SAvas/B+RTvc0x5R8r2Nyfmt3Rn782aKYa5ljctHEZwpjk+RwtW4cMffdYOagKczgwbebrXfS4X6nmyIdro9tDlczGGzz/86h7Z/VxDTopFlFqO5yUDZ8V+tLVp1ARSW+bu8az7AnCoM0gSSKCEo0vvUqjd+D3erYseubObPml5wCAz0w2o2eX3oMvbO5CgliCwqGrqO1W6rQC69+FTb8lNmH0Mq15ehkhR8Bdu+9JBvfOWW/vP7sy0fQm+sqUG1DELV3dKCNO86iBSvK0LBxe2MSEiEU4Q1RGQ8hDBuA3UpYvaliSlk5I4LRZ8zzho301oZK1NGBIrB+e3V4feKsQuTnr0Wsnz7DoeGdBgdCW1vbI9ZzC+pQ5ujc3hHSKRJNFIfseAaW7iCzXL8oPtZ4Dq5ewKtvnogy1P5DDWFjeo82Rq2/vPx4eL31ejsaMT4vYn3Lx+fC6xdqpS7J6ImQTlfWLtH4ZmnIPT/D0hH3O11PjZyQFwBDnaz0o6vNbejtjZVRhjp2gkENvhCqrQ+i8iouah1cVvO1NnTiNCsbffTUG+5KkRz3RcQJLai6RkAcf63HM6RHoYimEIU7sXTB4FG7brc53TvACFnTC9DsBaWyQcDvz1tytMsD2Z7lQfQjuWjpf6PvoDkLS9Ej0wrk18+8VILGPX0w6g4aOSFPPpMWvfE1GjLW0yUhOVNf2ytNdJb0VsTVK173+Xy3YakM25jcv9qcrvP9zR/IBMruvJpClhdRX4ThxVMcx/0aS0U88HAubR/rCXRnFHuMq5fsw3v6u94fQm6IcJkVxUFYKsE22j2eHpPb2lMuAP5+/MxIl0Oq5J8LStF7H56JuQ5urbs9wEXm5F7UmRARsZzQ7BeELCwVQDpynx7+WF77u1uq5EMXzgStH6ceyUVT5xxG11ra0N6D9eihx/OjDOacsh+VnWIRy11D47IPRkVLEOp2twd8pnt/nRwGT5/rlcnTjRBwX5zQ5heEsVgyg3S4xs1bfLSjvT0ymYCICghQDFV/ORSZbCCE1m27mW/szrsUtV5RzYXdDwQD3e2hEKVGQ2MIPfxEvm6EdJLS0sSJD2LJembYnK5roOwb75ZHGGPu4shoCq54UWoNr3+ZdynqDiota7ppTF8IjVIZszd7fOG5GF6Tgq1owszI2taXu04XMLX1fLzC1tb5uPKvSSwJo6mg2vcDlATw0acORLkkXmwJr3d1TnzRaVB4D+QUXZ0v3e2xZlNleB0I6Xce0ivBA4GhA/+AJU2Z3OmqVisL+QO4DXAR2z6rCeceisDVnldYj8ZOP4AW/+drueakNdjOPd+i5xYdRU/8owgVHG6Q84q+7AElFzhb4GD3FNRFJZD6EgIJJF6OHhz4g2Q4N7Z3F0klq3j0JkSugeFbTS+HmG1YMokI6ayBZZlWKLQ5XIJWUQhPod7UnTGWrzklH9yx1qfOPoSyXyiOud7THhDJQdndDEKCNN4oDL37p4YTotSntAK1pObmtqioSBHoTYiBFvRKF3UqUlXxPVwaXent7R5Q8b1YF7vSm1hC4C7BNxlKxvacmuyqs7x88CrNo38vL5MrtUo4C3F/0RFfuPgHh2thiU/u9Cmh6PFTjHzwwjoc2jtyvkGVZ3k5x4DoqK97QGQFzauWzp5IzcWAnHgq/RK17NxclM8Ve6sSIiXFVf5Gv1EdSDTgdDUXgObSU8/fbC5BhfaIKncAbFA1l5QGVKzmktIRFMSW8Hpf93BMzpfvDAXX2zrQ/NePd3mH6JEY9lDzKjKEjm07z88HZSEU1SoJHTt180h7TsBdAEZWsGBltJ93768Lr/dnj3Vbq8PrZ7+Jzl+MIwSqwzydcEKWrTlZ/dHnNbI70SoJ/XCoP0Ff+3JjSB5GUK+D27rCNKPV6yvkTLyr/ONkhR99svtb1N89IOeAHOf9rWdQE9sc8xwxgpCE3yXydIjiHjoHC9Si/juoOz04aV/EOjSOhj5600X19BmOfuyhXoc1cHPmESKiJp7/W8IIgVGdWC4g1WS3QYSwnLg+IWQQw3PvIB3uq4pCUO5+LDt2L6OnYTYQrbshNaLHHrHWP5+5cq84Y+KhhMuT4w4kZBiPdLinqxVa9f5p5MqvjWkI6Gc0MlcjXJRWyspZNG/JsZjrq+LcY86iUnmgwug8JCovsePjdSfE5nQflJVcWCqHr2AIiHIgqpm/7Hi4VwEjnJCJHzl+RY509hXWy+M+cKAr58jClWVo687z4VwBDP+0KjOfE+ce2f8qRqveO43OfSvK6xAgwJ7q88ZQQih8l+4VXZiHBUVAsba2yOYQJG+KolDBhehHjZoLYrgrCElevmr2CgCdQ3W1dmGce8A0CjSs1DhU6ovoGhpKCI03XyFJ/Qa8YQpdfbvv3HMhopOndQez5pdEGEMZ21EEDANXvwLIsLWfsTPOPSC0VsD4m6OiLSMJkcWOD9OPEHgkQKUMuAhQEq5KmKPVGguyY3A1cEZACQSKhep1uEvgrgBDB6RWtPXT81GfsS/OPWBgG8ozUA2A92l76kYTIlHEMt0Igecz1MqASxn22F456QLfrW0egctQpkmmPXdYLomo18GXv/T6V/LrhybtQy++duM1qeMeMKStuLAXXjkWVYjs66BcvBLInrxNJzrQAJvDJcWKdFJVdhuVh9wUqKrGP1UvP0amcTfa21/v4bZMA/YwgRDk9/t/GTchNqd7iFoR6IEve/tUTEUhrN1XFF0UVIvnQF3ESI5WFse5B4wDQVidbISwgmDXgRDXTEUJiGQgtocSN4SeWr8OhoKBAxgEgbEcbWQDf4aHaqDfAWGstg5F6rAHEA3NLTjQoRIQ6ykrUwjhxMfjJ8ThWgRGgZFNLaA3oSgMUyDah22gt6FuUMEUohZKK1aPPT7KqYn695B4dtWgMoMQhhfn6kCI+w1QAMoT0M1TAFexVlFoFqmbQ+rmkuxKZh+Sw10FcKWr14fGuQdEZAXeyxH5x5gnI/MTvQfl+iL+S5eWxk0I6XC/rygBLVi4QkHgytUqCc9jACAvgPdojQkHNRhRGW5btib6nCiMcw8gWVmHdnHMc8zoxPDGo3Lv6Tp3tWdfLZr5Yon8XCA0grRKQk0KakjQk4BM+8nnbszaKgI1qF2eS/LQGtSiusrQ98S5Bzy9CzkO5CjQcYz1wI4ZhAQpYruuhKSTeFKXkJsuK53Ek6ouSznU0008ZhBC4St1IAS+5MV8A5JpQEiQxhfETciJiiuT631cVbrJlapziRmS60Z4r3dy3IRAum94RsunpzA8T8VNCDwGbLYibJqILsVFhNB3WF4MmK0Mm+LC8CI0+PX5UhuGE/PNVohNcWE4MU8XMmRCeHGJ2QqxKS4MLy7WjRBpw5oHDBkqm5G+AjbUjRA0/HffgydNjY/biTQRXAIbYnpCookc8xUjUlMo4nNMb8AXRpquGJ2iQuHxJ4RawOQd3HqmK0enlsCXbLLDiTuwRECiiA/MVjCYYiLRxBYsUbj66MjBRg6XSWkgYDMskWB44bDZMT2bIsLwQgmWaPj9wnCzFWVTRQRhKGYEGE48arqyfHILwwmlmFHw+wP3MpzQYbbSbJIK2KaJCxj7HVoML3xotuJskgrDCx9gRqNRkn7ONPjqjR42Y5JdGnz1YBvMDEh2fKzZcX4wyUSiMiaaQkaYFCtZRGEyaHwzZjbQkL/cFqSIM2YbI2i2UPi5pPlxGGlIxp+DNMGbbhTaLME5KRP/E5ZMCGTiNnj813zjEIaKRBEtkh1P/Lf+9AchmnhYovC2W4YMmugw/RDvCdyHG8ZzXm+l0UNonNHi9VZwWzZOwFIBDCeMZzjhehpn4q1NfmEclkqAiUeGE3mzjcfqL4EmvzgSS0WwbOCPDC9Ups2dwQuVDBNIjq8U7y8uXEDfZzlxOcMJ7SlLBCd0sJy4LuV/8ijKhfFCvdnGZfsqnNDYxIl/x9IRoijeyW7bvELMnlRk9uCa2IMI2ZOK5P+rKN6JpTtCdAYOv6ppdh4RjCUUfhj+j9ithoB90H1BitifPEQQ8k+vYrc6QnbibhiXkWj8quHZNkWEoEobogYSZtsh6SDcd99PYEJSonE31IgSSEKLROEumCjkybt+bLbeKQFm8ODbg5mDRsKTq/BjwfENe+MBcEcSja8IUhkjkqZMnspAGDZAyBz4WyApaMenSzS+OEgRayUKXxekiE9AOl+vvbGGT4P3NtMZv7nlfo7bggULFixYsGDBggULFrDe4//DA8L1XCRvjQAAAABJRU5ErkJggg=="/>
</defs>
</svg>
`
    },
];

const current = ref(document.documentElement.lang || 'ru');

const currentLabelShort = computed(() => {
    const lang = languages.find(l => l.code === current.value);
    return lang ? lang.labelShort : current.value;
});

const currentFlag = computed(() => {
    const lang = languages.find(l => l.code === current.value);
    return lang ? lang.flag : '';
});

const toggleDropdown = () => {
    open.value = !open.value;
};

const setLanguage = (lang) => {
    if (lang === current.value) return;
    current.value = lang;
    open.value = false;

    Inertia.post('/set-locale', {locale: lang}, {
        preserveState: true,
        onSuccess: () => {
            document.documentElement.lang = lang;
        }
    });
};

const handleClickOutside = (event) => {
    if (switcher.value && !switcher.value.contains(event.target)) {
        open.value = false;
    }
};

onMounted(() => document.addEventListener('click', handleClickOutside));
onBeforeUnmount(() => document.removeEventListener('click', handleClickOutside));
</script>

<style scoped>
.language-switcher {
    position: relative;
    display: inline-block;
    font-family: Montserrat, sans-serif;
}

.current-lang {
    display: flex;
    align-items: center;
    gap: 8px;
    background: #fff;
    padding: 6px 12px;
    cursor: pointer;
}

.current-lang .flag svg {
    border-radius: 50%;
    overflow: hidden;
    width: 24px;
    height: 24px;
}

.current-lang .arrow {
    margin-left: auto;
}

.dropdown {
    position: absolute;
    top: 100%;
    left: 0;
    margin-top: 8px;
    padding: 8px 0;
    list-style: none;
    background: #fff;
    border: 1px solid #ccc;
    border-radius: 12px;
    min-width: 140px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    z-index: 100;
}

.dropdown li button {
    display: flex;
    align-items: center;
    gap: 8px;
    width: 100%;
    padding: 6px 12px;
    background: none;
    border: none;
    text-align: left;
    cursor: pointer;
}

.dropdown li button .flag svg {
    border-radius: 50%;
    width: 24px;
    height: 24px;
}

.dropdown li button:hover {
    background: #f1f1f1;
}
</style>
