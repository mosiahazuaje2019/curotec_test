<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";

defineProps({
    confirmsTwoFactorAuthentication: Boolean,
    sessions: Array,
});
</script>

<template>
        <div>

            <div>
                <Button label="Add" @click="addTask()" />
            </div>

                <DataTable
                :value="task"
                dataKey="id"
                tableStyle="min-width: 50rem"
                :paginator="true"
                :rows="5"
                responsiveLayout="scroll">
                <Column header="Name">
                    <template #body="slotProps">
                        <span class="line-through" v-if="slotProps.data.status ==='Inactive'">{{ slotProps.data.name }}</span>
                        <span v-else>{{ slotProps.data.name }}</span>
                    </template>
                </Column>
                <Column header="Status">
                    <template #body="slotProps">
                        <span class="line-through" v-if="slotProps.data.status ==='Inactive'">{{ slotProps.data.status }}</span>
                        <span v-else="slotProps.data.status ==='Active'">{{ slotProps.data.status }}</span>
                    </template>
                </Column>
                <Column
                    bodyStyle="justify-center"
                    header="Acción"
                    headerStyle="width: 14rem; justify-center"
                >
                    <template #body="slotProps">
                        <PrimeButton
                            @click="changeStatus(slotProps.data.id)"
                            icon="pi pi-check"
                            class="mr-2"
                            title="Change Status"
                        />
                    </template>
                </Column>
            </DataTable>
        </div>
        <Dialog modal :header="taskId === null ? 'Create task' : 'Edit task'" :style="{ width: '60vw' }" v-model:visible="display">
            <TaskEdit :taskId="taksId" />
        </Dialog>
</template>

<script>
import axios from "axios";
import TaskEdit from "./TaskEdit.vue";
import Swal from "sweetalert2";

export default {
    name: "Task",
    components() {
        'TaskEdit'
    },
    data() {
        return {
            task:  null,
            taskId: null,
            display:  false
        };
    },
    methods: {
        async getTask() {
            await axios.get(`api/tasks`).then((res) => {
                this.task = res.data;
                console.log(this.task);
            })
        },
        addTask(){
            console.log("Edit")
            this.display = true;
        },
        async changeStatus(taskId){
            let status = null;
            await axios.patch(`/api/changeStatus/${taskId}`,{status: 'Inactive'});
            Swal.fire({
                position: "top-end",
                icon: "success",
                title: "Task completed",
                showConfirmButton: false,
                timer: 1500,
            });
            this.getTask();
        }
    },
    mounted() {
        this.getTask();
        this.emitter.on("task_reload", () => {
            this.getTask();
            this.display = false;

            Swal.fire({
                position: "top-end",
                icon: "success",
                title: "Task added",
                showConfirmButton: false,
                timer: 1500,
            });
        });
    }
};
</script>
<style>

</style>
