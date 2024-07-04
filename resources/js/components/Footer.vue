<template>
    <section class="landing-block2 flow-expert-ai">
        <div class="content-container" style="max-width: 100%;">
            <div class="flex flex-column lg:flex-row">
                <div
                    class="flex lg:mt-0 mt-3 lg:align-content-start align-items-center lg:justify-content-start justify-content-center lg:col-7">
                    <router-link to="/" class="logo-container">
                        <img src="../../pics/logo1.webp" alt="FlowExpert" class="header-logo">
                    </router-link>
                </div>
                <div class="flex-1 lg:mt-0 mt-3 lg:col-5">
                    <div class="flex-row">
                        <i class="pi pi-map-marker feature-icon"></i>
                        <a :href="mapLink" target="_blank">г. Иркутск, ул. Академическая, д. 26, ТЦ «БУМ»</a>
                    </div>
                    <div class="flex-row">
                        <i class="pi pi-phone feature-icon"></i>
                        <a href="tel:78005001091">+ 7 (800) 500-1091</a>
                    </div>
                    <div class="flex-row">
                        <i class="pi pi-envelope feature-icon"></i>
                        <a href="mailto:aptekar@irk.ru">aptekar@irk.ru</a>
                    </div>
                </div>
            </div>
            <router-link to="user_agreement" class="flex lg:mt-0 mt-3 lg:align-content-start align-items-center lg:justify-content-start justify-content-center">
                <span link class="forgot-password-link">Пользовательское соглашение</span>
            </router-link>
            <router-link to="agree_personal" class="flex lg:mt-0 mt-3 lg:align-content-start align-items-center lg:justify-content-start justify-content-center">
                <span link class="forgot-password-link">Согласие на обработку персональных данных</span>
            </router-link>
        </div>
    </section>
</template>

<script>
import Button from 'primevue/button';

export default {
    name: 'Footer',
    components: {
        Button
    },
    data() {
        return {
            mapLink: ''
        };
    },
    mounted() {
        this.setMapLink();
    },
    methods: {
        setMapLink() {
            const isMobile = /iPhone|iPad|iPod|Android/i.test(navigator.userAgent);
            const geoLocation = "52.234482,104.293622";

            if (isMobile) {
                this.mapLink = `geo:52.234482,104.293622`;
            } else {
                this.mapLink = `https://yandex.ru/maps/-/CDblZY8q`;
            }
        }
    }

};
</script>

<style scoped>

</style>
