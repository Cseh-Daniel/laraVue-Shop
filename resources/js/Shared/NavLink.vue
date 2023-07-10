<template>
    <Link :href="href" class="nav-link active" aria-current="page">
    <li class="nav-item active" :class="{
    'fw-bold border-bottom border-dark':active
    }
    ">
        <slot></slot>
    </li>
    </Link>
</template>

<script setup>

import { Link } from "@inertiajs/vue3";

defineProps({
    active: Boolean,
    href: String
})

</script>
