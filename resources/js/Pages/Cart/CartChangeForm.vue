<script setup>
import { router, usePage } from '@inertiajs/vue3';

let sessionId = usePage().props.cart.new.id;
let userId = usePage().props.cart.old.id;

function keepCart(keepId) {

    let dropId = userId == keepId ? sessionId : userId;

    router.get('/keepCart', { keepId, dropId });
}

function deleteBoth() {
    router.get('/deleteCart', [sessionId, userId]);
}


</script>


<template>
    <div class="d-flex justify-content-center">

        <div class="text-center border shadow-sm p-5 m-5 rounded-3">
            <h1>Multiple Carts</h1>
            <h5>You put products into the cart while logged out.</h5>
            <h5>Do you want to change your cart?</h5>

            <div class="d-flex justify-content-evenly gap-3 my-4">
                <ul class="list-group">
                    <li class="list-group-item">
                        <strong>Old cart</strong>
                    </li>
                    <li class="list-group-item" v-for="item in usePage().props.cart.old.items">{{ item.qty }}x {{ item.name
                    }}
                        - {{ item.price }}.-</li>


                </ul>
                <ul class="list-group">
                    <li class="list-group-item">
                        <strong>New cart</strong>
                    </li>
                    <li class="list-group-item" v-for="item in usePage().props.cart.new.items">{{ item.qty }}x {{ item.name
                    }}
                        - {{ item.price }}.-</li>

                </ul>
            </div>
            <div class="d-flex justify-content-evenly">
                <button class="btn btn-primary" @click="keepCart(userId)">Keep old</button>
                <button class="btn btn-primary" @click="keepCart(sessionId)">Keep new</button>

                <button class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#deleteBoth">Delete
                    Both</button>

                <div class="modal fade" id="deleteBoth">
                    <div class="modal-dialog">
                        <div class="modal-content p-4">
                            <div class="modal-header">
                                <h2>Delete both carts?</h2>
                            </div>



                            <div class="d-flex gap-3 justify-content-center p-3">
                                <button class="btn btn-secondary" data-bs-toggle="modal"
                                    data-bs-target="#deleteBoth">Cancel</button>

                                <button class="btn btn-danger" @click="deleteBoth()" data-bs-toggle="modal"
                                    data-bs-target="#deleteBoth">Delete Both</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    layout: null
}
</script>
