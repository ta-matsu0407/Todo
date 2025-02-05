<script setup>
import AdminAuthenticatedLayout from '@/Layouts/AdminAuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import { reactive} from 'vue'
// import { router as Inertia } from '@inertiajs/core';
import { router } from '@inertiajs/core';

const props = defineProps({
    errors: Object,
    'users' : Array
})
// コントローラーからerrorsというオブジェクトが渡ってくる

const form = reactive({
    name: null, //v-model="form.name"で中身を見れる 入力毎に値が変化する
    homework: null,
    deadline: null,
    memo: null,
    user_id: null,
})

// const storeTodo = () => {
//     Inertia.post('/admin/todos', form)
// }

const storeTodo = () => {
    router.post('/admin/todos', form)
}


</script>

<template>
    <Head title="宿題登録" />

    <AdminAuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                宿題登録
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <section class="text-gray-600 body-font relative">
                            <form @submit.prevent="storeTodo">
                                <!-- submit.prevent：SPA、post通信を行った時にページの読み込みを防ぐ -->
                                <div class="container px-5 py-8 mx-auto">
                                    <div class="lg:w-1/2 md:w-2/3 mx-auto">
                                        <div class="flex flex-wrap -m-2">
                                            <div class="p-2 w-full">
                                                <div class="relative">
                                                    <label for="user" class="leading-7 text-sm text-gray-600">生徒名</label>
                                                    <select name="user" v-model="form.user_id" class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                                        <option v-for="user in users" :value="user.id" :key="user.id">
                                                            {{ user.id }} : {{ user.name }}
                                                        </option>
                                                    </select>
                                                    <div v-if="errors.user_id">{{ errors.user_id }}</div>
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
                                                    <input type="date" id="deadline" name="deadline" v-model="form.deadline" class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
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
                                                <button class="flex mx-auto text-white bg-indigo-500 border-0 py-2 px-8 focus:outline-none hover:bg-indigo-600 rounded text-lg">登録する</button>
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
