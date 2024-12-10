<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import { reactive } from 'vue'
import { router as Inertia } from '@inertiajs/core';
import BreezeValidationErrors from '@/Components/ValidationErrors.vue';

const props = defineProps({
    user: Object,
    errors: Object
})

const form = reactive({
    id: props.user.id,
    memo: props.user.memo,
    status: props.user.status,
})

const updateUser = id => {
Inertia.put(route('user.update', { user: id}), form)
}
//route:listをみると、updateはPUTとある

</script>

<template>
    <Head title="ユーザー編集" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-2xl font-semibold leading-tight text-gray-800">
                {{ user.name }}の編集画面
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
                                                    <label for="memo" class="leading-7 text-lg font-semibold text-gray-800">やること</label>
                                                    <div id="memo" style="white-space: pre-wrap;" class="w-full bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 h-32 text-base outline-none text-gray-700 py-1 px-3 resize-none leading-6 transition-colors duration-200 ease-in-out">
                                                        {{ user.memo }}
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="p-2 w-full">
                                                <div class="relative">
                                                    <label for="status" class="leading-7 text-lg font-semibold text-gray-800">状況</label>
                                                    <!-- <input type="radio" id="status" name="status" v-model="form.status" value="1" > -->
                                                    <!-- v-model="form.status"として、form オブジェクトの status プロパティにバインド -->
                                                    <!-- value="1":statusが1の時にチェックが入る -->
                                                    <!-- <label class="ml-2 mr-10">実施中</label>
                                                    <input type="radio" id="status" name="status" v-model="form.status" value="0" >
                                                    <label class="ml-2 mr-10">完了</label> -->
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
                                                <button class="flex mx-auto text-white bg-indigo-500 border-0 py-2 px-8 focus:outline-none hover:bg-indigo-600 rounded text-lg">
                                                    更新
                                                </button>
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
    </AuthenticatedLayout>
</template>
