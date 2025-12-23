<template>
    <section class="nav-sticky">
    <nav class="main-menu container">
        <a href="/"><img src="/storage/karcher_logo.png" width="123" height="32" alt=""></a>
        <ul>
            <li
                v-for="item in items"
                :key="item.label"
                class="menu-item"
                @mouseenter="loadChildren(item)"
            >
                <Link :href="item.url">
                    <span>{{ item.label }}</span>
                    <div class="line top"></div>
                    <div class="line bottom"></div>
                    <span v-if="item.hasChildren" class="arrow">▾</span>
                </Link>

                <!-- Подкатегории -->
                <ul v-show="item.children && item.children.length" class="submenu">
                    <li v-for="child in item.children" :key="child.label">
                        <Link :href="child.url">{{ child.label }}</Link>
                    </li>
                </ul>
            </li>
        </ul>
    </nav>
    </section>
</template>

<script>
import { Link } from '@inertiajs/inertia-vue3';
import axios from 'axios';

export default {
    components: { Link },

    data() {
        const mainmenu = this.$page.props.mainmenu || {};

        return {
            menuItems: [
                { label: mainmenu.catalog, url: '/categories', slug: 'categories', children: [], hasChildren: false },
                { label: mainmenu.home_garden, url: '/categories/home-and-garden', slug: 'home-and-garden', children: [], hasChildren: true },
                { label: mainmenu.professional, url: '/categories/professional', slug: 'professional', children: [], hasChildren: true },
                { label: mainmenu.purchase_service, url: '/contacts', slug: null, children: [], hasChildren: false },
                { label: mainmenu.about, url: '/about', slug: null, children: [], hasChildren: false },
                { label: mainmenu.blog, url: '/blog', slug: null, children: [], hasChildren: false },
            ]
        }
    },
    computed: {
        items() {
            return this.menuItems;
        }
    },
    methods: {
        loadChildren(item) {
            if (!item.slug || !item.hasChildren || item.children.length > 0) return;

            axios.get(`/categories/${item.slug}/children`)
                .then(res => {
                    item.children = res.data.map(c => ({
                        label: c.name,
                        url: `/categories/${c.slug}`
                    }));
                })
                .catch(err => console.error('Ошибка загрузки подкатегорий:', err));
        }
    }
}
</script>


<style scoped>
.main-menu { display: flex; justify-content: space-between; padding: 20px 5px; font-size: 14px; font-weight: 500; background: #fff; align-items: center; }
ul { display: flex; gap: 32px; position: relative; }
li { position: relative; list-style: none; }
a { display: block; padding: 5px 0; position: relative; }
.line { position: absolute; height: 2px; background: #ffd800; width: 0%; transition: width 0.35s ease; }
.line.top { top: 0; right: 0; transform-origin: right; }
.line.bottom { bottom: 0; left: 0; transform-origin: left; }
a:hover .line { width: 100%; }
.nav-sticky{
    position: sticky;
    top: 0;
    z-index: 1000;
    background: #fff;
}
/* Стили подменю */
.submenu {
    position: absolute;
    top: 100%;
    left: 0;

    background: #fff;
    box-shadow: 0 2px 6px rgba(0,0,0,0.15);
    padding: 10px 0;
    min-width: 180px;
    z-index: 100;

    display: flex;
    flex-direction: column;

    /* Анимация */
    opacity: 0;
    visibility: hidden;
    transform: translateY(10px);
    pointer-events: none;

    transition:
        opacity 0.25s ease,
        transform 1s ease,
        visibility 0.25s ease;
}

.menu-item:hover > .submenu {
    opacity: 1;
    visibility: visible;
    transform: translateY(0);
    pointer-events: auto;
}
.menu-item:hover > .submenu,
.menu-item > .submenu:hover {
    opacity: 1;
    visibility: visible;
    transform: translateY(0);
    pointer-events: auto;
}
.submenu li {
    padding: 5px 20px;
}

.submenu li a {
    padding: 0;
}

.submenu li {
    padding: 5px 20px;
}
.submenu li a {
    padding: 0;
}
ul.submenu{
    gap:10px;
}
ul.submenu a:hover{
    text-decoration: underline;
    text-decoration-color: #F1DE04;
}

/* Адаптив */
@media (max-width: 800px) {
    .main-menu, .main-menu ul { flex-direction: column; align-items: flex-start; gap:5px; padding: 10px; }
    .submenu {
        position: static;
        box-shadow: none;
        padding-left: 20px;

        opacity: 1;
        visibility: visible;
        transform: none;
        pointer-events: auto;

        display: none;
    }

    .menu-item:hover > .submenu {
        display: flex;
    }

    .nav-sticky{
        position:unset;
    }
}
</style>
