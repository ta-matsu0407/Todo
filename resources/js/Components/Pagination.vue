<script setup>
import { Link } from '@inertiajs/vue3';
defineProps({ links: Array })
</script>

<template>
    <div v-if="links.length > 3" class="flex justify-center mt-4">
        <nav class="inline-flex items-center space-x-2" aria-label="Pagination">
            <template v-for="(link, index) in links" :key="index">
                <!-- アクティブページ -->
                <span
                    v-if="link.active"
                    class="px-4 py-2 text-white bg-blue-600 border border-blue-600 rounded shadow-sm">
                    <span v-html="link.label"></span>
                </span>

                <!-- 非アクティブページ -->
                <a
                    v-else-if="link.url"
                    :href="link.url"
                    class="px-4 py-2 text-gray-700 border border-gray-300 rounded hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50"
                    v-html="link.label">
                </a>

                <!-- nullリンク（クリック不可） -->
                <span
                    v-else
                    class="px-4 py-2 text-gray-400 border border-gray-300 rounded cursor-not-allowed"
                    v-html="link.label">
                </span>
            </template>
        </nav>
    </div>
</template>

