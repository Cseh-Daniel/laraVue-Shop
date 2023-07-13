<script setup>
import { ref, reactive, watch, onMounted } from "vue";
import Pagination from '@shared/Paginaton.vue';
import ProductList from './Products/productList.vue';
import { Link, usePage, router } from '@inertiajs/vue3';
import debounce from "lodash/debounce";

import { library } from '@fortawesome/fontawesome-svg-core'
import { faCartShopping } from '@fortawesome/free-solid-svg-icons'

library.add(faCartShopping);

let props = defineProps({
    filters: {
        type: Object,
        default: {
            name: '',
            price: ''
        }
    },
    products: Object,
    sort: String
})

let auth = ref(usePage().props.auth.user ? true : false);
let search = reactive(props.filters);
let sort = ref(props.sort);

watch(() => search.name,
    debounce(
        (value) => {
            router.get('/home', { name: value }, { replace: true, preserveState: true });
        }, 500));

watch(() => search.price,
    debounce(
        (value) => {
            router.get('/home', { price: value }, { replace: true, preserveState: true });
        }, 500));


function sorter(e) {

    // let value = e.target.options[e.target.options.selectedIndex].value;
    let value = sort.value.value;
    console.log(value);
    router.get('/home', { sort: value }, { replace: true, preserveState: true });

}

</script>

<template>
    <h1>Home</h1>




    <div class="container-fluid mb-4 justify-content-center">
        <div class="row justify-content-center">
            <div class="col-3">
                <input type="text" class="form-control" v-model="search.name" placeholder="search for Name">

            </div>

            <div class="col-3">
                <input type="number" class="form-control" v-model="search.price" placeholder="search for Price">
            </div>

            <div class="col-3">
                <select ref="sort" @change="sorter" name="sort" id="sort" class="form-select">
                    <option value="" disabled selected>Sort Products</option>
                    <option value="priceDesc">Price: High -> Low</option>
                    <option value="priceAsc">Price: Low -> High</option>
                </select>
            </div>

        </div>

        <div class="row justify-content-between mt-2">
            <div class="col-2">
                <Link v-if="auth" href="/new-product" class="btn btn-outline-primary" as="button">New Product</Link>
            </div>

            <div class="col-1 d-flex justify-content-end">
                <Link v-if="auth" href="/cart" class="btn btn-outline-primary" as="button">
                <font-awesome-icon icon="cart-shopping" />
                </Link>
            </div>

        </div>
    </div>


    <ProductList @nameSearch="console.log('keresés')" :items="usePage().props.products.data" :col-number=2 :key="search">
    </ProductList>

    <div class="d-flex justify-content-center align-items-center">
        <Pagination :links="usePage().props.products.links"></Pagination>
    </div>
</template>
