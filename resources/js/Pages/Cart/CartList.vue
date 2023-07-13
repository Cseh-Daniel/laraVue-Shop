<script setup>
import CartCard from "./CartCard.vue";

let product={
name:'-Name-',
file_path:'',
price:123,
qty:213
}

</script>

<template>
    <div class="container-fluid">
        <div class="row">
            <div class="col-7">
                Termékek
                <CartCard :product="product"></CartCard>
                <CartCard :product="product"></CartCard>
            </div>
            <div class="col-4">
                Controls:

                sum oƒ price

                ?address?

                checkout btn

            </div>
        </div>
    </div>
</template>
