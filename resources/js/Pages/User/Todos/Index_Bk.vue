<script setup>
import FlashMessage from '@/Components/FlashMessage.vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import Pagination from '@/Components/Pagination.vue'
import { router as Inertia } from '@inertiajs/core';


defineProps({
    todos: Object,
})

const updateStatus = (todo, event) => {
    //フォームデータを作成（選択された status の値を取得）
  const form = useForm({ status: Number(event.target.value) });

//サーバーに PATCH リクエストを送信（ステータス更新）
  form.patch(route('user.todos.updateStatus', { todo: todo.id }), {
    preserveScroll: true, // 画面をリロードせずに変更
    onSuccess: () => {
      todo.status = form.status; //Vue 側のデータも更新（画面に即反映）
    }
  });
};
</script>

<template>
    <Head title="宿題一覧" />

    <AuthenticatedLayout>
        <!-- <template #header>
            <h2 v-if="todo.user" class="text-xl font-semibold leading-tight text-gray-800">
               {{ todos.user.name }}さんの宿題一覧
            </h2>
        </template> -->
        <template #header>
            <h2 v-if="todos?.data?.length" class="text-xl font-semibold leading-tight text-gray-800">
                {{ todos.data[0]?.user?.name ? `${todos.data[0].user.name}さんの宿題一覧` : '宿題一覧' }}
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
                                    </div>
                                        <Link as="button" :href="route('todos.create')" class="flex ml-auto text-white bg-indigo-500 border-0 py-2 px-6 focus:outline-none hover:bg-indigo-600 rounded">新規宿題登録</Link>
                                    </div>
                                <div class="w-full mx-auto overflow-auto">
                                    <table class="table-auto w-full text-left whitespace-no-wrap">
                                        <thead>
                                            <tr>
                                                <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100 rounded-tl rounded-bl w-0.5/12">ID</th>
                                                <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100 w-4.5/12">宿題</th>
                                                <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100 w-4/12">備考</th>
                                                <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100 w-2/12">期限</th>
                                                <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100 w-1/12">状況</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="todo in todos.data" :key="todo.id">
                                                <!-- <td class="border-b-2 border-gray-200 px-4 py-3">
                                                    <Link class="text-blue-400 hover:underline" :href="route('todos.show', { todo: todo.id})">
                                                        {{ todo.id }}</Link>
                                                </td> -->
                                                <td class="border-b-2 border-gray-200 px-4 py-3">
                                                    <!-- Userが作成したTodoならリンクを表示 -->
                                                    <Link
                                                        v-if="todo.created_by_type === 'user'" class="text-blue-400 hover:underline"
                                                        :href="route('todos.show', { todo: todo.id })">
                                                        {{ todo.id }}
                                                    </Link>
                                                    <!--　Adminが作成したTodoなら、リンクなし -->
                                                    <span v-else>{{ todo.id }}</span>
                                                </td>
                                                <td class="border-b-2 border-gray-200 px-4 py-3">{{ todo.homework }}</td>
                                                <td class="border-b-2 border-gray-200 px-4 py-3">{{ todo.memo }}</td>
                                                <td class="border-b-2 border-gray-200 px-4 py-3">{{ todo.deadline }}</td>
                                                <td class="border-b-2 border-gray-200 px-4 py-3">
                                                    <!-- <span v-if="todo.status === 1" class="text-center text-green-700 bg-green-100 rounded-lg p-2">実施中</span>
                                                    <span v-if="todo.status === 0" class="flex items-center justify-center text-red-700 bg-red-100 rounded-lg p-2 text-center">完了</span> -->
                                                    <select
                                                    @change="updateStatus(todo, $event)"
                                                    class=" border-gray-300 rounded-lg text-center":class="todo.status === 1 ?
                                                    'bg-green-100 text-green-700' : 'bg-red-100 text-red-700'"                                                    >
                                                    <option value="1" :selected="todo.status === 1">実施中</option>
                                                    <option value="0" :selected="todo.status === 0">完了</option>
                                                    </select>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <Pagination class="mt-6" :links="todos.links"></Pagination>
                        </section>
                        </div>
                    </div>
                </div>
            </div>
    </AuthenticatedLayout>
</template>
