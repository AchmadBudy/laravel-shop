<template>
    <div class="min-h-screen flex flex-col bg-gray-50">
        <Navbar />
        <main class="flex-1">
            <slot />
        </main>
        <Footer />
    </div>
</template>

<script setup lang="ts">
import Footer from './AppFrontFooter.vue';
import Navbar from './AppFrontNavbar.vue';

</script>
