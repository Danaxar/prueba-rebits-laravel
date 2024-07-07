<template>
    <app-layout>
        <div>
            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Marca</th>
                        <th>Modelo</th>
                        <th>Patente</th>
                        <th>Año</th>
                        <th>Precio</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="v in vehiculos" :key="v.id">
                        <td>{{ v.id }}</td>
                        <td>{{ v.marca }}</td>
                        <td>{{ v.modelo }}</td>
                        <td>{{ v.patente }}</td>
                        <td>{{ v.anio }}</td>
                        <td>{{ v.precio }}</td>
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
            vehiculos: [],
        };
    },
    methods: {
        async getVehiculos() {
            const response = await axios.get("/api/vehiculos");
            console.log("response: ", response);
            this.vehiculos = response.data;
        },
    },
    mounted() {
        this.getVehiculos();
    },
};
</script>
