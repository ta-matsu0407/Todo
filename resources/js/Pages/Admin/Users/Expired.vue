<script setup>
import FlashMessage from '@/Components/FlashMessage.vue';
import AdminAuthenticatedLayout from '@/Layouts/AdminAuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import Pagination from '@/Components/Pagination.vue'
import { router } from '@inertiajs/core';
import CommonTable from '@/Components/Table.vue';

defineProps({
    expiredUsers: Object,
})

const headers = [
    { label: 'ID', key: 'id', class: 'w-1/10 rounded-tl rounded-bl' },
    { label: '生徒名', key: 'name', class: 'w-1/5' },
    { label: '削除した日', key: 'deleted_at', class: 'w-1/3' },
    { label: '', key: 'actions', class: 'w-1/3' },
];

const deleteUser = id => {
    router.delete(route('admin.expired-users.destroy', {expiredUser: id}), {

    onBefore: () => confirm('本当に削除しますか?')
    })
}

</script>

<template>
    <Head title="削除済み生徒一覧" />

    <AdminAuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                削除済み生徒一覧
            </h2>
        </template>
        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <section class="text-gray-600 body-font">
                            <div class="container px-5 py-8 mx-auto">
                                <FlashMessage />
                                <div class="lg:w-2/3 w-full mx-auto overflow-auto">
                                    <CommonTable
                                        :headers="headers"
                                        :items="expiredUsers.data"
                                    >
                                        <template #actions="{ item }">
                                            <td class="border-b-2 border-gray-200 px-4 py-3 text-center">
                                                <button @click="deleteUser(item.id)" class="text-white bg-red-500 border-0 py-2 px-4 focus:outline-none hover:bg-red-600 rounded text-sm">
                                                    完全に削除する
                                                </button>
                                            </td>
                                        </template>
                                    </CommonTable>
                                </div>
                            </div>
                            <Pagination class="mt-6" :links="expiredUsers.links"></Pagination>
                        </section>
                    </div>
                </div>
            </div>
        </div>
    </AdminAuthenticatedLayout>
</template>
