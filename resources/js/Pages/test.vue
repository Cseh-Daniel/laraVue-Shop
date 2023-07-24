<script setup>
import { usePage } from '@inertiajs/vue3';
</script>

<template>
    <table class="table">
        <tr v-for="i in usePage().props.query">
            <td>{{ i.id }}</td>
            <td>{{ i.name }}</td>
            <td>{{ i.price }}</td>
        </tr>
    </table>
</template>
