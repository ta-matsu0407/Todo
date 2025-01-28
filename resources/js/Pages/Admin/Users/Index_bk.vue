<script setup>
import FlashMessage from '@/Components/FlashMessage.vue';
import AdminAuthenticatedLayout from '@/Layouts/AdminAuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import { onMounted } from 'vue';
import Pagination from '@/Components/Pagination.vue'

const props = defineProps({
    users: Object
})
// paginateはオブジェクトとして渡される

// onMounted(() => { //ページが表示されたタイミングで実行
//     console.log(props.users)
// })

</script>

<template>
    <ul v-for="user in users.data" :key="user.id">
        <li>{{ user.id }}</li>
        <li>{{ user.name }}</li>
    </ul>
    <Pagination class="mt-6" :links="users.links"></Pagination>
</template>
