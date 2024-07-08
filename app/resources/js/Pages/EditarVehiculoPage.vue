<template>
    <app-layout>
        <div class="container mt-4">
            <h2 class="mb-4">Editar registro</h2>
            <form @submit.prevent="updateVehiculo">
                <div class="row">
                    <div class="col-md-16">
                        <div class="card mb-4">
                            <div class="card-body">
                                <h4>Datos del vehículo</h4>
                                <div class="form-group">
                                    <label for="marca">Marca</label>
                                    <input
                                        type="text"
                                        class="form-control"
                                        id="marca"
                                        v-model="vehiculo.marca"
                                        disabled
                                    />
                                </div>
                                <div class="form-group">
                                    <label for="modelo">Modelo</label>
                                    <input
                                        type="text"
                                        class="form-control"
                                        id="modelo"
                                        v-model="vehiculo.modelo"
                                        disabled
                                    />
                                </div>
                                <div class="form-group">
                                    <label for="patente">Patente</label>
                                    <input
                                        type="text"
                                        class="form-control"
                                        id="patente"
                                        v-model="vehiculo.patente"
                                        disabled
                                    />
                                </div>
                                <div class="form-group">
                                    <label for="anio">Año</label>
                                    <input
                                        type="number"
                                        class="form-control"
                                        id="anio"
                                        v-model="vehiculo.anio"
                                        disabled
                                    />
                                </div>
                                <div class="form-group">
                                    <label for="precio">Precio</label>
                                    <input
                                        type="number"
                                        class="form-control"
                                        id="precio"
                                        v-model="vehiculo.precio"
                                        min="0"
                                    />
                                </div>
                            </div>
                        </div>
                        <div class="card mb-4">
                            <div class="card-body">
                                <h4>Datos del dueño actual</h4>
                                <div class="form-group">
                                    <label for="nombre">Nombre</label>
                                    <input
                                        disabled
                                        type="text"
                                        class="form-control"
                                        id="nombre"
                                        v-model="dueno.nombre"
                                    />
                                </div>
                                <div class="form-group">
                                    <label for="apellidos">Apellidos</label>
                                    <input
                                        disabled
                                        type="text"
                                        class="form-control"
                                        id="apellidos"
                                        v-model="dueno.apellidos"
                                    />
                                </div>
                                <div class="form-group">
                                    <label for="correo">Correo</label>
                                    <input
                                        disabled
                                        type="email"
                                        class="form-control"
                                        id="correo"
                                        v-model="dueno.correo"
                                    />
                                </div>
                            </div>
                        </div>
                        <div class="card mb-4">
                            <div class="card-body">
                                <h4>Datos del nuevo dueño</h4>
                                <div class="form-group">
                                    <label for="nombre">Nombre</label>
                                    <input
                                        type="text"
                                        class="form-control"
                                        id="nombre"
                                        v-model="nuevoDueno.nombre"
                                    />
                                </div>
                                <div class="form-group">
                                    <label for="apellidos">Apellidos</label>
                                    <input
                                        type="text"
                                        class="form-control"
                                        id="apellidos"
                                        v-model="nuevoDueno.apellidos"
                                    />
                                </div>
                                <div class="form-group">
                                    <label for="correo">Correo</label>
                                    <input
                                        type="email"
                                        class="form-control"
                                        id="correo"
                                        v-model="nuevoDueno.correo"
                                    />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mt-4 d-flex justify-content-between">
                    <button
                        type="button"
                        class="btn btn-danger"
                        @click="cancelar"
                    >
                        Cancelar
                    </button>
                    <button type="submit" class="btn btn-success">
                        Guardar
                    </button>
                </div>
            </form>
            <div class="loading-div" v-if="isLoading">
                <img
                    src="https://media.tenor.com/G7LfW0O5qb8AAAAi/loading-gif.gif"
                />
            </div>
        </div>
    </app-layout>
</template>

<script>
import "bootstrap/dist/css/bootstrap.min.css";
import "bootstrap/dist/js/bootstrap.bundle.min.js";
import AppLayout from "../Layouts/AppLayout.vue";
import axios from "axios";

export default {
    name: "EditarVehiculoPage",
    components: {
        AppLayout,
    },
    data() {
        return {
            vehiculo: {
                marca: "",
                modelo: "",
                patente: "",
            },
            dueno: {
                nombre: "",
                apellidos: "",
                correo: "",
            },
            nuevoDueno: {
                nombre: "María",
                apellidos: "García",
                correo: "maria.garcia@example.com",
            },
            isLoading: true,
        };
    },
    methods: {
        // Obtiene el id de vehiculo de la url
        getIdUrl() {
            const url = window.location.href;
            return url.substring(url.lastIndexOf("/") + 1);
        },

        // Llama a la API para obtener el vehículo
        async getVehiculo() {
            try {
                const id = this.getIdUrl();
                const response = await axios.get(`/api/vehiculos/${id}`);
                this.vehiculo = response.data;
            } catch (error) {
                console.error("Error al obtener el vehículo:", error);
            }
        },

        // Llama a la API para obtener el dueño del vehículo
        async getDueno() {
            try {
                const id = this.getIdUrl();
                const response = await axios.get(
                    `/api/vehiculos/${id}/getDueno`
                );
                this.dueno = response.data;
                console.log("Dueño: ", this.dueno);
            } catch (error) {
                console.error("Error al obtener el dueño:", error);
            }
        },

        async updateVehiculo() {
            // Mandar el vehículo actualizado
            try {
                this.isLoading = true;
                const response = await axios.post(
                    // const response = await this.$inertia.post(
                    "/api/vehiculos/nuevoDueno",
                    {
                        vehiculo: this.vehiculo,
                        usuario: this.nuevoDueno,
                    }
                );
                this.isLoading = false;
                if (response.status == 200) {
                    alert("Vehículo actualizado correctamente");
                }
                console.log("Respuesta updateVehiculo(): ", response);
            } catch (e) {
                console.log(e);
            }
        },
        cancelar() {
            window.history.back();
        },
    },
    mounted() {
        this.getVehiculo();
        this.getDueno();
    },
};
</script>

<style scoped>
.loading-div {
    position: fixed;
    height: 100vh;
    width: 100vw;
    background-color: transparent;
    transition: 1s;
}

.loading-div img {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    width: 100px;
    height: 100px;
}
</style>
