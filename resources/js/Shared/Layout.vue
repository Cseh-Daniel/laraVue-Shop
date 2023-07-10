<template>
    <Head>
        <title>Shop</title>
        <meta name="description" content="" head-key="description">
        <!-- ha meta tag-ben akarunk valamit megadni defaultnak
            de felül akarjuk tudni írni ha van saját akkor head-key-t kell hazsnálni
        -->
    </Head>
    <header>
        <Nav class="p-2 border-bottom shadow-sm">Shop</Nav>
    </header>
    <div class="pt-4 px-5">
        <slot></slot>
    </div>
</template>

<script setup>
import Nav from './Nav.vue';
import { Head } from "@inertiajs/vue3";
</script>
