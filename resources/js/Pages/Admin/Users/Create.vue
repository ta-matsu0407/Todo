<script setup>
import AdminAuthenticatedLayout from '@/Layouts/AdminAuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import { reactive, computed, watch} from 'vue'
import { router } from '@inertiajs/core'
import { Core as YubinBangoCore } from "yubinbango-core2";

defineProps({
    errors: Object
})

const form = reactive({
    name: null,
    kana: null,
    tel: null,
    email: null,
    postcode: null,
    address: null,
    birthday: null,
    gender: null,
    password: null,
    password_confirmation: null,
    memo: null,
})

const fetchAddress = () => {
    new YubinBangoCore(String(form.postcode), (value) => {
    form.address = value.region + value.locality + value.street
    })
}

const passwordsMatch = computed(() => form.password === form.password_confirmation);

const storeUser = () => {
    router.post('/admin/users', form)
}

// 郵便番号の長さをリアルタイムでチェック
watch(() => form.postcode, (newVal) => {
    if (newVal.length > 7) {
        alert('郵便番号は7桁以内で入力してください');
        form.postcode = newVal.slice(0, 7);
    }
});
// watch() は Vue のリアクティブなデータ（変数）の変化を監視 するための関数です。

// watch(() => form.postcode, (newVal) => { ... })
// この部分は form.postcode の値が変わるたびに関数が実行される という意味です。

// () => form.postcode
// → これが 「監視対象」 を指定する部分で、form.postcode の変化を監視します。
// (newVal) => { ... }
// → form.postcode の値が変わると newVal に新しい値が渡されて、中の処理が実行されます。

</script>

<template>
    <Head title="新規生徒登録" />

    <AdminAuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                新規生徒登録
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <section class="text-gray-600 body-font relative">
                            <form @submit.prevent="storeUser">
                                <!-- submit.prevent：SPA、post通信を行った時にページの読み込みを防ぐ -->
                                <!-- storeUser：scriptで設定したメソッドを実行 -->
                                <div class="container px-5 py-8 mx-auto">
                                    <div class="lg:w-1/2 md:w-2/3 mx-auto">
                                        <div class="flex flex-wrap -m-2">
                                            <div class="p-2 w-full">
                                                <div class="relative">
                                                    <label for="name" class="leading-7 text-sm text-gray-600">生徒名</label>
                                                    <input type="text" id="name" name="name" v-model="form.name" class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                                    <div v-if="errors.name">{{ errors.name }}</div>
                                                </div>
                                            </div>
                                            <div class="p-2 w-full">
                                                <div class="relative">
                                                    <label for="kana" class="leading-7 text-sm text-gray-600">カナ</label>
                                                    <input type="text" id="kana" name="kana" v-model="form.kana" class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                                    <div v-if="errors.kana">{{ errors.kana }}</div>
                                                </div>
                                            </div>
                                            <div class="p-2 w-full">
                                                <div class="relative">
                                                    <label class="leading-7 text-sm text-gray-600">性別</label>
                                                    <input type="radio" id="gender0" name="gender" v-model="form.gender" value="0" >
                                                    <label for="gender0" class="ml-2 mr-10">男性</label>
                                                    <input type="radio" id="gender1" name="gender" v-model="form.gender" value="1" >
                                                    <label for="gender1" class="ml-2 mr-10">女性</label>
                                                    <input type="radio" id="gender2" name="gender" v-model="form.gender" value="2" >
                                                    <label for="gender2" class="ml-2 mr-10">その他</label>
                                                    <div v-if="errors.gender">{{ errors.gender }}</div>
                                                </div>
                                            </div>
                                            <div class="p-2 w-full">
                                                <div class="relative">
                                                    <label for="tel" class="leading-7 text-sm text-gray-600">電話番号</label>
                                                    <input type="tel" id="tel" name="tel" v-model="form.tel" class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                                    <div v-if="errors.tel">{{ errors.tel }}</div>
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
                                                    <label for="postcode" class="leading-7 text-sm text-gray-600">郵便番号</label>
                                                    <input type="text" id="postcode" name="postcode" @change="fetchAddress" v-model="form.postcode" class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                                    <div v-if="errors.postcode">{{ errors.postcode }}</div>
                                                </div>
                                            </div>
                                            <div class="p-2 w-full">
                                                <div class="relative">
                                                    <label for="address" class="leading-7 text-sm text-gray-600">住所</label>
                                                    <input type="text" id="address" name="address" v-model="form.address" class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                                    <div v-if="errors.address">{{ errors.address }}</div>
                                                </div>
                                            </div>
                                            <div class="p-2 w-full">
                                                <div class="relative">
                                                    <label for="birthday" class="leading-7 text-sm text-gray-600">誕生日</label>
                                                    <input type="date" id="birthday" name="birthday" v-model="form.birthday" class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                                    <div v-if="errors.birthday">{{ errors.birthday }}</div>
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
                                                    <label for="password_confirmation" class="leading-7 text-sm text-gray-600">パスワード（確認用）</label>
                                                    <input type="password" id="password_confirmation" v-model="form.password_confirmation" class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                                    <div v-if="!passwordsMatch" class="text-red-500 text-sm">パスワードが一致しません。</div>
                                                </div>
                                            </div>
                                            <div class="p-2 w-full">
                                                <div class="relative">
                                                    <label for="memo" class="leading-7 text-sm text-gray-600">備考</label>
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
