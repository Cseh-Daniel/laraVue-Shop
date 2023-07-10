<template>
    <Head>
        <title>Alma App</title>
        <meta name="description" content="" head-key="description">
        <!-- ha meta tag-ben akarunk valamit megadni defaultnak
            de felül akarjuk tudni írni ha van saját akkor head-key-t kell hazsnálni
        -->
    </Head>
    <header>
        <Nav class="p-2 border-bottom shadow-sm">Alma</Nav>
    </header>
    <div class="pt-4 px-5 w-75 mx-auto">
        <slot></slot>
    </div>
</template>

<script setup>
import Nav from './Nav.vue';
import { Head } from "@inertiajs/vue3";
</script>
