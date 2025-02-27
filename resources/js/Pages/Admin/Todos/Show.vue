<script setup>
import AdminAuthenticatedLayout from '@/Layouts/AdminAuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import { router } from '@inertiajs/core';

defineProps({
    todo: Object,

})

const deleteTodo = id => {
    router.delete(route('admin.todos.destroy', {todo: id}), {
    onBefore: () => confirm('本当に削除しますか?')
    })
}

// アロー関数で引数が１つの場合は()を省略できる
</script>

<template>
    <Head title="生徒宿題詳細画面" />

    <AdminAuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                {{ todo.user.name }} さんの宿題詳細画面
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <section class="text-gray-600 body-font relative">
                            <div class="container px-5 py-8 mx-auto">
                                <div class="lg:w-1/2 md:w-2/3 mx-auto">
                                    <div class="flex flex-wrap -m-2">
                                        <div class="p-2 w-full">
                                            <div class="relative">
                                                <label for="name" class="leading-7 text-sm text-gray-600">生徒名</label>
                                                <div id="name" class="w-full bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                                <!-- 表示させるだけなので、input→divタグに -->
                                                    {{ todo.user.name }}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="p-2 w-full">
                                            <div class="relative">
                                                <label for="homework" class="leading-7 text-sm text-gray-600">宿題</label>
                                                <div  id="homework" class="w-full bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                                    {{ todo.homework }}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="p-2 w-full">
                                            <div class="relative">
                                                <label for="deadline" class="leading-7 text-sm text-gray-600">期限</label>
                                                <div id="deadline" class="w-full bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                                    {{ todo.deadline }}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="p-2 w-full">
                                            <div class="relative">
                                                <label for="memo" class="leading-7 text-sm text-gray-600">メモ</label>
                                                <div id="memo" style="white-space: pre-wrap;" class="w-full bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 h-32 text-base outline-none text-gray-700 py-1 px-3 resize-none leading-6 transition-colors duration-200 ease-in-out">
                                                    <!-- style="white-space: pre-wrap;":改行がそのまま表示される -->
                                                    {{ todo.memo }}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="p-2 w-full">
                                            <div class="relative">
                                                <label for="status" class="leading-7 text-sm text-gray-600">状況</label>
                                                <div id="status" class="w-full bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                                    <span v-if="todo.status === 1" class="flex items-center text-green-700 bg-green-100 rounded-lg p-2">実施中</span>
                                                    <span v-if="todo.status === 0" class="flex items-center text-red-700 bg-red-100 rounded-lg p-2">完了</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="p-2 w-full">
                                            <Link as="button" :href="route('admin.todos.edit', { todo: todo.id})" class="flex mx-auto text-white bg-indigo-500 border-0 py-2 px-8 focus:outline-none hover:bg-indigo-600 rounded text-lg">編集する</Link>
                                            <!-- Linkのみだとaタグ、as="button"つけてボタンに -->
                                        </div>
                                        <div class="p-2 w-full">
                                            <button @click="deleteTodo(todo.id)" class="flex mx-auto text-white bg-red-500 border-0 py-2 px-8 focus:outline-none hover:bg-red-600 rounded text-lg">削除する</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </section>
                    </div>
                </div>
            </div>
        </div>
    </AdminAuthenticatedLayout>
</template>
