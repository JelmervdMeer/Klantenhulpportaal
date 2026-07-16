<template>

<div class="d-flex justify-content-between align-items-center mb-4">

    <div>

        <h1 class="fw-bold mb-1">
            {{ title }}
        </h1>

        <p class="text-muted mb-0">
            {{ subtitle }}
        </p>

    </div>

    <div>

        <slot />

    </div>

</div>

</template>

<script setup lang="ts">

defineProps<{

    title:string

    subtitle:string

}>()

</script>