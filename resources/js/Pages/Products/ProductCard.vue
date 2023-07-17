<script setup>
/* import the fontawesome core */
import { library } from '@fortawesome/fontawesome-svg-core'
/* import font awesome icon component */
import { faImage, faCartPlus } from '@fortawesome/free-solid-svg-icons'
import { router } from '@inertiajs/vue3';
import { reactive } from 'vue';

library.add(faImage, faCartPlus);

let props = defineProps({
    imgSrc: {
        type: String,
        default: null
    },
    edit: Boolean,
    product: Object
})


let product=reactive(props.product)

function addToCart(prodId) {

    let qty = document.getElementById(prodId + '-qty');
    console.log(prodId, qty.value);
    // :href="'/add-to-cart/'
    router.get("/add-to-cart",{id:prodId,qty:qty.value},{preserveScroll:true});
}

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

            <div class="input-group w-30">
                <input class="form-control" type="number" :name="product.id + '-qty'" :id="product.id + '-qty'"
                    placeholder="Quantity" min="1" value="1">

                <button class="btn btn-outline-primary" @click="addToCart(product.id)">
                    <font-awesome-icon icon="cart-plus" size="xl" />
                </button>

                <!-- <Link as="button" :href="'/add-to-cart/' + product.id" class="btn btn-outline-primary" preserve-scroll>
                <font-awesome-icon icon="cart-plus" size="xl" />
                </Link> -->

            </div>

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

.w-30 {

    max-width: 30%;
}
</style>
