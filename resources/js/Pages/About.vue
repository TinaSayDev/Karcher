<script>
import DefaultLayout from '@/Layouts/DefaultLayout.vue';
import SectionTwoCol from '@/Components/Custom/Parts/SectionTwoCol.vue';

export default {
    components: {
        DefaultLayout,
        SectionTwoCol
    },
    data() {
        return {
            pageTitle: 'О нас'
        }
    },
    props: {
        breadcrumbs: {
            default: () => [
                { label: 'Главная', href: '/' },
                { label: 'О нас' }
            ]
        }
    }
}
</script>


<template>
    <DefaultLayout :title="pageTitle" :breadcrumbs="breadcrumbs">

    <div class="content">
        <h3>Kärcher: The world Leader in Cleaning Technology since 1935</h3>
        <p>The ASIA CLEAN CENTER company is an authorized sales representative of the German concern ALFRED KARCHER GmbH
            & Co.KG ", the world's largest manufacturer of harvesting equipment. The company has been present and
            developing in the Uzbek market since 2011. During this time, a lot of work has been done to promote and
            develop the brand and customer service.</p>
        <p>Kärcher is not just a brand, it is a name that has become synonymous with purity and innovation all over the
            world. Founded in 1935 by Alfred Kercher, our company has been a world leader in the production of
            harvesting equipment for decades. We are constantly implementing innovative technologies and striving for
            excellence, offering solutions that make the lives and work of people around the world easier, cleaner and
            more efficient.</p>

        <p> Kärcher is known for its unwavering quality, reliability and German precision. From mini pressure washers
            for homes to integrated systems for industrial plants, each Kärcher product is designed with one goal in
            mind: to ensure impeccable cleanliness and maximum productivity. We invest in research and development to
            offer the most advanced and environmentally friendly solutions.</p>

        <p>Our success is built on the trust of millions of customers who choose Kärcher for innovation, durability and
            outstanding service. We are proud to help our clients create a healthy and clean environment wherever they
            are.</p>
    </div>
    <SectionTwoCol/>
    </DefaultLayout>
</template>
