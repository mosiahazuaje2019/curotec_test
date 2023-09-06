<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";

defineProps({
    confirmsTwoFactorAuthentication: Boolean,
    sessions: Array,
});
</script>

<template>
        <div>
            <div class="relative mb-4" data-te-input-wrapper-init>
                <label for="name"> Name </label>
                <InputText
                    type="text"
                    v-model="form.name"
                    placeholder="Name"
                    class="w-full rounded"
                />
            </div>
            <div class="relative mb-4" data-te-input-wrapper-init>
                <label for="name"> Status </label>
                <Dropdown
                    :options= "statusDat"
                    v-model="form.status"
                    optionLabel="name"
                    optionValue="id"
                    class="w-full rounded"
                />
            </div>
            <Button icon="pi pi-check" label="Guardar" @click="submit" />
        </div>
</template>

<script>
import axios from "axios";

export default {
    name: "TaskEdit",

    data() {
        return {
            form: {
                name:  null,
                status: null
            },
            statusDat: [
                { id: 'Active', name: 'Active' },
                { id: 'Inactive', name: 'Inactive' },
            ]
        };
    },
    methods: {
        submit(){
            const res = axios.post(`api/tasks`,this.form)
            return this.emitter.emit("task_reload");
        },
        addTask(){
            this.display = true;
        },
        changeStatus(){
            console.log('Something');
        }
    },
    mounted() {
        //this.getTask();
    }
};
</script>
<style>

</style>
