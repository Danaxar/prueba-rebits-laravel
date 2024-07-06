<template>
    <div>
        <header>
            <NavbarComponent />
        </header>
        <main>
            <slot></slot>
        </main>
    </div>
</template>

<script>
import NavbarComponent from "../components/NavbarComponent.vue";

export default {
    name: "AppLayout",
    components: {
        NavbarComponent,
    },
};
</script>
