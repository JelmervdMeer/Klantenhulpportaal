<template>

    <BaseCard>


        <!-- Gebruiker informatie -->


        <div class="d-flex align-items-center gap-3">


            <!-- Avatar -->


            <div class="user-avatar">


                <i class="bi bi-person-fill"></i>


            </div>





            <!-- Gegevens -->


            <div class="flex-grow-1">


                <h4 class="fw-bold mb-1">

                    {{ user.name }}

                </h4>




                <p class="text-muted mb-2">


                    <i class="bi bi-envelope me-2"></i>


                    {{ user.email }}


                </p>




                <BadgeStatus

                    type="role"

                    :value="user.role"

                />



            </div>



        </div>







        <!-- Rol wijzigen -->


        <select

            v-model="user.role"

            class="form-select mt-4"

            @change="changeRole"

        >


            <option value="user">

                Gebruiker

            </option>



            <option value="admin">

                Administrator

            </option>



        </select>







        <!-- Acties -->


        <template #actions>


            <div class="d-flex gap-2">


                <button

                    class="btn btn-primary flex-fill"

                    @click="$emit('edit', user)"

                >


                    <i class="bi bi-pencil me-2"></i>


                    Bewerken


                </button>







                <button

                    class="btn btn-danger flex-fill"

                    @click="$emit('delete', user.id)"

                >


                    <i class="bi bi-trash me-2"></i>


                    Verwijderen


                </button>



            </div>



        </template>



    </BaseCard>



</template>







<script setup lang="ts">


interface User {


    id:number

    name:string

    email:string

    role:string


}




const props = defineProps<{

    user:User


}>()





const emit = defineEmits<{


    edit:[user:User]


    delete:[id:number]


    roleChange:[user:User]


}>()





function changeRole(){


    emit(

        'roleChange',

        props.user

    )


}



</script>







<style scoped>


.user-avatar {


    width:60px;


    height:60px;


    border-radius:50%;


    display:flex;


    align-items:center;


    justify-content:center;


    background:#e7f1ff;


    color:#0d6efd;


    font-size:28px;


    transition:.25s ease;


}





:deep(.base-card:hover) .user-avatar {


    transform:scale(1.08);


}



</style>