<script setup>
/* import the fontawesome core */
import { library } from '@fortawesome/fontawesome-svg-core'
/* import font awesome icon component */
import { faImage,faCartPlus } from '@fortawesome/free-solid-svg-icons'
library.add(faImage,faCartPlus);

let props = defineProps({
    imgSrc: {
        type: String,
        default: null
    },
    edit: Boolean,
    product: Object
})
</script>

<template>
    <div class="col-md-4 col-12 border text-center shadow rounded-4 mb-3 p-4">

        <div class="row justify-content-center w-img mx-auto">
            <img class="w-img" v-if="product.file_path" :src="product.file_path">
            <font-awesome-icon icon="image" class="fa w-img" v-else />
        </div>

        <div class="row justify-content-center">
            <h3>
                {{ product.name }}
            </h3>
        </div>

        <div class="row justify-content-center">
            <h5>
                {{ product.price }}.-
            </h5>

        </div>

        <div class="d-flex gap-2 gap-md-3 justify-content-center">
            <Link as="button" href="#" class="btn btn-outline-primary">
                <font-awesome-icon icon="cart-plus" size="xl" />
            </Link>
            <Link v-if="props.edit" :href="'/edit-product/' + product.id" as="button" class="btn btn-outline-warning">
            Edit
            </Link>
            <Link v-if="props.edit" :href="'/delete-product/' + product.id" as="button" class="btn btn-outline-danger"
                method="post" preserve-scroll>remove</Link>
        </div>

    </div>
</template>

<style>
.w-img {

    max-width: 15rem;
    max-height: 10rem;

    width: auto;
    height: auto;

}
</style>
