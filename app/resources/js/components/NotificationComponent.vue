<template>
    <div v-if="visible" :class="['notification', clase, { fade: fading }]">
        <p>{{ message }}</p>
    </div>
</template>

<script>
export default {
    name: "NotificationComponent",
    props: {
        message: {
            type: String,
            required: true,
        },
        duration: {
            type: Number,
            default: 3000,
        },
        clase: {
            type: String,
            default: "success",
        },
    },
    data() {
        return {
            visible: true,
            fading: false,
        };
    },
    mounted() {
        setTimeout(() => {
            this.fading = true;
            setTimeout(() => {
                this.visible = false;
            }, 500);
        }, this.duration);
    },
};
</script>

<style scoped>
.notification {
    color: white;
    padding: 16px;
    position: fixed;
    top: 20px;
    right: 20px;
    border-radius: 5px;
    opacity: 1;
    transition: opacity 0.5s ease-in-out;
}

.success {
    background-color: #4caf50;
}

.warning {
    background-color: #ff9800;
}

.fade {
    opacity: 0;
}
</style>
