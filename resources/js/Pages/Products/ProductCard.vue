<script setup>
/* import the fontawesome core */
import { library } from '@fortawesome/fontawesome-svg-core'
/* import font awesome icon component */
import { faImage } from '@fortawesome/free-solid-svg-icons'
library.add(faImage);

let props = defineProps({
    imgSrc: {
        type: String,
        default: null
     }
})
</script>

<template>
    <div class="card shadow-sm">
        <div class="card-body">
            <img v-if="props.imgSrc" :src="imgSrc" class="w-25">
            <font-awesome-icon icon="image" class="fa-2xl" v-else />
            <h3>
                <slot name="title"></slot>
            </h3>
            <h5>
                <slot name="price"></slot>
            </h5>
            <div class="d-flex gap-3 justify-content-center">
                <slot name="buttons"></slot>
            </div>
        </div>
</div></template>
