<script setup>
import AdminAuthenticatedLayout from '@/Layouts/AdminAuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import { reactive } from 'vue'
import { router as Inertia } from '@inertiajs/core';

//コントローラから渡ってくる情報をdefinePropsで受けて、それを変数に入れておく
const props = defineProps({
    todo: Object,
    errors: Object
})

// 変数で渡したものをreactiveでリアクティブ対応にする
const form = reactive({
    id: props.todo.id,
    // name: props.todo.name,
    homework: props.todo.homework,
    deadline: props.todo.deadline,
    memo: props.todo.memo,
    status: props.todo.status,
})

const updateTodo = id => {
    // if (!passwordsMatch.value) {
    //     alert("パスワードが一致しません。");
    //     return;
    // }
Inertia.put(route('admin.todos.update', { todo: id}), form)
}
//route:listをみると、updateはPUTとある

</script>

<template>
    <Head title="宿題編集" />

    <AdminAuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                {{ todo.user.name }} さんの宿題編集画面
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <section class="text-gray-600 body-font relative">
                            <form @submit.prevent="updateTodo(form.id)">
                                <div class="container px-5 py-8 mx-auto">
                                    <div class="lg:w-1/2 md:w-2/3 mx-auto">
                                        <div class="flex flex-wrap -m-2">
                                            <div class="p-2 w-full">
                                                <div class="relative">
                                                    <label for="name" class="leading-7 text-sm text-gray-600">生徒名</label>
                                                    <div id="name" class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                                        {{ todo.user.name }}
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="p-2 w-full">
                                                <div class="relative">
                                                    <label for="homework" class="leading-7 text-sm text-gray-600">宿題</label>
                                                    <input type="homework" id="homework" name="homework" v-model="form.homework" class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                                    <div v-if="errors.homework">{{ errors.homework }}</div>
                                                </div>
                                            </div>
                                            <div class="p-2 w-full">
                                                <div class="relative">
                                                    <label for="deadline" class="leading-7 text-sm text-gray-600">期限</label>
                                                    <input type="date" id="birthday" name="deadline" v-model="form.deadline" class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                                    <div v-if="errors.deadline">{{ errors.deadline }}</div>
                                                </div>
                                            </div>
                                            <div class="p-2 w-full">
                                                <div class="relative">
                                                    <label for="memo" class="leading-7 text-sm text-gray-600">メモ</label>
                                                    <textarea id="memo" name="memo" v-model="form.memo" class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 h-32 text-base outline-none text-gray-700 py-1 px-3 resize-none leading-6 transition-colors duration-200 ease-in-out"></textarea>
                                                </div>
                                            </div>
                                            <div class="p-2 w-full">
                                                <div class="relative">
                                                    <label for="status" class="leading-7 text-sm text-gray-800">状況</label>
                                                    <select
                                                        id="status"
                                                        name="status"
                                                        v-model="form.status"
                                                        class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out"
                                                    >
                                                        <option value="1" >実施中</option>
                                                        <option value="0">完了</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="p-2 w-full">
                                                <button class="flex mx-auto text-white bg-indigo-500 border-0 py-2 px-8 focus:outline-none hover:bg-indigo-600 rounded text-lg">更新</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </section>
                    </div>
                </div>
            </div>
        </div>
    </AdminAuthenticatedLayout>
</template>
