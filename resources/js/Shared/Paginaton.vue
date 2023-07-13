<script setup>

import PagLink from './PagLink.vue';

let props = defineProps({
    links: Array
});
</script>

<template>
    <ul class="list-group list-group-horizontal-sm m-3">

        <PagLink :links="props.links"></PagLink>

    </ul>
</template>
