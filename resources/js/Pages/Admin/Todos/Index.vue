<script setup>
import FlashMessage from '@/Components/FlashMessage.vue';
import AdminAuthenticatedLayout from '@/Layouts/AdminAuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import Pagination from '@/Components/Pagination.vue'
import { ref } from 'vue'
// import { router as Inertia } from '@inertiajs/core';
import { router } from '@inertiajs/core';
import SearchTodos from '@/Components/SearchBar.vue'


defineProps({
    todos: Object,
})

const search = ref('')

// const searchTodos = () => {
//     Inertia.get(route('admin.todos.index', { search: search.value }))
// }

const searchTodos = (todos) => {
    router.get(route('admin.todos.index', { search: todos }))
}


</script>

<template>
    <Head title="宿題一覧" />

    <AdminAuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                宿題一覧
            </h2>
        </template>
        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <section class="text-gray-600 body-font">
                            <div class="container px-5 py-8 mx-auto">
                                <FlashMessage />
                                <SearchTodos placeholder="生徒名・状況で検索" @search="searchTodos">
                                    <template #extra>
                                        <Link as="button" :href="route('admin.todos.create')"
                                            class="flex ml-auto text-white bg-indigo-500 border-0 py-2 px-6
                                            focus:outline-none hover:bg-indigo-600 rounded">
                                            新規宿題登録
                                        </Link>
                                    </template>
                                </SearchTodos>
                                <!-- </div> -->
                                <div class="w-full overflow-auto">
                                    <table class="table-auto w-full text-left whitespace-no-wrap">
                                        <thead>
                                            <tr>
                                                <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100 rounded-tl rounded-bl w-1/12">ID</th>
                                                <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100 w-2/12">生徒名</th>
                                                <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100 w-6/12">宿題</th>
                                                <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100 w-1.5/12">期限</th>
                                                <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100 w-1.5/12">状況</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="todo in todos.data" :key="todo.id" v-if="todos">
                                                <td class="border-b-2 border-gray-200 px-4 py-3">
                                                    <Link class="text-blue-400 hover:underline" :href="route('admin.todos.show', { todo: todo.id})">
                                                        {{ todo.id }}
                                                    </Link>
                                                </td>
                                                <td v-if="todo.user" class="border-b-2 border-gray-200 px-4 py-3">{{ todo.user.name }}</td>
                                                <td v-else="todo.user" class="border-b-2 border-gray-200 px-4 py-3">削除済み生徒</td>
                                                <td class="border-b-2 border-gray-200 px-4 py-3">{{ todo.homework }}</td>
                                                <td class="border-b-2 border-gray-200 px-4 py-3">{{ todo.deadline }}</td>
                                                <td class="border-b-2 border-gray-200 px-4 py-3">
                                                    <span v-if="todo.status === 1" class="inline-block w-20 text-center text-green-700 bg-green-100 rounded-lg p-2">実施中</span>
                                                    <span v-if="todo.status === 0" class="inline-block w-20 text-center text-red-700 bg-red-100 rounded-lg p-2">完了</span>
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
    </AdminAuthenticatedLayout>
</template>
