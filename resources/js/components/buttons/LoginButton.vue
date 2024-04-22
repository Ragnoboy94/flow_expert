<template>
    <Button class="sidebar-button sidebar-button--outline" label="Войти" v-if="!isAuthenticated" outlined @click="showLoginDialog = true"/>
    <Button class="sidebar-button sidebar-button--outline" label="Выйти" v-else outlined @click="logout"/>
    <Dialog v-model:visible="showLoginDialog" v-if="loginStep !== 'loginSuccess'" :modal="true" :showHeader="false" :dismissableMask="true"
            :style="{ width: '450px' }">
        <TabView>
            <TabPanel header="Войти">
                <div v-if="loginStep === 'inputInfo'">
                    <form @submit.prevent="verifyUser">
                        <InputText placeholder="ФИО" v-model="loginInfo.fullName" required/>
                        <InputText placeholder="Телефон" v-model="loginInfo.phone" required/>
                        <Button type="submit" label="Далее" class="p-button-success"/>
                    </form>
                </div>
                <div v-else-if="loginStep === 'inputPassword'">
                    <form @submit.prevent="login">
                        <InputText type="password" placeholder="Пароль" v-model="loginInfo.password" required/>
                        <Button type="submit" label="Войти" class="p-button-success"/>
                    </form>
                </div>
            </TabPanel>
            <TabPanel header="Зарегистрироваться">
                <form @submit.prevent="register" class="p-fluid form-layout">
                    <InputText placeholder="ФИО" v-model="registerInfo.fullName" class="form-field" required/>
                    <InputText placeholder="Телефон" v-model="registerInfo.phone" class="form-field" required/>
                    <InputText placeholder="E-mail" v-model="registerInfo.email" class="form-field" required/>
                    <InputText type="password" placeholder="Пароль" v-model="registerInfo.password" class="form-field"
                               required/>
                    <InputText type="password" placeholder="Пароль ещё раз" v-model="registerInfo.password_confirmation"
                               class="form-field" required/>
                    <div class="form-radio-group">

                    </div>
                    <Button type="submit" label="Зарегистрироваться" class="register-button"/>
                </form>
            </TabPanel>
        </TabView>
    </Dialog>
    <Dialog v-model:visible="showLoginDialog" v-else :modal="true" :showHeader="true" :dismissableMask="true"
            :style="{ width: '450px' }">
        <div class="text-center text-success">
            <h3>Авторизация прошла успешно!</h3>
            <p>Добро пожаловать в систему. Теперь вы можете воспользоваться всеми функциями платформы.</p>
        </div>
    </Dialog>
</template>

<script>
import {mapState, mapActions} from 'vuex';
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
        };
    },
    computed: {
        ...mapState('auth', ['loginInfo', 'loginStep', 'registerInfo', 'isAuthenticated'])
    },
    methods: {
        ...mapActions('auth', ['verifyUser', 'login', 'register', 'Logout']),

        logout() {
            this.Logout();
        }
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
