<template>
    <app-layout>
        <div>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID Usuario</th>
                        <th>Fecha posesión</th>
                        <th>Nombre</th>
                        <th>Apellidos</th>
                        <th>Correo</th>
                        <th>Patente Vehiculo</th>
                        <th>Marca</th>
                        <th>Modelo</th>
                        <th>Año Vehiculo</th>
                        <th>Precio</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(v, index) in vehiculosUsuarios" :key="index">
                        <td>{{ v.id }}</td>
                        <td>{{ v.fecha_inicio }}</td>
                        <td>{{ v.nombre_usuario }}</td>
                        <td>{{ v.apellidos_usuario }}</td>
                        <td>{{ v.correo_usuario }}</td>
                        <td>{{ v.patente_vehiculo }}</td>
                        <td>{{ v.marca_vehiculo }}</td>
                        <td>{{ v.modelo_vehiculo }}</td>
                        <td>{{ v.anio_vehiculo }}</td>
                        <td>{{ v.precio_vehiculo }}</td>
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
    name: "UsuariosVehiculosPage",
    components: {
        AppLayout,
    },
    data() {
        return {
            vehiculosUsuarios: [],
        };
    },
    methods: {
        async getData() {
            try {
                const response = await axios.get("/api/historicos");
                console.log(response);
                this.vehiculosUsuarios = response.data;
            } catch (error) {
                console.error("Error al obtener datos: ", error);
            }
        },
    },
    mounted() {
        this.getData();
    },
};
</script>

<style scoped></style>
