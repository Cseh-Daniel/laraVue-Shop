<script setup>
import NavLink from './NavLink.vue';
import { usePage, router, Link } from '@inertiajs/vue3';
import { ref } from "vue";

let boolLogout = ref(false);


function logoutProcess() {
    boolLogout.value=true;
    router.post("/logout");
}

</script>

<template>
    <nav class="navbar navbar-expand-lg">

        <div class="container-fluid">
            <a class="navbar-brand" href="/">
                <slot></slot>
            </a>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <NavLink href="/" :active="$page.component == 'Home'">Home</NavLink>
                </ul>
            </div>

            <div>
                <span class="d-flex gap-2" v-if="usePage().props.auth.user">
                    Welcome, {{ usePage().props.auth.user.username }}
                    <h6>
                        <Button class="badge bg-secondary mt-1" :disabled="boolLogout" @click="logoutProcess">Logout</Button>
                    </h6>
                </span>
                <span class="d-flex gap-2" v-else>
                    <Link href="/login" as="button" class="btn btn-primary">Login</Link>
                    <Link href="/register" as="button" class="btn btn-secondary">Register</Link>
                </span>
            </div>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
        </div>
    </nav>
</template>

