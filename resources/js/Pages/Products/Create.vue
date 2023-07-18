<script setup>
import { useForm } from '@inertiajs/vue3';

const props = defineProps({
    title: {
        type: String,
        default: "Create new product"
    },
    product: {
        type: Object,
    },
});

let form = useForm({
    name: '',
    file_path: '',
    price: ''
})

if (props.product) {
    form.name = props.product.name;
    form.price = props.product.price;
    form.file_path = props.product.file_path;
}

function submit() {
    if (props.product) {
        form.post("/edit-product/" + props.product.id);
    } else {
        form.post("/new-product");
    }
};

</script>

<template>
    <div class="card mx-auto shadow-sm px-5 py-4">
        <h1>{{ props.title }}</h1>
        <div class="card-body p-4">
            <form @submit.prevent="submit">
                <div class="mb-3">
                    <label for="name" class="form-label">Name:</label>
                    <input v-model="form.name" type="text" name="name" id="name" class="form-control">
                    <div v-show="form.errors.name" class="bg-danger-subtle rounded p-1 w-50 text-center m-2">
                        {{ form.errors.name }}
                    </div>
                </div>

                <div class="mb-3">
                    <label for="price" class="form-label">Price:</label>
                    <input v-model="form.price" type="number" name="price" id="price" class="form-control">
                    <div v-if="form.errors.price" class="bg-danger-subtle rounded p-1 w-50 text-center m-2">
                        {{ form.errors.price }}
                    </div>
                </div>

                <div class="mb-3">
                    <label for="file_path" class="form-label">Product image</label>

                    <input
                    @input="form.file_path = $event.target.files[0]"
                    type="file"
                    name="file_path"
                    id="file_path"
                    class="form-control"
                    >

                    <progress class="w-100" v-if="form.progress" :value="form.progress.percentage" max="100">
                        {{ form.progress.percentage }}%
                    </progress>
                    <div v-if="form.errors.file_path" class="bg-danger-subtle rounded p-1 w-50 text-center m-2">
                        {{ form.errors.file_path }}
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Save</button>
            </form>
        </div>
    </div>
</template>
