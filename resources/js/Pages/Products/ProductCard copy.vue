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
    },
    edit:Boolean,
    product:Object
})
</script>

<template>
    <div class="container text-center shadow border rounded-4 p-4 mb-3">

        <div class="row justify-content-center w-auto">
            <img v-if="props.imgSrc" :src="imgSrc" class=" w-img">
            <font-awesome-icon icon="image" class="fa-2xl w-img  w-75" v-else />
        </div>


        <div class="row justify-content-center w-auto">
            <h3>
                <slot name="title"></slot>
            </h3>
        </div>

        <div class="row justify-content-center w-auto">
            <h5>
                <slot name="price"></slot>
            </h5>

        </div>
        <div v-if="props.edit" class="row justify-content-center w-auto">
            <slot name="body"></slot>
        </div>

    </div>
</template>

<style>
.w-card {
    width: 20rem;
    height: 15rem;
}

.w-img {
    width: 16rem;
    height: 9rem;
}
</style>
