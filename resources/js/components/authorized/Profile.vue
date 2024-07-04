<template>
    <Header></Header>
    <section class="landing-block2 about-section">
        <div class="content-container">
            <ProfileTabMenu></ProfileTabMenu>
            <div class="flex lg:flex-row flex-column">
                <Card class="card-landing2 flex flex-column mt-3 lg:col-9 flex-order-1 lg:flex-order-0">
                    <template #content>
                        <div class="p-grid p-fluid">
                            <div class="p-col-12 p-md-6">
                                <div class="flex justify-content-between flex-wrap">
                                    <span v-if="!changePassword" class="flex align-items-center justify-content-center">
                                        Данные пользователя
                                    </span>
                                    <span v-else class="flex align-items-center justify-content-center">
                                        Изменить пароль
                                    </span>
                                    <span class="flex align-items-center justify-content-center" @click="clickChangePassword">
                                        Изменить пароль
                                    </span>
                                </div>
                                <form v-if="!changePassword" @submit.prevent="saveChanges">
                                    <div class="p-field">
                                        <InputText placeholder="ФИО" class="field" required v-model="user.name"/>
                                    </div>
                                    <div class="p-field">
                                        <InputText placeholder="Должность" class="field" disabled v-model="user.position_name"/>
                                    </div>
                                    <div class="p-field">
                                        <InputText placeholder="Наименование организации" class="field"
                                                   v-model="user.company"/>
                                    </div>
                                    <div class="p-field">
                                        <InputText pattern=".{12,}" title="ИНН должен состоять из 12 цифр" v-mask="'############'" placeholder="ИНН" class="field" v-model="user.inn"/>
                                    </div>
                                    <div class="p-field">
                                        <InputText pattern=".{9,}" title="КПП должен состоять из 9 цифр" v-mask="'#########'" placeholder="КПП" class="field" v-model="user.kpp"/>
                                    </div>
                                    <div class="p-field">
                                        <InputText pattern=".{17,}" title="Номер телефона должен состоять из 11 цифр" v-mask="'# (###) ###-##-##'" placeholder="Контактный телефон" required class="field" v-model="user.phone"/>
                                    </div>
                                    <div class="p-field">
                                        <InputText pattern="[^ ]+@[^ ]+\.[a-z]{2,3}" title="Email должен быть настоящим" placeholder="E-mail" class="field" required v-model="user.email"/>
                                    </div>
                                    <Button type="submit" label="Сохранить изменения" class="consultation-button"/>
                                </form>
                                <form v-else @submit.prevent="submitPasswordChange">
                                    <div class="p-field">
                                        <InputText placeholder="Старый пароль" type="password" class="field" required v-model="changePasswordData.old_password"/>
                                    </div>
                                    <div class="p-field">
                                        <InputText placeholder="Новый пароль" type="password" class="field" required v-model="changePasswordData.new_password"/>
                                    </div>
                                    <div class="p-field">
                                        <InputText placeholder="Подтверждение пароля" type="password" class="field" required v-model="changePasswordData.new_password_confirmation"/>
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
                <Dialog header="Данные пользователя" v-model:visible="dialogProfileVisible" @update:visible="handleDialogProfileVisibilityChange" :modal="true" :showHeader="true" :dismissableMask="true"
                        :style="{ width: '450px' }">
                    <div class="text-center" :style="{ color: dialogProfileColor }">
                        <h3>{{ dialogProfileMessage }}</h3>
                    </div>
                </Dialog>
            </div>
        </div>
    </section>
    <Footer></Footer>
</template>

<script>
import Header from "../Header.vue";
import Footer from "../Footer.vue";
import InputText from "primevue/inputtext";
import Card from "primevue/card";
import LoginButton from "../buttons/LoginButton.vue";
import TabMenu from "primevue/tabmenu";
import {mapState} from "vuex";
import Dialog from "primevue/dialog";
import ProfileTabMenu from "./ProfileTabMenu.vue";

export default {
    components: {ProfileTabMenu, LoginButton, Header, Footer, InputText, Card, TabMenu, Dialog},
    data() {
        return {
            changePassword: false,
            changePasswordData: {
                old_password: '',
                new_password: '',
                new_password_confirmation: ''
            }
        };
    },
    methods: {
        saveChanges() {
            this.user.phone = this.user.phone.replace(/[^\d]/g, '');
            this.$store.dispatch('profile/updateUserData');
        },
        handleDialogProfileVisibilityChange(newValue) {
            this.$store.commit('profile/SET_DIALOG_PROFILE_VISIBLE', newValue);
        },
        clickChangePassword() {
            this.changePassword = !this.changePassword;
        },
        submitPasswordChange() {
            this.$store.dispatch('profile/changePassword', this.changePasswordData);
        }
    },
    computed: {
        ...mapState('profile', ['dialogProfileVisible', 'dialogProfileMessage', 'dialogProfileColor']),
        user() {
            return this.$store.getters['profile/userInfo'];
        },
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
