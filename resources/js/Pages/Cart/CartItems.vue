<script setup>
import { reactive, watch } from "vue";
import debounce from 'lodash/debounce';
import { router } from "@inertiajs/vue3";

let props = defineProps({
    items: Object
})

let items = reactive(props.items);

watch(() => items, debounce(
    (value) => {
        value.quantity>0 ? router.post('/cart-update',{id:value.id,qty:value.quantity},{preserveScroll:true}):'';
    }
    , 500),{deep:true});

</script>

<template>
    <div class="row ps-3 py-2 align-items-center gap-2">
        <div class="col-3">{{ items.name }}</div>
        <div class="col-1 pe-5">{{ items.price }}.-</div>
        <div class="col-4 d-flex gap-1 align-items-center">Quantity:<input type="number" :min="1" v-model="items.quantity"
                class="form-control"></div>
        <div class="col-1">
            <Link :href="'/remove-from-cart/' + items.id" as="button" class="btn btn-danger" preserve-scroll>Remove</Link>
        </div>
    </div>
</template>
