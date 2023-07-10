<script setup>
import { useForm,Link } from '@inertiajs/vue3';


let form = useForm({
    email: '',
    password: ''
})

function submit(){
    form.post("/login");
}


</script>

<script>
export default {
    layout: null
}
</script>

<template>

        <Head title="Login Page"></Head>

        <div class="border w-75 mx-auto p-5 mt-5 shadow rounded-4">
            <h1>Login</h1>
            <form @submit.prevent="submit" class="w-75 mx-auto mt-4">

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

                <div class="d-flex gap-3 align-items-center">
                    <button class="btn btn-primary" type="submit">Login</button>
                    <Link href="/register" as="a">Don't have an account?</Link>
                </div>
            </form>

        </div>

</template>
