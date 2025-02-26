<script setup>
import FlashMessage from '@/Components/FlashMessage.vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import Pagination from '@/Components/Pagination.vue';
import Table from '@/Components/Table.vue';
import { computed } from 'vue'


// todos を props で受け取る
const props = defineProps({
    todos: Object,
});

const updateStatus = (todo, event) => {
    const form = useForm({ status: Number(event.target.value) });
    form.patch(route('user.todos.updateStatus', { todo: todo.id }), {
        preserveScroll: true,
        onSuccess: () => {
            todo.status = form.status;
        }
    });
};

// テーブルのヘッダー情報
const headers = [
    { label: 'ID', key: 'id_user',  class: 'w-1/12' },
    { label: '宿題', key: 'homework',  class: 'w-4.5/12' },
    { label: '備考', key: 'memo',  class: 'w-4/12' },
    { label: '期限', key: 'deadline',  class: 'w-2/12' },
    { label: '状況', key: 'status',  class: 'w-1/12' }
];

// 完了している宿題の数を計算
const completedCount = computed(() => props.todos.data.filter(todo => todo.status === 0).length);

// 宿題の合計数を計算
const totalCount = computed(() => props.todos.data.length);

// 表示メッセージを計算
const statusMessage = computed(() => {
    return completedCount.value === totalCount.value
        ? "すべての宿題を完了済です"
        : `完了 ${completedCount.value} / ${totalCount.value}`;
});

</script>

<template>
    <Head title="宿題一覧" />
    <AuthenticatedLayout>
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
                                    <Link as="button" :href="route('todos.create')"
                                        class="flex ml-auto text-white bg-indigo-500 border-0 py-2 px-6 focus:outline-none hover:bg-indigo-600 rounded">
                                        新規宿題登録
                                    </Link>
                                </div>
                                <div class="flex justify-between items-center">
                                    <span class="text-lg font-bold text-gray-700">{{ statusMessage }}</span>
                                </div>
                                <!-- Table コンポーネントを適用 -->
                                <Table
                                    :headers="headers"
                                    :items="todos.data"
                                    linkRoute="todos.show"
                                    customStatus="customStatus"
                                >
                                    <!-- ステータスのカスタム表示 -->
                                    <template #status="{ item }">
                                        <select @change="updateStatus(item, $event)"
                                            class="border-gray-300 rounded-lg text-center"
                                            :class="item.status === 1 ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700'">
                                            <option value="1" :selected="item.status === 1">実施中</option>
                                            <option value="0" :selected="item.status === 0">完了</option>
                                        </select>
                                    </template>
                                </Table>
                            </div>
                            <Pagination class="mt-6" :links="todos.links" />
                        </section>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
