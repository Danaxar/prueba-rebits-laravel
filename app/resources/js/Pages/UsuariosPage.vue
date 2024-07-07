<template>
    <app-layout>
        <div>
            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Apellidos</th>
                        <th>Correo</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="u in usuarios" :key="u.id">
                        <td>{{ u.id }}</td>
                        <td>{{ u.nombre }}</td>
                        <td>{{ u.apellidos }}</td>
                        <td>{{ u.correo }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </app-layout>
</template>

<script>
import "bootstrap/dist/css/bootstrap.min.css";
import "bootstrap/dist/js/bootstrap.bundle.min.js";
import AppLayout from "../Layouts/AppLayout.vue";
import axios from "axios";

export default {
    name: "Home",
    components: {
        AppLayout,
    },
    data() {
        return {
            usuarios: [],
        };
    },
    methods: {
        async getUsers() {
            const response = await axios.get("/api/usuarios");
            console.log("response: ", response);
            this.usuarios = response.data;
        },
    },
    mounted() {
        this.getUsers();
    },
};
</script>
