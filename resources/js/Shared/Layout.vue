<script setup>
import Nav from './Nav.vue';
import { Head } from "@inertiajs/vue3";
</script>


<template>
    <Head>
        <title>Shop</title>
        <meta name="description" content="" head-key="description">
    </Head>
    <header>
        <Nav class="p-2 border-bottom shadow-sm">Shop</Nav>
    </header>
    <div class="pt-4 px-5">
        <slot></slot>
    </div>
</template>

