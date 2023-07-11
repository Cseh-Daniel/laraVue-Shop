<script setup>

import ProductCard from "./ProductCard.vue"

let props = defineProps({
    colNumber:{
        type:Number,
        default:2
    },
    items:Array
})

let arr = ['a','a','a','a','a','a','a','a','a','a','a','a','a','a','a','a','a','a'];

let grid = [];

let j = -1;

for (let i = 0; i < props.items.length; i++) {
    if (i % props.colNumber == 0) {
        j++;
        grid[j] = [];
    }
    grid[j].push(arr[i]);
}

</script>

<template>
    <div class="container text-center">

        <div v-for="(i,index) in grid" :key="i" class="row my-3">

            <div class="col" v-for="(j,jndex) in i" :key="j">

                <ProductCard img-src="uploads/prod/Teszt_Termék2.jpg">
                    <template #title>{{ j }}</template>
                    <template #price>{{ index+""+jndex }}.-</template>
                    <template #buttons>
                        <button class="btn btn-primary"> btn A</button>
                        <button class="btn btn-primary"> btn B</button>
                    </template>

                </ProductCard>

            </div>

        </div>

    </div>
</template>
