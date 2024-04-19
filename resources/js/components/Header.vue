<template>
    <header class="header">
        <router-link to="/" class="logo-container">
            <img src="../../pics/logo.webp" alt="FlowExpert" class="header-logo">
            <span class="logo-title">Flow Expert</span>
        </router-link>

        <nav class="header-nav">
            <router-link to="/about" class="header-link">О нас</router-link>
            <router-link to="/contacts" class="header-link">Контакты</router-link>
        </nav>
        <div class="header-icons">
            <i class="pi pi-user"></i>
            <i class="pi pi-bars" @click="visible = true"></i>
        </div>
        <Sidebar v-model:visible="visible" position="right" class="header-sidebar">
            <router-link to="/demand">
                <Button label="Получение приведенной потребности" class="sidebar-button" outlined
                        icon="pi pi-chart-line"/>
            </router-link>
            <router-link to="/lots">
                <Button label="Оформление лотов" class="sidebar-button" outlined icon="pi pi-inbox"/>
            </router-link>
            <router-link to="/instructions">
                <Button label="Инструкции" class="sidebar-button" outlined icon="pi pi-book"/>
            </router-link>
            <router-link to="/offers">
                <Button label="Формирование коммерческих предложений" class="sidebar-button" outlined
                        icon="pi pi-briefcase"/>
            </router-link>
            <Button label="Расчёт НМЦК" class="sidebar-button" outlined icon="pi pi-calculator" @click="toggleSubMenu"/>
            <template v-if="showSubMenu">
                <router-link to="/nmck-settings">
                    <Button label="Настройка параметров расчёта НМЦК" class="sidebar-button" outlined/>
                </router-link>
                <router-link to="/nmck-basis">
                    <Button label="Обоснование НМЦК" class="sidebar-button" outlined/>
                </router-link>
            </template>

            <ConsultationButton/>
            <LogoutButton/>
        </Sidebar>
    </header>
</template>

<script>
import Sidebar from 'primevue/sidebar';
import Button from "primevue/button";
import ConsultationButton from './buttons/ConsultationButton.vue';
import LogoutButton from "./buttons/LoginButton.vue";


export default {
    name: 'Header',
    components: {
        LogoutButton,
        Sidebar,
        Button,
        ConsultationButton
    },
    data() {
        return {
            visible: false,
            showSubMenu: false
        };
    },
    methods: {
        toggleSubMenu() {
            this.showSubMenu = !this.showSubMenu;
        }
    }
}
</script>

<style scoped>
.header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 1rem 2rem;
    background-color: #fff;
    border-radius: 1vw;
}

.logo-container {
    display: flex;
    flex-direction: column;
    align-items: center;
}

.header-logo {
    width: 50px;
}

.logo-title {
    font-size: 0.5rem;
    color: #333;
    text-align: center;
}


.header-nav {
    display: flex;
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
    width: 100%;
    margin-bottom: 0.5rem;
    border-radius: 1vw;
}

</style>
