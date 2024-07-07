<template>
    <app-layout>
        <div class="flex">
            <div class="center-div">
                <form @submit.prevent="sendFile">
                    <!-- Input de archivo -->
                    <div class="fileInput-div">
                        <label for="formFileLg" class="form-label"
                            >Seleccione un archivo excel</label
                        >
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
            </div>
        </div>
    </app-layout>
</template>

<script>
import "bootstrap/dist/css/bootstrap.min.css";
import "bootstrap/dist/js/bootstrap.bundle.min.js";
import AppLayout from "../Layouts/AppLayout.vue";

export default {
    name: "Home",
    components: {
        AppLayout,
    },
    data() {
        return {
            file: null,
        };
    },
    methods: {
        setFile(evento) {
            this.file = evento.target.files[0];
        },
        async sendFile() {
            const form = new FormData(); // Crear objeto form
            form.append("file", this.file); // Añadir el archivo

            console.log(this.file);

            // Mandar al backend
            try {
                const response = await this.$inertia.post(
                    "/api/excel/upload",
                    form
                );
                console.log(response);
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
    max-height: 25%;
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
</style>
