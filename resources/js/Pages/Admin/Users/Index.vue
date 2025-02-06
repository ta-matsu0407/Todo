<script setup>
import FlashMessage from '@/Components/FlashMessage.vue';
import AdminAuthenticatedLayout from '@/Layouts/AdminAuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import Pagination from '@/Components/Pagination.vue'
import { ref } from 'vue'
import { router } from '@inertiajs/core';

defineProps({
    users: Object,
})

const search = ref('')

const searchUsers = () => {
    router.get(route('admin.users.index', { search: search.value }))
}

const exportCsv = () => {
    window.location.href = route('admin.users.export');
};

</script>

<template>
    <Head title="生徒一覧画面" />

    <AdminAuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                生徒一覧画面
            </h2>
        </template>
        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <section class="text-gray-600 body-font">
                            <div class="container px-5 py-8 mx-auto">
                                <FlashMessage />
                                <div class="flex pl-4 my-4 w-full mx-auto">
                                    <div class="flex items-center space-x-2">
                                        <input type="text" name="search" v-model="search" placeholder="生徒名で検索" class="flex-1 bg-gray-100 border border-gray-300 rounded px-4 py-2 text-gray-700">
                                        <button class="bg-blue-500 text-white px-4 py-2 hover:bg-blue-600 " @click="searchUsers">
                                            検索
                                        </button>
                                    </div>
                                    <Link as="button" :href="route('admin.users.create')" class="flex ml-auto text-white bg-indigo-500 border-0 py-2 px-6 focus:outline-none hover:bg-indigo-600 rounded">新規生徒登録</Link>
                                </div>
                                <div class="w-full overflow-auto">
                                    <table class="table-auto w-full text-left whitespace-no-wrap">
                                        <thead>
                                            <tr>
                                                <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100 rounded-tl rounded-bl w-1/12">ID</th>
                                                <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100 w-2/12">名前</th>
                                                <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100 w-2/12">電話番号</th>
                                                <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100 w-2/12">メールアドレス</th>
                                                <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100 w-5/12">備考</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="user in users.data" :key="user.id">
                                                <td class="border-b-2 border-gray-200 px-4 py-3">
                                                    <Link class="text-blue-400 hover:underline" :href="route('admin.users.show', { user: user.id})">
                                                        {{ user.id }}
                                                    </Link>
                                                </td>
                                                <td class="border-b-2 border-gray-200 px-4 py-3">{{ user.name }}</td>
                                                <td class="border-b-2 border-gray-200 px-4 py-3">{{ user.tel }}</td>
                                                <td class="border-b-2 border-gray-200 px-4 py-3">{{ user.email }}</td>
                                                <td class="border-b-2 border-gray-200 px-4 py-3">{{ user.memo }}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <Pagination class="mt-6" :links="users.links"></Pagination>
                            <div class="flex pl-4 my-4 w-full mx-auto">
                                <button
                                    @click="exportCsv"
                                    class="px-4 py-2 bg-green-500 text-white rounded hover:bg-green-600">
                                    CSVエクスポート
                                </button>
                            </div>
                        </section>
                    </div>
                </div>
            </div>
        </div>
    </AdminAuthenticatedLayout>
</template>
