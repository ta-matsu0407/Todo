<script setup>
import FlashMessage from '@/Components/FlashMessage.vue';
import AdminAuthenticatedLayout from '@/Layouts/AdminAuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import Pagination from '@/Components/Pagination.vue'
import { ref } from 'vue'
import { router as Inertia } from '@inertiajs/core';


defineProps({
    users: Object,
})
// コントローラーから渡ってくる情報は、definePropsで受け取る
// 複数形のオブジェクトを受け取る
// ArrayではなくObjectで受け取れるのは？？

const search = ref('')
// フォームに入力された文字が入ってくる変数の作成
// ref を使うと、JavaScript の変数にリアクティブな機能を追加
// リアクティブとは、データが変わるとそれに紐づいた UI が自動的に更新される

// ref で定義した変数の値にアクセスしたり更新する際には、.value が必要
const searchUsers = () => {
    Inertia.get(route('admin.users.index', { search: search.value }))
}
// Inertia.get クライアント (ブラウザ) からサーバーへリクエストを送信
// search パラメータを付けてリクエストを送信
// 値を取得する → search.value
// 値を更新する → search.value = '新しい値'
// 第二引数の情報をcontrollerのindexメソッドに値を渡す

// const exportCsv = () => {
//     Inertia.get(route('admin.users.export'));
// };

const exportCsv = () => {
    window.location.href = route('admin.users.export'); // CSVエクスポートのルートへ遷移
};

</script>

<template>
    <Head title="ユーザー一覧" />

    <AdminAuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                ユーザー一覧
            </h2>
        </template>
        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <section class="text-gray-600 body-font">
                            <div class="container px-5 py-8 mx-auto">
                                <!-- py：上下方向のパディング -->
                                <FlashMessage />
                                <!-- importで読み込むことで、コンポーネントを使えるようにする -->
                                <div class="flex pl-4 my-4 lg:w-2/3 w-full mx-auto">
                                    <div class="flex items-center space-x-2">
                                        <input type="text" name="search" v-model="search" placeholder="カナ名・状況で検索" class="flex-1 bg-gray-100 border border-gray-300 rounded px-4 py-2 text-gray-700">
                                        <button class="bg-blue-500 text-white px-4 py-2 hover:bg-blue-600 " @click="searchUsers">
                                            検索
                                        </button>
                                    </div>
                                    <Link as="button" :href="route('admin.users.create')" class="flex ml-auto text-white bg-indigo-500 border-0 py-2 px-6 focus:outline-none hover:bg-indigo-600 rounded">ユーザー登録</Link>
                                    <!-- Linkのみだとaタグになるが、Link as="button"とするとbuttonタグ -->
                                </div>
                                <div class="lg:w-2/3 w-full mx-auto overflow-auto">
                                    <table class="table-auto w-full text-left whitespace-no-wrap">
                                        <thead>
                                            <tr>
                                                <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100 rounded-tl rounded-bl w-1/12">ID</th>
                                                <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100 w-2/12">名前</th>
                                                <!-- w-1/5で、列全体の幅の1/5を名前列に割り当て -->
                                                <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100 w-5/12">やること</th>
                                                <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100 w-2.5/12">期限</th>
                                                <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100 w-1.5/12">状況</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="user in users.data" :key="user.id">
                                                <!-- 単数形 in 複数形 -->
                                                <!-- v-forを回すときは :keyもつける(ソートや削除などで順序変わっても状態を保持するため) -->
                                                <td class="border-b-2 border-gray-200 px-4 py-3">
                                                    <Link class="text-blue-400 hover:underline" :href="route('admin.users.show', { user: user.id})">
                                                        {{ user.id }}</Link>
                                                </td>
                                                <!-- Linkコンポーネントで挟むことで、idをリンク化 -->
                                                <!-- { user: user.id }：ルートパラメータに渡すデータ 例えば、user.id が 1 なら、/admin/users/1 というURLが生成 -->
                                                <!-- ↑これはルートリスト情報を確認するとわかりやすい -->
                                                <td class="border-b-2 border-gray-200 px-4 py-3">{{ user.name }}</td>
                                                <td class="border-b-2 border-gray-200 px-4 py-3">{{ user.memo }}</td>
                                                <td class="border-b-2 border-gray-200 px-4 py-3">{{ user.deadline }}</td>
                                                <td class="border-b-2 border-gray-200 px-4 py-3">
                                                    <span v-if="user.status === 1" class="text-center text-green-700 bg-green-100 rounded-lg p-2">実施中</span>
                                                    <span v-if="user.status === 0" class="flex items-center justify-center text-red-700 bg-red-100 rounded-lg p-2 text-center">完了</span>
                                                    <!-- justify-center:Flexboxの横方向（左右）の配置を中央に
                                                    items-center:Flexboxの縦方向（上下）の配置を中央に -->
                                                    <!-- v-if:条件によって表示を変える -->
                                                    <!-- spanタグで、「インライン要素」をグルーピング -->
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <Pagination class="mt-6" :links="users.links"></Pagination>
                            <div class="flex pl-4 my-4 lg:w-2/3 w-full mx-auto">
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
