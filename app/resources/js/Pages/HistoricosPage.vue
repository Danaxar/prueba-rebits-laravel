<template>
    <app-layout>
        <div>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID Usuario</th>
                        <th>Nombre</th>
                        <th>Apellidos</th>
                        <th>Correo</th>
                        <th>ID Vehículo</th>
                        <th>Marca</th>
                        <th>Modelo</th>
                        <th>Patente</th>
                        <th>Año</th>
                        <th>Precio</th>
                        <th>Acción</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(v, index) in vehiculosUsuarios" :key="index">
                        <td>{{ v.usuario.id }}</td>
                        <td>{{ v.usuario.nombre }}</td>
                        <td>{{ v.usuario.apellidos }}</td>
                        <td>{{ v.usuario.correo }}</td>
                        <td>{{ v.vehiculo.id }}</td>
                        <td>{{ v.vehiculo.marca }}</td>
                        <td>{{ v.vehiculo.modelo }}</td>
                        <td>{{ v.vehiculo.patente }}</td>
                        <td>{{ v.vehiculo.anio }}</td>
                        <td>{{ v.vehiculo.precio }}</td>
                        <td>
                            <button
                                class="btn btn-primary"
                                @click="editar(v.vehiculo)"
                            >
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
    name: "UsuariosVehiculosPage",
    components: {
        AppLayout,
    },
    data() {
        return {
            usuarios: [],
            vehiculos: [],
            vehiculosUsuarios: [],
        };
    },
    methods: {
        async getData() {
            try {
                const [usuariosResponse, vehiculosResponse] = await Promise.all(
                    [axios.get("/api/usuarios"), axios.get("/api/vehiculos")]
                );

                this.usuarios = usuariosResponse.data;
                this.vehiculos = vehiculosResponse.data;

                this.combineData();
            } catch (error) {
                console.error("Error al obtener datos: ", error);
            }
        },
        combineData() {
            this.vehiculosUsuarios = this.vehiculos.map((vehiculo) => {
                return {
                    usuario: this.usuarios.find(
                        (usuario) => usuario.id === vehiculo.usuarioId
                    ),
                    vehiculo,
                };
            });
        },
        editar(vehiculo) {
            window.location.href = `/editar-vehiculo/${vehiculo.id}`;
        },
    },
    mounted() {
        this.getData();
    },
};
</script>

<style scoped></style>
