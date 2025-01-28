<script setup>
import AdminAuthenticatedLayout from '@/Layouts/AdminAuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import { reactive } from 'vue'
import { router as Inertia } from '@inertiajs/core';
import BreezeValidationErrors from '@/Components/ValidationErrors.vue';

const props = defineProps({
    user: Object,
    errors: Object
})

const form = reactive({
    id: props.user.id,
    name: props.user.name,
    email: props.user.email,
    password: "", //パスワードは空で初期化
    memo: props.user.memo,
    status: props.user.status,
})

const updateUser = id => {
Inertia.put(route('admin.users.update', { user: id}), form)
}
//route:listをみると、updateはPUTとある

</script>

<template>
    <Head title="ユーザー編集" />

    <AdminAuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                ユーザー編集
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <section class="text-gray-600 body-font relative">
                            <form @submit.prevent="updateUser(form.id)">
                                <!-- 更新ボタンを押したらsubmitが走り、formが走り、updateUserメソッドが走る -->
                                <!-- sectionタグを目印にformタグ -->
                                <!-- submit.prevent：SPA、post通信を行った時にページの読み込みを防ぐ -->
                                <!-- updateUser：scriptで設定したメソッドを実行 -->
                                <div class="container px-5 py-8 mx-auto">
                                    <div class="lg:w-1/2 md:w-2/3 mx-auto">
                                        <div class="flex flex-wrap -m-2">
                                            <div class="p-2 w-full">
                                                <div class="relative">
                                                    <label for="name" class="leading-7 text-sm text-gray-600">氏名</label>
                                                    <input type="text" id="name" name="name" v-model="form.name" class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                                    <!-- v-model:リアクティブに -->
                                                    <div v-if="errors.name">{{ errors.name }}</div>
                                                </div>
                                            </div>
                                            <div class="p-2 w-full">
                                                <div class="relative">
                                                    <label for="email" class="leading-7 text-sm text-gray-600">メールアドレス</label>
                                                    <input type="email" id="email" name="email" v-model="form.email" class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                                    <div v-if="errors.email">{{ errors.email }}</div>
                                                </div>
                                            </div>
                                            <div class="p-2 w-full">
                                                <div class="relative">
                                                    <label for="password" class="leading-7 text-sm text-gray-600">パスワード</label>
                                                    <input type="password" id="password" name="password" v-model="form.password" class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                                    <div v-if="errors.password">{{ errors.password }}</div>
                                                </div>
                                            </div>
                                            <div class="p-2 w-full">
                                                <div class="relative">
                                                    <label for="status" class="leading-7 text-sm text-gray-600">ステータス</label>
                                                    <input type="radio" id="status" name="status" v-model="status" value="1" >
                                                    <!-- value="1":statusが1の時にチェックが入る -->
                                                    <label class="ml-2 mr-10">実施中</label>
                                                    <input type="radio" id="status" name="status" v-model="status" value="0" >
                                                    <label class="ml-2 mr-10">完了</label>
                                                </div>
                                            </div>
                                            <div class="p-2 w-full">
                                                <!-- w-full:横幅いっぱい -->
                                                <div class="relative">
                                                    <label for="memo" class="leading-7 text-sm text-gray-600">メモ</label>
                                                    <textarea id="memo" name="memo" v-model="form.memo" class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 h-32 text-base outline-none text-gray-700 py-1 px-3 resize-none leading-6 transition-colors duration-200 ease-in-out"></textarea>
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
