<template>
    <Header></Header>
    <section class="landing-block2 about-section">
        <div class="content-container">
            <div>
                <TabMenu :model="items" :activeIndex="activeIndex" />
            </div>
            <div class="flex lg:flex-row flex-column">
                <Card class="card-landing2 flex flex-column mt-3 lg:col-9 flex-order-1">
                    <template #content>
                        <div class="p-grid p-fluid">
                            <div class="p-col-12 p-md-6">
                                <div class="p-field">
                                    <label for="fullName">ФИО</label>
                                    <InputText id="fullName" v-model="user.fullName"/>
                                </div>
                                <div class="p-field">
                                    <label for="position">Должность</label>
                                    <InputText id="position" v-model="user.position"/>
                                </div>
                                <div class="p-field">
                                    <label for="company">Наименование организации</label>
                                    <InputText id="company" v-model="user.company"/>
                                </div>
                                <div class="p-field">
                                    <label for="inn">ИНН</label>
                                    <InputText id="inn" v-model="user.inn"/>
                                </div>
                                <div class="p-field">
                                    <label for="kpp">КПП</label>
                                    <InputText id="kpp" v-model="user.kpp"/>
                                </div>
                                <div class="p-field">
                                    <label for="phone">Контактный телефон</label>
                                    <InputText id="phone" v-model="user.phone"/>
                                </div>
                                <div class="p-field">
                                    <label for="email">E-mail</label>
                                    <InputText id="email" v-model="user.email"/>
                                </div>
                                <Button label="Сохранить изменения" class="p-button-success"/>
                            </div>
                        </div>
                    </template>
                </Card>
                <div class="flex flex-column lg:col-3 ml-2 flex-order-0">
                    <Card class="flex mt-3 bg-green-100">
                        <template #content>
                            <div class="user-profile">
                                <div class="user-details">
                                    <h4>Осипов Петр Иванович</h4>
                                    <p><i class="pi pi-phone"></i> +7 (905) - 077 - 77-99</p>
                                    <p><i class="pi pi-envelope"></i> name2010@gmail.com</p>
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
                { label: 'Профиль пользователя', to: '/profile', command: () => { this.navigate('/profile') } },
                { label: 'История загрузок', to: '/download_history', command: () => { this.navigate('/download_history') } },
                { label: 'Черновик по расчёту нмцк', to: '/nmck_history', command: () => { this.navigate('/nmck_history') } },
            ]
        };
    },
    methods: {
        navigate(route) {
            this.$router.push(route);
        }
    },
    computed: {
        activeIndex() {
            const activeItem = this.items.findIndex(item => this.$route.path === item.to);
            return activeItem !== -1 ? activeItem : null;
        }
    }

}
</script>

<style scoped>
.user-profile {
    display: flex;
    align-items: center;
    justify-content: center;
    flex-direction: column;
}

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
