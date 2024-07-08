<template>
    <app-layout>
        <div class="flex">
            <div class="center-div">
                <form @submit.prevent="sendFile">
                    <!-- Input de archivo -->
                    <div class="fileInput-div">
                        <label for="formFileLg" class="form-label">
                            <img src="../../../public/icons8-excel.svg" />
                            Seleccione un archivo excel
                        </label>
                        <input
                            class="form-control form-control-lg"
                            id="formFileLg"
                            type="file"
                            accept=".xlsx, .xls"
                            @change="setFile"
                        />
                    </div>
                    <!-- Botones -->
                    <div class="buttons-div">
                        <button class="btn btn-danger" type="submit">
                            Cancelar
                        </button>
                        <button class="btn btn-success">Enviar</button>
                    </div>
                </form>
                <div class="alert alert-danger" v-if="existeError" role="alert">
                    <ul>
                        <li v-for="mensaje in mensajesErrores">
                            {{ mensaje }}
                        </li>
                    </ul>
                </div>
                <NotificationComponent
                    v-if="successNotification || warningNotification"
                    :message="mensajeNotificacion"
                    :clase="claseNotificacion"
                ></NotificationComponent>
            </div>
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
import NotificationComponent from "../components/NotificationComponent.vue";

export default {
    name: "Home",
    components: {
        AppLayout,
        NotificationComponent,
    },
    data() {
        return {
            file: null,
            existeError: false,
            mensajesErrores: [],
            successNotification: false,
            warningNotification: false,
            claseNotificacion: "",
            mensajeNotificacion: "",
            isLoading: false,
        };
    },
    methods: {
        setFile(evento) {
            this.file = evento.target.files[0];
        },
        async sendFile() {
            const form = new FormData(); // Crear objeto form
            form.append("file", this.file); // Añadir el archivo

            // Mandar al backend
            try {
                // const response = await this.$inertia.post(
                //     "/api/excel/upload",
                //     form
                // );
                this.isLoading = true;
                const response = await axios.post("/api/excel/upload", form, {
                    headers: {
                        "Content-Type": "multipart/form-data",
                    },
                });
                console.log("Response: ", response);
                this.isLoading = false;

                // Mostrar errores
                if (
                    response.data.messages &&
                    response.data.messages.length > 0
                ) {
                    this.existeError = true;
                    this.mensajesErrores = response.data.messages;
                }

                if (response.data.messages.length > 0) {
                    console.log(
                        `Caso warning, filas = ${response.data.rows} y total = ${response.data.messages.length}`
                    );
                    this.warningNotification = true; // Aqui se muestra un recuadro amarillo o naranjo
                    this.claseNotificacion = "warning";
                    this.mensajeNotificacion = "Tarea completada con alertas";
                }

                if (response.data.messages.length == 0) {
                    this.successNotification = true; // Aqui se muestra un recuadro verde
                    this.claseNotificacion = "success";
                    this.mensajeNotificacion =
                        "¡Tarea completada exitosamente!";
                }

                setTimeout(() => {
                    this.successNotification = false;
                    this.warningNotification = false;
                }, 8000);
            } catch (error) {
                console.log(error);
            }
        },
    },
};
</script>

<style scoped>
.flex {
    display: flex;
    justify-content: center;
    align-items: center;
    height: 85vh;
}

.center-div {
    box-shadow: rgba(0, 0, 0, 0.25) 0px 54px 55px,
        rgba(0, 0, 0, 0.12) 0px -12px 30px, rgba(0, 0, 0, 0.12) 0px 4px 6px,
        rgba(0, 0, 0, 0.17) 0px 12px 13px, rgba(0, 0, 0, 0.09) 0px -3px 5px;
    border-radius: 15px;
    width: 40%;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    padding: 0.5%;
}

.fileInput-div {
    height: 50%;
    /* background-color: pink; */
}

.buttons-div {
    height: 50%;
    /* background-color: rgb(8, 42, 53); */
}

.buttons-div button {
    height: 50%;
    margin: 1%;
}

.buttons-div button.btn-danger {
    width: 27%;
}
.buttons-div button.btn-success {
    width: 69%;
}

.alert {
    margin-top: 3%;
    margin-left: 2%;
    margin-right: 2%;
    border-radius: 15px;
    /* Agregarle un scroll vertical */
    max-height: 200px;
    overflow-y: auto;
    /* Agregarle un scroll horizontal */
}

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
