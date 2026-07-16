<template>
    <span :class="badgeClass">
        <i
            v-if="icon"
            :class="['bi', icon, 'me-1']"
        ></i>

        {{ label }}
    </span>
</template>

<script setup lang="ts">
import { computed } from 'vue'

const props = defineProps({

    type: {
        type: String,
        required: true
    },

    value: {
        type: String,
        required: true
    }

})

const badgeClass = computed(() => {

    const base = 'badge rounded-pill px-3 py-2 fw-semibold'

    switch (props.type) {

        case 'status':

            switch (props.value) {

                case 'Open':
                    return `${base} text-bg-primary`

                case 'In behandeling':
                    return `${base} text-bg-warning`

                case 'Gesloten':
                    return `${base} text-bg-success`

                default:
                    return `${base} text-bg-secondary`
            }

        case 'priority':

            switch (props.value) {

                case 'Hoog':
                    return `${base} text-bg-danger`

                case 'Normaal':
                    return `${base} text-bg-warning`

                case 'Laag':
                    return `${base} text-bg-success`

                default:
                    return `${base} text-bg-secondary`
            }

        case 'role':

            switch (props.value) {

                case 'admin':
                    return `${base} text-bg-danger`

                case 'user':
                    return `${base} text-bg-primary`

                default:
                    return `${base} text-bg-secondary`
            }

        default:

            return `${base} text-bg-secondary`
    }

})

const label = computed(() => {

    if (props.type === 'role') {

        return props.value === 'admin'
            ? 'Administrator'
            : 'Gebruiker'
    }

    return props.value

})

const icon = computed(() => {

    if (props.type === 'status') {

        switch (props.value) {

            case 'Open':
                return 'bi-envelope-open'

            case 'In behandeling':
                return 'bi-hourglass-split'

            case 'Gesloten':
                return 'bi-check-circle'

        }

    }

    if (props.type === 'priority') {

        switch (props.value) {

            case 'Hoog':
                return 'bi-exclamation-triangle'

            case 'Normaal':
                return 'bi-flag'

            case 'Laag':
                return 'bi-check2'

        }

    }

    if (props.type === 'role') {

        return 'bi-person-badge'
    }

    return ''
})
</script>