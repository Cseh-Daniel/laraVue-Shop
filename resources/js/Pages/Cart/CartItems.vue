<script setup>
import {reactive, watch } from "vue";

let props=defineProps({
 items:Object
})
//reactive-> props.items.quantity -> watch -> update server-side


</script>

<template>
    <div class="row ps-3 py-2 align-items-center gap-2">
        <div class="col-3">{{ items.name }}</div>
        <div class="col-1 pe-5">{{ items.price }}.-</div>
        <div class="col-4 d-flex gap-1 align-items-center">Quantity:<input type="number" v-model="items.quantity" class="form-control"></div>
        <div class="col-1"><Link :href="'/remove-from-cart/'+items.id" as="button" class="btn btn-danger">Remove</Link></div>
    </div>

</template>
