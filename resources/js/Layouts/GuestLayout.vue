<script setup>
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import { Link } from '@inertiajs/vue3';
</script>

<template>
    <div class="min-h-screen sm:pt-0 bg-white dark:bg-gray-900">
        <!-- <div>
            <Link href="/">
                <ApplicationLogo class="w-20 h-20 fill-current text-gray-500" />
            </Link>
        </div> -->

        <div
            class="w-full dark:bg-gray-800 overflow-hidden"
        >
            <slot />
        </div>
    </div>
</template>
