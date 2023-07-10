<template>
    <ul class="list-group list-group-horizontal-sm">

        <Link class="text-decoration-none" v-for="link in links" :href="link.url">
        <li class="list-group-item" v-html="link.label" :class="{'fw-bold text-decoration-underline':link.active}"/>
        </Link>

    </ul>
</template>

<script setup>

let props=defineProps({

    links:Array


})

// console.log(props.links)
</script>
