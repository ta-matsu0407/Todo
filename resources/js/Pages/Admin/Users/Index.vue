<script setup>
import FlashMessage from '@/Components/FlashMessage.vue';
import AdminAuthenticatedLayout from '@/Layouts/AdminAuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import Pagination from '@/Components/Pagination.vue'
import { ref } from 'vue'
import { router } from '@inertiajs/core';
import SearchUsers from '@/Components/SearchBar.vue';
import CommonTable from '@/Components/Table.vue';

defineProps({
    users: Object,
});

const headers = [
    { label: 'ID', key: 'id', class: 'w-1/12 rounded-tl rounded-bl' },
    { label: '生徒名', key: 'name', class: 'w-2/12' },
    { label: '電話番号', key: 'tel', class: 'w-2/12' },
    { label: 'メールアドレス', key: 'email', class: 'w-2/12' },
    { label: '備考', key: 'memo', class: 'w-5/12' }
];

const search = ref('')

// ref で定義した変数の値にアクセスしたり更新する際には、.value が必要
const searchUsers = (users) => {
    router.get(route('admin.users.index', { search: users }))

}
// Inertia.get クライアント (ブラウザ) からサーバーへリクエストを送信
// search パラメータを付けてリクエストを送信
// 値を取得する → search.value
// 値を更新する → search.value = '新しい値'
// 第二引数の情報をcontrollerのindexメソッドに値を渡す

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
                                <!-- 検索フォーム (子コンポーネント) -->
                                <SearchUsers placeholder="生徒名で検索" @search="searchUsers">
                                    <!-- 親から extra スロットにボタンを挿入 -->
                                    <template #extra>
                                        <Link as="button" :href="route('admin.users.create')"
                                            class="flex ml-auto text-white bg-indigo-500 border-0 py-2 px-6
                                            focus:outline-none hover:bg-indigo-600 rounded">
                                            新規生徒登録
                                        </Link>
                                    </template>
                                </SearchUsers>
                                <div class="w-full overflow-auto">
                                    <CommonTable
                                        :headers="headers"
                                        :items="users.data"
                                        linkRoute="admin.users.show"
                                    />
                                </div>
                            </div>
                            <Pagination class="mt-6" :links="users.links"></Pagination>
                            <div class="flex pl-4 my-4 w-full mx-auto">
                                <button
                                    @click="exportCsv"
                                    class="px-4 py-2 bg-green-500 text-white rounded hover:bg-green-600"
                                >
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
