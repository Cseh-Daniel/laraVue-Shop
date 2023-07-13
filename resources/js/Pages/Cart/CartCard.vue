<script setup>
/* import the fontawesome core */
import { library } from '@fortawesome/fontawesome-svg-core'
/* import font awesome icon component */
import { faImage } from '@fortawesome/free-solid-svg-icons'
library.add(faImage);

defineProps({

    product: Object

})

</script>

<template>
    <div class="row my-2 rounded-4 shadow-sm border">
        <div class="d-flex justify-content-around align-items-center p-2 gap-3">

            <!-- <img class="w-img" v-if="product.file_path" :src="product.file_path"> -->
            <img class="w-img" v-if="false">
            <font-awesome-icon icon="image" size="xl" v-else />


            <h3>{{ product.name }}</h3>

            <h3>{{ product.price }}.-</h3>


            <div class="d-flex gap-md-3 gap-2">
                <h3>Qty:</h3>
                <input :ref="product.qty" class="form-control" type="number" name="qty" id="qty">
                <Link as="button" href="#" class="btn btn-danger">Remove</Link>
            </div>



        </div>
    </div>
</template>
