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
            <router-link to="/profile">
                <i class="pi pi-user"></i>
            </router-link>
            <i class="pi pi-bars" @click="visible = true"></i>
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
            <Button class="sidebar-button" text raised @click="toggleSubMenu"><i class="pi pi-calculator ml-0"></i>
                <span class="ml-auto">Расчёт НМЦК</span> <i class="pi pi-chevron-down ml-auto"></i></Button>
            <template v-if="showSubMenu">
                <router-link to="/nmck-settings">
                    <Button label="Настройка параметров расчёта НМЦК" class="sidebar-button ml-4 w-11" text raised/>
                </router-link>
                <router-link to="/nmck-basis">
                    <Button label="Обоснование НМЦК" class="sidebar-button ml-4 w-11" text raised/>
                </router-link>
            </template>
            <ConsultationButton/>
            <LogoutButton/>
        </Sidebar>
    </header>
</template>

<script>
import Sidebar from 'primevue/sidebar';
import ConsultationButton from './buttons/ConsultationButton.vue';
import LogoutButton from "./buttons/LoginButton.vue";


export default {
    name: 'Header',
    components: {
        LogoutButton,
        Sidebar,
        ConsultationButton
    },
    data() {
        return {
            visible: false,
            showSubMenu: false,
        };
    },
    methods: {
        toggleSubMenu() {
            this.showSubMenu = !this.showSubMenu;
        },
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

.logo-title {
    font-size: 0.5rem;
    color: #333;
    text-align: center;
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
}

</style>
