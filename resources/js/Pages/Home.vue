<script setup>
import { usePage } from '@inertiajs/vue3';
/* import the fontawesome core */
import { library } from '@fortawesome/fontawesome-svg-core'
/* import font awesome icon component */
import { faImage } from '@fortawesome/free-solid-svg-icons'

library.add(faImage);

defineProps({

    'products': Object,

})
</script>

<template>
    <h1>Home</h1>
    <div class="card">
        <div class="card-body">

            <Link href="/new-product" class="btn btn-outline-primary" as="button">New Product</Link>

            <table class="table w-75 mx-auto text-center align-middle">
                <thead>
                    <tr>
                        <th></th>
                        <th>Name</th>
                        <th>Price</th>
                        <th colspan="2" ></th>
                    </tr>
                </thead>
                <tbody v-if="usePage().props.products">
                    <tr v-for="product in usePage().props.products" :key="product.id">
                        <td>
                            <font-awesome-icon icon="image" />
                        </td>
                        <td>{{ product.name }}</td>
                        <td>{{ product.price }} .-</td>
                        <td>
                            <div class="d-flex gap-3">
                                <Link :href="'/edit-product/'+product.id" as="button" class="btn btn-outline-warning">Edit</Link>
                                <Link :href="'/delete-product/'+product.id" as="button" class="btn btn-outline-danger">remove</Link>
                            </div>
                        </td>

                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>
