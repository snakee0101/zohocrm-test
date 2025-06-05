<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/vue3';
import GetToken from '../components/GetToken.vue';
import DealAccountForm from '@/components/DealAccountForm.vue';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: '/dashboard',
    },
];

interface Props {
    user: object;
}

const props = withDefaults(defineProps<Props>(), {
    user: {},
});

</script>

<template>
    <Head title="Dashboard" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
            <GetToken :user={user} />
        </div>
        <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
            <DealAccountForm :user={user} />
        </div>
    </AppLayout>
</template>
