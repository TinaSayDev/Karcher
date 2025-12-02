<template>
    <DefaultLayout :title="pageTitle" :breadcrumbs="breadcrumbs">
        <section class="blog-section container">
            <div class="posts-grid">
                <a
                    v-for="post in posts"
                    :key="post.id"
                    :href="`/blog/${post.slug}`"
                    class="post-card"
                >
                    <div
                        class="post-image"
                        :style="{ backgroundImage: `url(/images/${post.image})` }"
                    ></div>
                    <div class="post-text">
                        <div class="post-date">{{ formatDate(post.published_at) }}</div>
                        <h3 class="post-title">{{ post.translation?.title }}</h3>
                        <p class="post-excerpt">{{ post.translation?.excerpt }}</p>
                    </div>
                </a>
            </div>
        </section>
    </DefaultLayout>
</template>

<script>
import DefaultLayout from '@/Layouts/DefaultLayout.vue';
import axios from 'axios';

export default {
    name: 'Blog',
    components: {
        DefaultLayout,
    },
    data() {
        return {
            posts: [],
            pageTitle: 'Блог'
        };
    },
    props: {
        breadcrumbs: {
            default: () => [
                { label: 'Главная', href: '/' },
                { label: 'Блог' }
            ]
        }
    },
    async mounted() {
        try {
            const resp = await axios.get('/api/blog/posts');
            this.posts = resp.data;
        } catch (e) {
            console.error(e);
        }
    },
    methods: {
        formatDate(date) {
            if (!date) return '';
            const d = new Date(date);
            return d.toLocaleDateString();
        },
    },
};
</script>

<style scoped>

.posts-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 32px;
    justify-content: center;
}

.post-card {
    display: flex;
    flex-direction: column;
    width: 375px;
    height: 475px;
    border: 1px solid #e0e0e0;
    text-decoration: none;
    color: inherit;
    transition: transform 0.2s ease;
}

.post-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
}

.post-image {
    height: 238px;
    background-size: cover;
    background-position: center;
}

.post-text {
    padding: 40px;
    flex: 1;
    display: flex;
    flex-direction: column;
}

.post-date {
    font-size: 12px;
    color: #888888;
    margin-bottom: 8px;
}

.post-title {
    font-size: 18px;
    font-weight: 700;
    margin: 0 0 12px;
}

.post-excerpt {
    font-size: 14px;
    line-height: 1.4;
    color: #333333;
    flex: 1;
}

/* Адаптив */
@media(max-width: 1200px) {
    .posts-grid {
        grid-template-columns: repeat(2, 1fr);
        justify-items: center;
    }
}

@media(max-width: 768px) {
    .posts-grid {
        grid-template-columns: 1fr;
        justify-items: center;
    }
}
</style>
