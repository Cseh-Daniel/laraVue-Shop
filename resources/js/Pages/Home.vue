<script setup>
import { ref } from "vue";
import Pagination from '@shared/Paginaton.vue';
import ProductList from './Products/productList.vue';


import { Link, usePage } from '@inertiajs/vue3';
/* import the fontawesome core */
import { library } from '@fortawesome/fontawesome-svg-core'
/* import font awesome icon component */
import { faImage } from '@fortawesome/free-solid-svg-icons'



library.add(faImage);

let auth = ref(usePage().props.auth.user ? true : false);

</script>

<template>
    <h1>Home</h1>

    <ProductList></ProductList>

    <div @logout="auth = false" class="card">
        <div class="card-body">

            <Link v-if="auth" href="/new-product" class="btn btn-outline-primary" as="button">New Product</Link>

            <table class="table w-75 mx-auto text-center align-middle">
                <thead>
                    <tr>
                        <th></th>
                        <th>Name</th>
                        <th>Price</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody v-if="usePage().props.products">
                    <tr v-for="product in usePage().props.products.data" :key="product.id">


                        <td class="w-25">
                            <img class="img-fluid" v-if="product.file_path" :src="product.file_path">
                            <font-awesome-icon icon="image" v-else />
                        </td>

                        <td>{{ product.name }}</td>
                        <td>{{ product.price }}&nbsp;.-</td>
                        <td>
                            <div v-if="auth" class="d-flex gap-3 justify-content-center">
                                <Link :href="'/edit-product/' + product.id" as="button" class="btn btn-outline-warning">Edit
                                </Link>
                                <Link :href="'/delete-product/' + product.id" as="button" class="btn btn-outline-danger"
                                    method="post" preserve-scroll>remove</Link>
                            </div>
                        </td>

                    </tr>
                </tbody>
            </table>

            <div class="d-flex justify-content-center align-items-center">
                <Pagination :links="usePage().props.products.links"></Pagination>
            </div>
        </div>
    </div>
</template>
