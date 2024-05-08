<template>
    <section class="landing-block2 flow-expert-ai">
        <div class="content-container" style="max-width: 100%;">
            <div class="flex align-items-stretch flex-column lg:flex-row">
                <div
                    class="flex mt-3 lg:align-content-start align-items-center lg:justify-content-start justify-content-center lg:col-6">
                    <router-link to="/" class="logo-container">
                        <img src="../../pics/logo.webp" alt="FlowExpert" class="header-logo">
                        <span class="logo-title">Flow Expert</span>
                    </router-link>
                </div>
                <div class="flex-1 mt-3 lg:col-6">
                    <div class="flex-row">
                        <i class="pi pi-map-marker feature-icon"></i>
                        <span>г. Иркутск, ул. Академическая, д. 26, ТЦ «БУМ»</span>
                    </div>
                    <div class="flex-row">
                        <i class="pi pi-phone feature-icon"></i>
                        <span>+ 7 (800) 500-1091</span>
                    </div>
                    <div class="flex-row">
                        <i class="pi pi-envelope feature-icon"></i>
                        <span>aptekar@irk.ru</span>
                    </div>
                </div>
            </div>
            <router-link to="user_agreement">
                <span link class="forgot-password-link">Пользовательское соглашение</span>
            </router-link>
        </div>
    </section>
</template>

<script>
import Button from 'primevue/button';

export default {
    name: 'LandingBody3',
    components: {
        Button
    },

};
</script>

<style scoped>

</style>
