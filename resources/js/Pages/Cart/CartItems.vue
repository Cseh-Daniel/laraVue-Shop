<script setup>
defineProps({
 items:Object
})

</script>

<template>
    <div class="row ps-3 py-2 align-items-center gap-2">
        <div class="col-3">{{ items.name }}</div>
        <div class="col-1 pe-5">{{ items.price }}.-</div>
        <div class="col-4 d-flex gap-1 align-items-center">Quantity:<input type="number" v-model="items.quantity" class="form-control"></div>
        <div class="col-1"><Link as="button" class="btn btn-danger">Remove</Link></div>
    </div>

</template>
