<template>
    <TabMenu :model="items" :activeIndex="activeIndex"/>
</template>

<script>
import TabMenu from "primevue/tabmenu";


export default {
    name: 'ProfileTabMenu',
    components: {
        TabMenu
    },
    data() {
        return {
            items: [
                {
                    label: 'Профиль пользователя', to: '/profile', command: () => {
                        this.navigate('/profile')
                    }
                },
                {
                    label: 'История загрузок', to: '/download_history', command: () => {
                        this.navigate('/download_history')
                    }
                },
                {
                    label: 'Черновик по расчёту нмцк', to: '/nmck_history', command: () => {
                        this.navigate('/nmck_history')
                    }
                },
            ],
        };
    },
    methods: {
        navigate(route) {
            this.$router.push(route);
        },
    },
    computed: {
        activeIndex() {
            const activeItem = this.items.findIndex(item => this.$route.path === item.to);
            return activeItem !== -1 ? activeItem : null;
        },
    },
}
</script>

<style scoped>
</style>
