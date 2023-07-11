<script setup>

let props = defineProps({
    colNumber:{
        type:Number,
        default:3
    },
    items:Array
})

let arr = ['a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a'];

let gr = [];

let j = -1;

for (let i = 0; i < arr.length; i++) {
    if (i % props.colNumber == 0) {
        j++;
        gr[j] = [];
    }
    gr[j].push(arr[i]);
}

let header = `<h1>alma</h1>`;

let cell = `    <div class="card">
                    <div class="card-body">
                        <h2>alma</h2>
                    </div>
                </div>`;
</script>

<template>
    <div class="container text-center">

        <div v-for="i in gr" :key="i" class="row my-3">

            <div class="col" v-for="j in i" :key="j" v-html="cell">
            </div>

        </div>

    </div>
</template>
