<template>
    <Header></Header>
    <section class="landing-block2 about-section">
        <div class="content-container">
            <div>
                <TabMenu :model="items" :activeIndex="activeIndex"/>
            </div>
            <div class="flex lg:flex-row flex-column">
                <Card class="card-landing2 flex flex-column mt-3 lg:col-9 flex-order-1 lg:flex-order-0">
                    <template #content>
                        <div class="p-grid p-fluid">
                            <div class="p-col-12 p-md-6">
                                <div class="flex justify-content-between flex-wrap">
                                    <span class="flex align-items-center justify-content-center">
                                        Данные пользователя
                                    </span>
                                    <span class="flex align-items-center justify-content-center">
                                        Изменить пароль
                                    </span>
                                </div>
                                <form @submit.prevent="saveChanges">
                                    <div class="p-field">
                                        <InputText placeholder="ФИО" class="field" required v-model="user.name"/>
                                    </div>
                                    <div class="p-field">
                                        <InputText placeholder="Должность" class="field" required v-model="user.position"/>
                                    </div>
                                    <div class="p-field">
                                        <InputText placeholder="Наименование организации" class="field"
                                                   v-model="user.company"/>
                                    </div>
                                    <div class="p-field">
                                        <InputText placeholder="ИНН" class="field" v-model="user.inn"/>
                                    </div>
                                    <div class="p-field">
                                        <InputText placeholder="КПП" class="field" v-model="user.kpp"/>
                                    </div>
                                    <div class="p-field">
                                        <InputText placeholder="Контактный телефон" required class="field" v-model="user.phone"/>
                                    </div>
                                    <div class="p-field">
                                        <InputText placeholder="E-mail" class="field" required v-model="user.email"/>
                                    </div>
                                    <Button type="submit" label="Сохранить изменения" class="consultation-button"/>
                                </form>
                            </div>
                        </div>
                    </template>
                </Card>
                <div class="flex flex-column lg:col-3 ml-2">
                    <Card class="flex mt-3 bg-green-100">
                        <template #content>
                            <div class="user-profile">
                                <div class="user-details">
                                    <h4> {{ user.name }}</h4>
                                    <p><i class="pi pi-phone"></i> {{user.phone}}</p>
                                    <p><i class="pi pi-envelope"></i> {{user.email}}</p>
                                </div>
                            </div>
                        </template>
                    </Card>
                    <LoginButton></LoginButton>
                </div>
            </div>
        </div>
    </section>
    <Footer></Footer>
</template>

<script>
import Header from "../Header.vue";
import Footer from "../Footer.vue";
import InputText from "primevue/inputtext";
import Button from "primevue/button";
import Card from "primevue/card";
import LoginButton from "../buttons/LoginButton.vue";
import TabMenu from "primevue/tabmenu";

export default {
    components: {LoginButton, Header, Footer, InputText, Button, Card, TabMenu},
    data() {
        return {
            user: {
                fullName: '',
                position: '',
                company: '',
                inn: '',
                kpp: '',
                phone: '',
                email: ''
            },
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
            ]
        };
    },
    methods: {
        navigate(route) {
            this.$router.push(route);
        },
        saveChanges() {
            this.$store.dispatch('profile/updateUserData');
        }
    },
    computed: {
        activeIndex() {
            const activeItem = this.items.findIndex(item => this.$route.path === item.to);
            return activeItem !== -1 ? activeItem : null;
        },
        user() {
            return this.$store.getters['profile/userInfo'];
        }
    },
    created() {
        this.$store.dispatch('profile/fetchUserData');
    },

}
</script>

<style scoped>

.user-details h4 {
    margin-top: 0;
    font-size: 1.25em;
}

.user-details p {
    margin: 0.5em 0;
    font-size: 1em;
}

.card-landing2 {
    height: 100%;
    border: 2px solid #00A950;
    padding: 1rem;
    box-shadow: 0 4px 8px rgba(0, 169, 80, 0.2);
    border-radius: 7vh;
    text-decoration: none;
}

</style>
