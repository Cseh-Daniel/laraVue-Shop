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
               Welcome,Teszt
               <Link href="/logout" method="post" as="link">Logout</Link>
            </div>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
        </div>



    </nav>
</template>

<style></style>
