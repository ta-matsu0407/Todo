<script setup>
import FlashMessage from '@/Components/FlashMessage.vue';
import adminAuthenticatedLayout from '@/Layouts/AdminAuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
defineProps({
    users: Array
})
//配列で変数の受け取り

</script>

<template>
    <Head title="ユーザー一覧" />

    <adminAuthenticatedLayout>
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
                                <div class="flex pl-4 my-4 lg:w-2/3 w-full mx-auto">
                                    <Link as="button" :href="route('admin.users.create')" class="flex ml-auto text-white bg-indigo-500 border-0 py-2 px-6 focus:outline-none hover:bg-indigo-600 rounded">ユーザー登録</Link>
                                    <!-- Linkのみだとaタグになるが、Link as="button"とするとbuttonタグ -->                                </div>
                                <div class="lg:w-2/3 w-full mx-auto overflow-auto">
                                    <table class="table-auto w-full text-left whitespace-no-wrap">
                                        <thead>
                                            <tr>
                                                <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100 rounded-tl rounded-bl">ID</th>
                                                <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">名前</th>
                                                <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">メモ</th>
                                                <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">ステータス</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="user in users" :key="user.id">
                                                <!-- 単数形 in 複数形 :keyもつける(ソートや削除などで順序変わっても状態を保持するため) -->
                                                <td class="border-b-2 border-gray-200 px-4 py-3">
                                                    <Link class="text-blue-400" :href="route('admin.users.show', { user: user.id})">
                                                        {{ user.id }}</Link>
                                                </td>
                                                <td class="border-b-2 border-gray-200 px-4 py-3">{{ user.name }}</td>
                                                <td class="border-b-2 border-gray-200 px-4 py-3">{{ user.memo }}</td>
                                                <td class="border-b-2 border-gray-200 px-4 py-3">
                                                    <span v-if="user.status === 1">実施中</span>
                                                    <span v-if="user.status === 0">完了</span>
                                                    <!-- v-if:条件によって表示を変える -->
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </section>
                        </div>
                    </div>
                </div>
            </div>
    </adminAuthenticatedLayout>
</template>
