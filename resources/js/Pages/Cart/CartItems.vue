<script setup>
defineProps({
 items:Object
})

</script>

<template>
    <div class="row py-2 align-items-center justify-content-center gap-2">
        <div class="col-2">{{ items.name }}</div>
        <div class="col-1 pe-5">{{ items.price }}.-</div>
        <div class="col-4 d-flex gap-1 align-items-center">Quantity:<input type="number" class="form-control"></div>
        <div class="col-1"><button class="btn btn-danger">Remove</button></div>
    </div>

</template>
