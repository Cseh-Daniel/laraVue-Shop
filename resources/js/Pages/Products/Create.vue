<script setup>
import { useForm, usePage } from '@inertiajs/vue3';
import { ref } from 'vue';
defineProps({
    product: {
        type: Object
    }
})

let title = '';

if (product) {
    title = ref("Edit product");
} else {
    title = ref("Create new product");
}

let form = useForm({
    name: '',
    picPath: '',
    price: ''
})


function submit() {
    //console.log(errors.name)
    if (product) {
        form.post("/edit-product/" + id);
    } else {
        form.post("/new-product");
    }
};

function onFileChange(e) {
    var files = e.target.files || e.dataTransfer.files;
    if (!files.length)
        return;
    createImage(files[0]);
}

function createImage(file) {

    //var image = new Image();
    form.picPath = new Image();
    var reader = new FileReader();
    var vm = this;

    reader.onload = (e) => {
        // vm.image = e.target.result;
        vm.picPath = e.target.result;

    };
    reader.readAsDataURL(file);
}

</script>

<template>
    <div class="card mx-auto shadow-sm px-5 py-4">
        <h1>Create new product</h1>
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
                    <label for="picPath" class="form-label">Product image</label>
                    <input @change="onFileChange" type="file" name="picPath" id="picPath" class="form-control">
                    <div v-if="form.errors.picPath" class="bg-danger-subtle rounded p-1 w-50 text-center m-2">
                        {{ form.errors.picPath }}
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Create</button>
            </form>
        </div>
    </div>
</template>
