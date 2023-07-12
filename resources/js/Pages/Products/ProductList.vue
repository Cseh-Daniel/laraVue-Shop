<script setup>

import ProductCard from "./ProductCard.vue";
import { ref, reactive, watch } from "vue";
import { usePage, router } from "@inertiajs/vue3";
import debounce from "lodash/debounce";


let auth = ref(usePage().props.auth.user ? true : false);

const emit=defineEmits(['nameSearch','update:modelValue']);

let props = defineProps({
    colNumber: {
        type: Number,
        default: 2
    },

    items: Array,

    modelValue: Array,

    filters: {
        type: Object,
        default: {
            name: '',
            price: ''
        }
    }

})

// let search = reactive(props.filters);

// watch(() => search.name,
//     debounce(
//         (value) => {
//             //emit('nameSearch');
//             emit('update:modelValue');
//             router.get('/home', { name: value }, { replace: true, preserveState: true });

//         }, 500));

// watch(() => search.price,
//     debounce(
//         (value) => {

//             router.get('/home', { price: value }, { replace: true, preserveState: true });

//         }, 500));



let grid = [];
let j = -1;

for (let i = 0; i < props.modelValue.length; i++) {
    if (i % props.colNumber == 0) {
        j++;
        grid[j] = [];
    }
    grid[j].push(props.modelValue[i]);
}
let page = new URL(location.href).searchParams.get('page');

if (!grid.length && page > 0) {
    router.get("/home", { page: page - 1 }, { replace: true })
}

</script>



<template>
    <!-- <div class="d-flex gap-3 mb-4 justify-content-center">
        <input type="text" class="form-control w-25" v-model="search.name" placeholder="search for Name">
        <input type="number" class="form-control w-25" v-model="search.price" placeholder="search for Price">
    </div> -->

    <div class="d-flex gap-3 justify-content-center" v-for="(i, index) in grid" :key="i">
        <span v-for="(j, jndex) in i" :key="j.id">

            <ProductCard :product="j" :edit="auth"></ProductCard>

        </span>

    </div>
</template>
