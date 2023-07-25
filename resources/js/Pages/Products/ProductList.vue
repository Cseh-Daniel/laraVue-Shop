<script setup>

import ProductCard from "./ProductCard.vue";
import { ref } from "vue";
import { usePage } from "@inertiajs/vue3";


let auth = ref(usePage().props.auth.user ? true : false);

let props = defineProps({
    items: Array,
})
</script>



<template>
    <div class="container-fluid p-4">

        <div class="row justify-content-center align-items-center gap-2">
            <ProductCard :edit="auth" v-for="i in props.items" :key="i.id" :product="i"></ProductCard>
        </div>

    </div>
</template>
