<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import FlashMessage from '@/Components/FlashMessage.vue';

const props = defineProps({
  user: Object
})
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-2xl font-semibold leading-tight text-gray-800">
                 {{ user.name }}のやることリスト
            </h2>
        </template>

        <div class="py-16">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <section class="text-gray-600 body-font relative">
                                <div class="container px-5 py-8 mx-auto">
                                    <FlashMessage />
                                    <div class="lg:w-1/2 md:w-2/3 mx-auto">
                                        <div class="flex flex-wrap -m-2">
                                            <div class="p-2 w-full">
                                                <div class="relative">
                                                    <!-- <label for="memo" class="leading-7 text-sm text-gray-600">メモ</label> -->
                                                    <label for="memo" class="leading-7 text-lg font-semibold text-gray-800">やること</label>
                                                    <div id="memo" style="white-space: pre-wrap;" class="w-full bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 h-32 text-base outline-none text-gray-700 py-1 px-3 resize-none leading-6 transition-colors duration-200 ease-in-out">
                                                        <!-- style="white-space: pre-wrap;":改行がそのまま表示される -->
                                                        {{ user.memo }}
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="p-2 w-full">
                                                <div class="relative">
                                                    <label for="status" class="leading-7 text-lg font-semibold text-gray-800">状況</label>
                                                    <div id="status" class="w-full bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                                        <!-- <span v-if="user.status === 1">実施中</span> -->
                                                        <!-- <p v-if="user.status === 1" class="flex items-center text-green-500"> -->
                                                        <p v-if="user.status === 1" class="flex items-center text-green-700 bg-green-100 rounded-lg p-2">
                                                            <!-- <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4" />
                                                            </svg> -->
                                                            実施中
                                                        </p>
                                                        <!-- <span v-if="user.status === 0">完了</span> -->
                                                        <!-- <p v-if="user.status === 0" class="flex items-center text-red-500"> -->
                                                        <p v-if="user.status === 0" class="flex items-center text-red-700 bg-red-100 rounded-lg p-2">
                                                            <!-- <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                                            </svg> -->
                                                            完了
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="p-2  w-full">
                                                <Link as="button" :href="route('user.edit', { user: user.id})" class="flex mx-auto text-white bg-indigo-500 border-0 py-2 px-8 focus:outline-none hover:bg-indigo-600 rounded text-lg">
                                                    編集する
                                                </Link>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                        </section>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
