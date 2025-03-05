<script setup>
import { ref } from 'vue';

const props = defineProps({
    placeholder:{
        type: String,
        default: '検索', // デフォルトのプレースホルダー
    },
});

const search = ref('');
const emit = defineEmits(['search']);
// defineEmits	親コンポーネントに送信できるイベントを定義する
const searchUsers = () => {
    emit('search', search.value);
};
// カスタムイベント名、渡したい値
// ref の値を取得するには .value を使う
// emit	定義したイベントを実際に発火（送信）する←親コンポーネントに

</script>

<template>
    <div class="flex pl-4 my-4 w-full mx-auto">
        <div class="flex items-center space-x-2">
        <input
            type="text"
            name="search"
            v-model="search"
            :placeholder="placeholder"
            class="flex-1 bg-gray-100 border border-gray-300 rounded px-4 py-2 text-gray-700"
        >
            <button class="bg-blue-500 text-white px-4 py-2 hover:bg-blue-600 " @click="searchUsers">
                検索
            </button>
        </div>
     <!-- 親コンポーネントから extra スロットを受け取る -->
     <slot name="extra"></slot>
    </div>
</template>
