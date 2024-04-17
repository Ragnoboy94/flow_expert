<template>
    <header class="header">
        <img src="logo.png" alt="FlowExpert" class="header-logo">
        <nav class="header-nav">
            <a href="/about" class="header-link">О нас</a>
            <a href="/contacts" class="header-link">Контакты</a>
        </nav>
        <div class="header-icons">
            <i class="pi pi-user"></i>
            <i class="pi pi-bars" @click="visible = true"></i>
        </div>
        <Sidebar v-model:visible="visible" position="right" class="header-sidebar">
            <a href="/about" class="header-link">О нас</a>
            <a href="/contacts" class="header-link">Контакты</a>
        </Sidebar>
    </header>
</template>

<script>
import Sidebar from 'primevue/sidebar';
export default {
    name: 'Header',
    components: {
        Sidebar
    },
    data() {
        return {
            visible: false
        };
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
    border-radius: 10px;
}

.header-logo {
    width: 100px;
}

.header-nav {
    display: flex;
}

.header-link,
.sidebar-link {
    margin: 0 1rem;
    color: #333;
    text-decoration: none;
    font-weight: bold;
}

.header-link:hover,
.sidebar-link:hover {
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
</style>
