<script setup>
import { ref, reactive, watch } from "vue";
import { Link, usePage, router } from '@inertiajs/vue3';
import debounce from "lodash/debounce";

import { library } from '@fortawesome/fontawesome-svg-core';
import { faCartShopping } from '@fortawesome/free-solid-svg-icons';
library.add(faCartShopping);

import Pagination from '@shared/Paginaton.vue';
import ProductList from './Products/ProductList.vue';
import CartItems from './Cart/CartItems.vue';

let props = defineProps({
    filters: {
        type: Object,
        default: {
            name: '',
            price: {
                min: '',
                max: ''
            }
        }
    },
    products: Object,
    sort: String
})

let auth = ref(usePage().props.auth.user ? true : false);
let search = reactive(props.filters);
let sort = ref(props.sort);

/**
 * filtering product list by name
 */
watch(() => search.name,
    debounce(
        (value) => {
            let data = getQueryData();
            data.name = value;
            router.get('/home', data, { replace: true, preserveState: true });

        }, 500));

/**
 * filter product list by price range
 */
watch(() => search.price,
    debounce(
        (value) => {
            let data = getQueryData();
            data.priceMin = value['min'];
            data.priceMax = value['max'];

            router.get('/home', data, { replace: true, preserveState: true });
            // router.get('/home', { price: value }, { replace: true, preserveState: true });

        }, 500), { deep: true });


/**
 * Check QueryString for existing parameters
 */
function getQueryData() {

    let data = {
        sort: null,
        priceMin: null,
        priceMax: null,
        name: null
    };

    data.name = new URL(location.href).searchParams.has('name') ? new URL(location.href).searchParams.get('name') : null;
    data.priceMin = new URL(location.href).searchParams.has('priceMin') ? new URL(location.href).searchParams.get('priceMin') : null;
    data.priceMax = new URL(location.href).searchParams.has('priceMax') ? new URL(location.href).searchParams.get('priceMax') : null;
    data.sort = new URL(location.href).searchParams.has('sort') ? sort.value.value : null;

    return data;

}

/**
 * Sorting the product list
 */
function sorter() {

    let data = getQueryData();
    data.sort = sort.value.value;

    router.get('/home', data, { replace: true, preserveState: true });
}

</script>

<template>
    <h1>Home</h1>

    <div class="container-fluid mb-4 justify-content-center">
        <div class="row justify-content-center">

            <div class="col-3">

                <input type="text" class="form-control" v-model="search.name" id="nameSearch" placeholder="search for Name">

            </div>

            <div class="d-flex col-3 gap-md-3 gap-1">
                <input type="number" class="form-control" v-model="search.price.min" placeholder="Price min">
                <input type="number" class="form-control" v-model="search.price.max" placeholder="Price max">
            </div>

            <div class="col-3">
                <select ref="sort" @change="sorter" name="sort" id="sort" class="form-select">
                    <option value="" disabled selected>Sort Products</option>

                    <option value="priceDesc">Price: High -> Low</option>
                    <option value="priceAsc">Price: Low -> High</option>

                    <option value="nameAsc">Name: A -> Z</option>
                    <option value="nameDesc">Name: Z -> A</option>
                </select>
            </div>

        </div>

        <div class="row mt-2">

            <div class="col">
                <Link v-if="auth" href="/new-product" class="btn btn-outline-primary" as="button">New Product</Link>
            </div>

            <div class="col">

                <div class="dropdown d-flex justify-content-end">
                    <Button class="btn btn-outline-primary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                        <font-awesome-icon icon="cart-shopping" />
                    </Button>
                    <div class="dropdown-menu container shadow">

                        <CartItems v-for="cartProd in usePage().props.cart.items" :items="cartProd" />
                        <div class="d-flex justify-content-center">
                            <div class="w-75">
                                <hr>
                                <h3 class="text-center">Total: {{ usePage().props.cart.total }}</h3>
                            </div>

                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>


    <ProductList :items="usePage().props.products.data" :col-number=2 :key="search" />

    <div class="d-flex justify-content-center align-items-center">
        <Pagination :links="usePage().props.products.links"></Pagination>
    </div>
</template>
