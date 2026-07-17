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


interface Props {

    type: 'status' | 'priority' | 'role'

    value: string

}


const props = defineProps<Props>()





const baseClass =
    'badge rounded-pill px-3 py-2 fw-semibold'






const badgeClass = computed(() => {


    switch (props.type) {



        case 'status':

            switch (props.value) {


                case 'Open':

                    return `${baseClass} text-bg-primary`



                case 'In behandeling':

                    return `${baseClass} text-bg-warning`



                case 'Gesloten':

                    return `${baseClass} text-bg-success`



                default:

                    return `${baseClass} text-bg-secondary`

            }






        case 'priority':

            switch (props.value) {



                case 'Hoog':

                    return `${baseClass} text-bg-danger`



                case 'Normaal':

                    return `${baseClass} text-bg-warning`



                case 'Laag':

                    return `${baseClass} text-bg-success`



                default:

                    return `${baseClass} text-bg-secondary`

            }







        case 'role':

            switch (props.value) {



                case 'admin':

                    return `${baseClass} text-bg-danger`



                case 'user':

                    return `${baseClass} text-bg-primary`



                default:

                    return `${baseClass} text-bg-secondary`

            }




        default:

            return `${baseClass} text-bg-secondary`

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



    switch (props.type) {



        case 'status':

            switch (props.value) {


                case 'Open':

                    return 'bi-envelope-open'


                case 'In behandeling':

                    return 'bi-hourglass-split'


                case 'Gesloten':

                    return 'bi-check-circle'


                default:

                    return ''

            }







        case 'priority':

            switch (props.value) {


                case 'Hoog':

                    return 'bi-exclamation-triangle'


                case 'Normaal':

                    return 'bi-flag'


                case 'Laag':

                    return 'bi-check2'


                default:

                    return ''

            }







        case 'role':

            return 'bi-person-badge'



        default:

            return ''

    }


})


</script>