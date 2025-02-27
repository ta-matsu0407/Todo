<script setup>
import FlashMessage from '@/Components/FlashMessage.vue';
import AdminAuthenticatedLayout from '@/Layouts/AdminAuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import Pagination from '@/Components/Pagination.vue'
import { ref } from 'vue'
// import { router as Inertia } from '@inertiajs/core';
import { router } from '@inertiajs/core';
import SearchUsers from '@/Components/SearchBar.vue';

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
const searchUsers = (users) => {
    // Inertia.get(route('admin.users.index', { search: search.value }))
    router.get(route('admin.users.index', { search: users }))

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
                                <!-- py：上下方向のパディング -->
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
                                    <table class="table-auto w-full text-left whitespace-no-wrap">
                                        <thead>
                                            <tr>
                                                <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100 rounded-tl rounded-bl w-1/12">ID</th>
                                                <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100 w-2/12">名前</th>
                                                <!-- w-1/5で、列全体の幅の1/5を名前列に割り当て -->
                                                <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100 w-2/12">電話番号</th>
                                                <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100 w-2/12">メールアドレス</th>
                                                <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100 w-5/12">備考</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="user in users.data" :key="user.id">
                                                <!-- 単数形 in 複数形 -->
                                                <!-- v-forを回すときは :keyもつける(ソートや削除などで順序変わっても状態を保持するため) -->
                                                <td class="border-b-2 border-gray-200 px-4 py-3">
                                                    <Link class="text-blue-400 hover:underline" :href="route('admin.users.show', { user: user.id})">
                                                        {{ user.id }}
                                                    </Link>
                                                </td>
                                                <!-- Linkコンポーネントで挟むことで、idをリンク化 -->
                                                <!-- { user: user.id }：ルートパラメータに渡すデータ 例えば、user.id が 1 なら、/admin/users/1 というURLが生成 -->
                                                <!-- ↑これはルートリスト情報を確認するとわかりやすい -->
                                                <td class="border-b-2 border-gray-200 px-4 py-3">{{ user.name }}</td>
                                                <td class="border-b-2 border-gray-200 px-4 py-3">{{ user.tel }}</td>
                                                <td class="border-b-2 border-gray-200 px-4 py-3">{{ user.email }}</td>
                                                <td class="border-b-2 border-gray-200 px-4 py-3">{{ user.memo }}</td>
                                                <!-- <td class="border-b-2 border-gray-200 px-4 py-3">
                                                    <span v-if="user.status === 1" class="text-center text-green-700 bg-green-100 rounded-lg p-2">実施中</span>
                                                    <span v-if="user.status === 0" class="flex items-center justify-center text-red-700 bg-red-100 rounded-lg p-2 text-center">完了</span> -->
                                                    <!-- justify-center:Flexboxの横方向（左右）の配置を中央に
                                                    items-center:Flexboxの縦方向（上下）の配置を中央に -->
                                                    <!-- v-if:条件によって表示を変える -->
                                                    <!-- spanタグで、「インライン要素」をグルーピング -->
                                                <!-- </td> -->
                                            </tr>
                                        </tbody>
                                    </table>
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
