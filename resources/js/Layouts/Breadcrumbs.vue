<template>
    <nav v-if="items.length" class="text-sm text-gray-500 mb-6">
        <ol class="flex flex-wrap gap-1">
            <li
                v-for="(item, index) in items"
                :key="index"
                class="flex items-center"
            >
                <button
                    v-if="item.href"
                    class="hover:text-black cursor-pointer"
                    @click="$inertia.visit(item.href)"
                >
                    {{ item.label }}
                </button>

                <span
                    v-else
                    class="text-black font-medium"
                >
                    {{ item.label }}
                </span>

                <span v-if="index < items.length - 1" class="mx-2">/</span>
            </li>
        </ol>
    </nav>
</template>

<script>
export default {
    name: "Breadcrumbs",
    props: {
        items: {
            type: Array,
            required: true,
            default: () => []
        }
    }
};
</script>
