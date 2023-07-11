<script setup>
import NavLink from './NavLink.vue';
import { Link } from '@inertiajs/vue3';
import { usePage } from '@inertiajs/vue3';

defineProps({
})

</script>

<template>
    <nav class="navbar navbar-expand-lg">

        <div class="container-fluid">
            <Link class="navbar-brand" href="/">
            <slot></slot>

            </Link>



            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">

                    <NavLink href="/" :active="$page.component == 'Home'">Home</NavLink>

                </ul>

            </div>
            <div>
                <span class="d-flex gap-2" v-if="usePage().props.auth.user">
                    Welcome, {{ usePage().props.auth.user.username }}
                    <h6>
                        <form action="/logout" method="post">
                            <Link href="/logout" method="post" class="badge bg-secondary mt-1" as="span">Logout</Link>
                        </form>


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

<style></style>
