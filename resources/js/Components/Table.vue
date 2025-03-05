<script setup>
import { defineProps } from 'vue';
import { Link } from '@inertiajs/vue3';

defineProps({
    headers: Array,  // テーブルのヘッダー情報
    items: Array,    // 表示するデータ
    linkRoute: String, // リンクのルート
    customStatus: String,
});

// ネストされたキーに対応する関数
const getValue = (item, key) => {
  return key.split('.').reduce((obj, prop) => obj?.[prop] ?? '', item);
};
</script>

<template>
    <div class="w-full overflow-auto">
        <table class="table-auto w-full text-left whitespace-no-wrap">
            <thead>
                <tr>
                    <th v-for="(header, index) in headers" :key="index"
                        class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100"
                        :class="header.class">
                        {{ header.label }}
                    </th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="item in items" :key="item.id">
                    <td v-for="(header, index) in headers" :key="index" class="border-b-2 border-gray-200 px-4 py-3">
                        <!-- Admin側のIDリンク -->
                        <template v-if="header.key === 'id'">
                            <template v-if="linkRoute">
                                <Link class="text-blue-400 hover:underline" :href="route(linkRoute, { id: item.id })">
                                    {{ item.id }}
                                </Link>
                            </template>
                            <template v-else>
                                {{ item.id }}
                            </template>
                        </template>
                        <!-- User側のIDリンク -->
                        <template v-else-if="header.key === 'id_user'">
                            <template v-if="item.created_by_type === 'user'">
                                <Link
                                     class="text-blue-400 hover:underline"
                                    :href="route(linkRoute, { id: item.id })">
                                    {{ item.id }}
                                </Link>
                            </template>
                            <template v-else>
                                {{ item.id }}
                            </template>
                        </template>

                        <!-- カスタムステータス表示 -->
                        <template v-else-if="header.key === 'status'">
                            <template v-if="customStatus">
                                <slot :name="header.key" :item="item"></slot>
                            </template>
                            <template v-else>
                                <span v-if="item.status === 1" class="inline-block w-20 text-center text-green-700 bg-green-100 rounded-lg p-2">実施中</span>
                                <span v-if="item.status === 0" class="inline-block w-20 text-center text-red-700 bg-red-100 rounded-lg p-2">完了</span>
                            </template>
                        </template>
                        <!-- カスタムスロット -->
                        <template v-else-if="$slots[header.key]">
                            <slot :name="header.key" :item="item"></slot>
                        </template>
                        <!-- デフォルト表示 -->
                        <template v-else>
                            <!-- {{ item[header.key] || 'N/A' }} -->
                            {{ getValue(item, header.key) }}
                        </template>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</template>

