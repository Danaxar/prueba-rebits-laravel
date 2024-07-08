<template>
    <app-layout>
        <div>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Marca</th>
                        <th>Modelo</th>
                        <th>Patente</th>
                        <th>Año</th>
                        <th>Precio</th>
                        <th>Acción</th>
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
                        <td>
                            <button class="btn btn-primary" @click="editar(v)">
                                Editar
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    width="16"
                                    height="16"
                                    fill="currentColor"
                                    class="bi bi-pencil-fill"
                                    viewBox="0 0 16 16"
                                >
                                    <path
                                        d="M12.854.146a.5.5 0 0 0-.707 0L10.5 1.793 14.207 5.5l1.647-1.646a.5.5 0 0 0 0-.708zm.646 6.061L9.793 2.5 3.293 9H3.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.207zm-7.468 7.468A.5.5 0 0 1 6 13.5V13h-.5a.5.5 0 0 1-.5-.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.5-.5V10h-.5a.5.5 0 0 1-.175-.032l-.179.178a.5.5 0 0 0-.11.168l-2 5a.5.5 0 0 0 .65.65l5-2a.5.5 0 0 0 .168-.11z"
                                    />
                                </svg>
                            </button>
                        </td>
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
    name: "VehiculosPage",
    components: {
        AppLayout,
    },
    data() {
        return {
            vehiculos: [],
            vehiculoSeleccionado: null,
        };
    },
    methods: {
        async getVehiculos() {
            const response = await axios.get("/api/vehiculos");
            console.log("response: ", response);
            this.vehiculos = response.data;
        },
        editar(v) {
            this.vehiculoSeleccionado = v;
            window.location.href = `/editar-vehiculo/${v.id}`;
        },
    },
    mounted() {
        this.getVehiculos();
    },
};
</script>

<style scoped></style>
