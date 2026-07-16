<template>

    <BaseCard>

        <div class="category-icon mb-3">

            <i class="bi bi-tag-fill"></i>

        </div>

        <h4 class="fw-bold mb-2">

            {{ category.name }}

        </h4>

        <p class="text-muted mb-0">

            {{ category.description }}

        </p>

        <template #actions>

            <div class="d-flex gap-2">

                <button
                    class="btn btn-primary flex-fill"
                    @click="emit('edit', category)"
                >

                    <i class="bi bi-pencil me-2"></i>

                    Bewerken

                </button>

                <button
                    class="btn btn-danger flex-fill"
                    @click="emit('delete', category.id)"
                >

                    <i class="bi bi-trash me-2"></i>

                    Verwijderen

                </button>

            </div>

        </template>

    </BaseCard>

</template>

<script setup lang="ts">

import BaseCard from './BaseCard.vue'

interface Category {

    id: number

    name: string

    description: string

}

defineProps<{

    category: Category

}>()

const emit = defineEmits<{

    (e: 'edit', category: Category): void

    (e: 'delete', id: number): void

}>()

</script>

<style scoped>

.category-icon {

    width: 60px;

    height: 60px;

    border-radius: 12px;

    display: flex;

    align-items: center;

    justify-content: center;

    background: #e7f1ff;

    color: #0d6efd;

    font-size: 28px;

}

</style>