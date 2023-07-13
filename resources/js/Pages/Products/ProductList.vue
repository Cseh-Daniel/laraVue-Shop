<script setup>

import ProductCard from "./ProductCard.vue";
import { ref } from "vue";
import { usePage, router } from "@inertiajs/vue3";


let auth = ref(usePage().props.auth.user ? true : false);

const emit = defineEmits(['nameSearch', 'update:modelValue']);

let props = defineProps({
    colNumber: {
        type: Number,
        default: 2
    },
    items: Array,
})


let page = new URL(location.href).searchParams.get('page');

console.log('termékek:'+usePage().props.products.data.length);

if (!usePage().props.products.data.length && page > 1) {
    router.get("/home", { page: 1 }, { replace: true })
}


</script>



<template>

    <div class="container-fluid p-4">

            <div class="row justify-content-center align-items-center gap-5">
                <ProductCard :product="i" :edit="auth" v-for="(i, index) in props.items" :key="i.id"></ProductCard>
            </div>

    </div>

</template>
