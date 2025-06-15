<script setup lang="ts">
import AppLayout from '@/layouts/app/AppSidebarLayout.vue';
import type { BreadcrumbItemType } from '@/types';
import { usePage } from '@inertiajs/vue3';
import { onUnmounted, watch } from 'vue';
import Swal from 'sweetalert2';

interface Props {
    breadcrumbs?: BreadcrumbItemType[];
}

withDefaults(defineProps<Props>(), {
    breadcrumbs: () => [],
});


interface flashMessage {
    success?: null;
    error?: null;
}

onUnmounted(() => {
    watch(() => usePage<{ flashMessage: flashMessage }>().props.flashMessage, (flashMessage: flashMessage) => {
        if (flashMessage.success) {
            Swal.fire({
                icon: 'success',
                title: 'Success',
                text: flashMessage.success,
            });
        }
        if (flashMessage.error) {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: flashMessage.error,
            });
        }
    }, { immediate: true });
})
</script>

<template>
    <AppLayout :breadcrumbs="breadcrumbs">
        <slot />
    </AppLayout>
</template>
