
<script setup>
import { useForm } from '@inertiajs/vue3';

let form = useForm({
    name: '',
    email: '',
    password: '',
    password_confirmation:''
});


function submit() {
    form.post('/register');
}

</script>

<script>
export default {
    layout: null
}
</script>

<template>
    <Head title="Create User"></Head>

    <div class="card w-75 m-5 p-5 mx-auto shadow">
        <h1>Create New User</h1>

        <div class="card-body">
            <form @submit.prevent="submit" class="w-75 mx-auto mt-4">

                <div class="mb-3">
                    <label for="name" class="form-label rounded">Name:</label>
                    <input v-model="form.name" type="text" class="form-control" name="name" id="name" required>

                    <div v-if="form.errors.name" class="w-auto m-2">
                        <div class="p-2 badge bg-danger-subtle text-danger-emphasis" v-text="form.errors.name"></div>
                    </div>

                </div>


                <div class="mb-3">
                    <label for="email" class="form-label">E-mail:</label>
                    <input v-model="form.email" type="text" class="form-control" name="email" id="email" required>
                    <div v-if="form.errors.email" class="w-auto m-2">
                        <div class="p-2 badge bg-danger-subtle text-danger-emphasis" v-text="form.errors.email"></div>
                    </div>
                </div>


                <div class="mb-3">
                    <label for="password" class="form-label">Password:</label>
                    <input v-model="form.password" type="password" class="form-control" name="password" id="password">
                    <div v-if="form.errors.password" class="w-auto m-2">
                        <div class="p-2 badge bg-danger-subtle text-danger-emphasis" v-text="form.errors.password"></div>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="password_confirmation" class="form-label">Confirm Password:</label>
                    <input v-model="form.password_confirmation" type="password" class="form-control"
                        name="password_confirmation" id="password_confirmation">
                </div>

                <div class="d-flex gap-3 align-items-center">
                    <button class="btn btn-primary" type="submit" :disabled="form.processing">Register</button>
                    Already have an account?
                    <Link href="/login" as="a">Login</Link>
                </div>

            </form>
        </div>
    </div>
</template>

