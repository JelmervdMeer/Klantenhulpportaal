<template>

    <BaseCard>

        <!-- Ticket header -->

        <div class="d-flex justify-content-between align-items-start mb-3">

            <div>

                <h5 class="fw-bold mb-1">

                    #{{ ticket.id }}
                    {{ ticket.title }}

                </h5>

            </div>

            <!-- Prioriteit indicator -->

            <span
                class="priority-dot"
                :class="priorityDotClass(ticket.priority)"
                :title="ticket.priority"
            ></span>

        </div>

        <!-- Status en prioriteit -->

        <div class="d-flex gap-2 mb-4 flex-wrap">

            <BadgeStatus
                type="status"
                :value="ticket.status"
            />

            <BadgeStatus
                type="priority"
                :value="ticket.priority"
            />

        </div>

        <!-- Ticket informatie -->

        <div class="text-muted">

            <p class="mb-2">

                <i class="bi bi-tag me-2"></i>

                {{ ticket.category?.name ?? 'Geen categorie' }}

            </p>

            <p class="mb-0">

                <i class="bi bi-person me-2"></i>

                {{ ticket.user?.name ?? 'Onbekend' }}

            </p>

        </div>

        <!-- Acties -->

        <template #actions>

            <button
                class="btn btn-primary w-100"
                @click="$emit('open', ticket.id)"
            >

                <i class="bi bi-eye me-2"></i>

                Ticket bekijken

            </button>

        </template>

    </BaseCard>

</template>

<script setup lang="ts">

import BaseCard from './BaseCard.vue'
import BadgeStatus from './BadgeStatus.vue'

interface Ticket {

    id: number
    title: string
    status: string
    priority: string

    category?: {
        name: string
    }

    user?: {
        name: string
    }

}

defineProps<{

    ticket: Ticket

}>()

defineEmits<{

    open: [id: number]

}>()

function priorityDotClass(priority: string) {

    switch (priority) {

        case 'Hoog':
            return 'dot-high'

        case 'Normaal':
            return 'dot-normal'

        case 'Laag':
            return 'dot-low'

        default:
            return ''

    }

}

</script>

<style scoped>

.priority-dot {

    width: 14px;
    height: 14px;

    border-radius: 50%;

    border: 2px solid white;

    flex-shrink: 0;

}

.dot-high {

    background: #dc3545;

}

.dot-normal {

    background: #ffc107;

}

.dot-low {

    background: #198754;

}

</style>