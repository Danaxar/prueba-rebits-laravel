<script setup>
import "bootstrap/dist/css/bootstrap.min.css";
import "bootstrap/dist/js/bootstrap.bundle.min.js";
</script>

<template>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg bg-body-tertiary">
        <!-- Container -->
        <div class="container-fluid">
            <!-- Home -->
            <a class="navbar-brand" href="https://rebits.cl/" target="_blank">
                <img src="../../../public/ReBits-logo.webp" alt="Logo"
                width="175" height="51" class="d-inline-block align-text-top"
            </a>
            <button
                class="navbar-toggler"
                type="button"
                data-bs-toggle="collapse"
                data-bs-target="#navbarNav"
                aria-controls="navbarNav"
                aria-expanded="true"
                aria-label="Toggle navigation"
            >
                <span class="navbar-toggler-icon"></span>
            </button>

            <!-- Rutas -->
            <div class="collapse navbar-collapse" id="navbarNav">
                <!-- Lista no enumerada -->
                <ul class="navbar-nav mx-auto">
                    <!-- Items -->
                    <li class="nav-item">
                        <a class="nav-link" href="/">Subir excel</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/vehiculos">Vehículos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/usuarios">Usuarios</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/historicos">Históricos</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</template>

<style scoped>
.nav-link:hover {
    color: #02b9f6;
}

/* Agregar una linea debajo del navbar como separación */
.navbar {
    border-bottom: 1px solid #0000003c;
}
</style>
