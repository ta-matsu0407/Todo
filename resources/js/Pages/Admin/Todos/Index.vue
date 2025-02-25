<script setup>
import FlashMessage from '@/Components/FlashMessage.vue';
import AdminAuthenticatedLayout from '@/Layouts/AdminAuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import Pagination from '@/Components/Pagination.vue'
import { ref } from 'vue'
// import { router as Inertia } from '@inertiajs/core';
import { router } from '@inertiajs/core';
import SearchTodos from '@/Components/SearchBar.vue'
import { defineProps } from 'vue';
import CommonTable from '@/Components/Table.vue';

defineProps({
    todos: Object,
});

const headers = [
    { label: 'ID', key: 'id', class: 'w-1/12 rounded-tl rounded-bl' },
    { label: '生徒名', key: 'user.name', class: 'w-2/12' },
    { label: '宿題', key: 'homework', class: 'w-6/12' },
    { label: '期限', key: 'deadline', class: 'w-1.5/12' },
    { label: '状況', key: 'status', class: 'w-1.5/12' }
];

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
                                    <CommonTable
                                        :headers="headers"
                                        :items="todos.data"
                                        linkRoute="admin.todos.show"
                                    />
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
