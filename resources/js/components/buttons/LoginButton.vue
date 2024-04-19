<template>
    <Button class="sidebar-button sidebar-button--outline" label="Войти" outlined @click="showLoginDialog = true"/>
    <Dialog v-model:visible="showLoginDialog" :modal="true" :showHeader="false" :dismissableMask="true"
            :style="{ width: '450px' }">
        <TabView>
            <TabPanel header="Войти">
                <div v-if="loginStep === 'inputInfo'">
                    <form @submit.prevent="verifyUser">
                        <InputText placeholder="ФИО" v-model="loginInfo.fullName" required />
                        <InputText placeholder="Телефон" v-model="loginInfo.phone" required />
                        <Button label="Далее" class="p-button-success" @click="verifyUser"/>
                    </form>
                </div>
                <div v-else-if="loginStep === 'inputPassword'">
                    <form @submit.prevent="login">
                        <InputText type="password" placeholder="Пароль" v-model="loginInfo.password" required />
                        <Button label="Войти" class="p-button-success"/>
                    </form>
                </div>
            </TabPanel>
            <TabPanel header="Зарегистрироваться">
                <form @submit.prevent="onRegister" class="p-fluid form-layout">
                    <InputText placeholder="ФИО" v-model="registerForm.fullName" class="form-field"/>
                    <InputText placeholder="Телефон" v-model="registerForm.phone" class="form-field"/>
                    <InputText placeholder="E-mail" v-model="registerForm.email" class="form-field"/>
                    <InputText type="password" placeholder="Пароль" v-model="registerForm.password" class="form-field"/>
                    <InputText type="password" placeholder="Пароль ещё раз" v-model="registerForm.confirmPassword"
                               class="form-field"/>
                    <div class="form-radio-group">

                    </div>
                    <Button label="Зарегистрироваться" class="register-button"/>
                </form>
            </TabPanel>
        </TabView>
    </Dialog>
</template>

<script>
import { mapState, mapActions } from 'vuex';
import Dialog from 'primevue/dialog';
import TabView from 'primevue/tabview';
import TabPanel from 'primevue/tabpanel';
import InputText from 'primevue/inputtext';
import Button from 'primevue/button';

export default {
    name: 'LoginButton',
    components: {
        Dialog,
        TabView,
        TabPanel,
        InputText,
        Button
    },
    data() {
        return {
            showLoginDialog: false,
            registerForm: {
                fullName: '',
                phone: '',
                email: '',
                password: '',
                confirmPassword: ''
            }
        };
    },
    computed: {
        ...mapState('auth', ['loginInfo', 'loginStep'])
    },
    methods: {
        ...mapActions('auth', ['verifyUser', 'login', 'onRegister'])
    }
}
</script>

<style scoped>
.sidebar-button--outline {
    width: 100%;
    margin-bottom: 0.5rem;
    border-radius: 1vw;
}

.forgot-password-link {
    display: block;
    margin-top: 1rem;
    text-align: right;
    color: var(--primary-color);
    text-decoration: none;
}

.forgot-password-link:hover {
    text-decoration: underline;
}
</style>
