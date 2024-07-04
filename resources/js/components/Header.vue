<template>
    <header class="header xl:px-8 lg:px-8 md:px-8">
        <router-link to="/" class="logo-container">
            <img src="../../pics/logo1.webp" alt="FlowExpert" class="header-logo">
        </router-link>

        <div class="header-icons ">
            <nav class="header-nav">
                <router-link to="/about" class="header-link px-4 font-light">О нас</router-link>
                <router-link to="/contacts" class="header-link px-4 font-light">Контакты</router-link>
            </nav>
            <router-link to="/profile">
                <i class="pi pi-user pi-custom xl:px-5 lg:px-5 md:px-5"></i>
            </router-link>
            <i class="pi pi-bars pi-custom xl:px-5 lg:px-5 md:px-5 px-3" @click="visible = true"></i>
        </div>
        <Sidebar v-model:visible="visible" position="right" class="header-sidebar">
            <router-link to="/demand">
                <Button label="Получение приведенной потребности" class="sidebar-button" text raised
                        icon="pi pi-chart-line"/>
            </router-link>
            <router-link to="/lots">
                <Button label="Формирование лотов" class="sidebar-button" text raised icon="pi pi-inbox"/>
            </router-link>
            <router-link to="/instructions">
                <Button label="Инструкции" class="sidebar-button" text raised icon="pi pi-book"/>
            </router-link>
            <router-link to="/offers">
                <Button label="Формирование коммерческих предложений" class="sidebar-button" text raised
                        icon="pi pi-briefcase"/>
            </router-link>
            <router-link to="/nmck_basis">
                <Button label="Расчёт НМЦК" class="sidebar-button" text raised icon="pi pi-calculator"/>
            </router-link>

            <ConsultationButton/>
            <LogoutButton/>
            <OrganizationRegistrationDialog/>
        </Sidebar>
    </header>
</template>

<script>
import Sidebar from 'primevue/sidebar';
import ConsultationButton from './buttons/ConsultationButton.vue';
import LogoutButton from "./buttons/LoginButton.vue";
import OrganizationRegistrationDialog from "./buttons/OrganizationRegistrationDialog.vue";

export default {
    name: 'Header',
    components: {
        OrganizationRegistrationDialog,
        LogoutButton,
        Sidebar,
        ConsultationButton,
    },
    data() {
        return {
            visible: false,
        };
    },
}
</script>

<style scoped>
.header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    background-color: #fff;
    border-radius: 1vw;
}

@media screen and (max-width: 767px) {
    /* или другая ширина экрана, которую вы считаете мобильной */
    .header-link {
        display: none;
    }
}

.header-link {
    margin: 0 1rem;
    color: #333;
    text-decoration: none;
    font-weight: bold;
}

.header-link:hover {
    color: #00a950;
}

.header-icons {
    display: flex;
}

.pi-custom {
    margin-top: -2px;
}

.pi {
    font-size: 1.5rem;
    margin-left: 1rem;
    cursor: pointer;
    color: #00a950;
}

.pi:hover {
    color: #00a950;
}

.sidebar-button:not(:last-child) {
    margin-bottom: 10px;
}

.sidebar-button {
    color: #00a950;
    width: 100%;
    margin-bottom: 0.5rem;
}

</style>
