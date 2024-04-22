<template>
    <Button class="sidebar-button sidebar-button--outline" label="Войти" v-if="!isAuthenticated" outlined
            @click="showLoginDialog = true"/>
    <Button class="sidebar-button sidebar-button--outline" label="Выйти" v-else outlined @click="logout"/>
    <Dialog v-model:visible="showLoginDialog" v-if="loginStep !== 'loginSuccess'" :modal="true" :showHeader="false"
            :dismissableMask="true"
            :style="{ width: '450px' }">
        <TabView>
            <TabPanel header="Войти">
                <div v-if="loginStep === 'inputInfo'">
                    <form @submit.prevent="verifyUser">
                        <InputText placeholder="ФИО" v-model="loginInfo.fullName" class="field" required/>
                        <InputText placeholder="Телефон" v-model="loginInfo.phone" class="field" required/>
                        <Button type="submit" label="Далее" class="consultation-button"/>
                        <div class="forgot-password-container">
                            <Button link class="forgot-password-link" type="button" label="Забыли пароль?" @click="redirectToForgotPassword"/>
                        </div>
                        <div class="user-agreement">
                            Авторизуясь, я соглашаюсь с условиями <span link class="forgot-password-link" type="button" @click="redirectToForgotPassword">Пользовательского соглашения</span>.
                        </div>
                    </form>
                </div>
                <div v-else-if="loginStep === 'inputPassword'">
                    <form @submit.prevent="login">
                        <InputText class="field" type="password" placeholder="Пароль" v-model="loginInfo.password"
                                   required/>
                        <Button type="submit" label="Войти" class="consultation-button"/>
                    </form>
                </div>
            </TabPanel>
            <TabPanel header="Зарегистрироваться">
                <form @submit.prevent="register" class="p-fluid form-layout">
                    <InputText placeholder="ФИО" v-model="registerInfo.fullName" class="field" required/>
                    <InputText placeholder="Телефон" v-model="registerInfo.phone" class="field" required/>
                    <InputText placeholder="E-mail" v-model="registerInfo.email" class="field" required/>
                    <div class="category-item">Хочу зарегистрироваться, как сотрудник</div>
                    <div v-for="category in categories" :key="category.key" class="flex align-items-center category-item">
                        <RadioButton v-model="selectedCategory" :inputId="category.key" name="dynamic" :value="category.name" />
                        <label :for="category.key" class="ml-2">{{ category.name }}</label>
                    </div>
                    <InputText type="password" placeholder="Пароль" v-model="registerInfo.password" class="field"
                               required/>
                    <InputText type="password" placeholder="Пароль ещё раз" v-model="registerInfo.password_confirmation"
                               class="field" required/>
                    <Button type="submit" label="Зарегистрироваться" class="consultation-button"/>
                    <div class="user-agreement">
                        Продолжая регистрацию, вы соглашаетесь с нашим <span link class="forgot-password-link" type="button" @click="redirectToForgotPassword">пользовательским соглашением</span> и <span link class="forgot-password-link" type="button" @click="redirectToForgotPassword">политикой конфиденциальности</span>.
                    </div>
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
import RadioButton from "primevue/radiobutton";

export default {
    name: 'LoginButton',
    components: {
        Dialog,
        TabView,
        TabPanel,
        InputText,
        Button,
        RadioButton
    },
    data() {
        return {
            showLoginDialog: false,
            selectedCategory: 'частной клиники',
        };
    },
    computed: {
        ...mapState('auth', ['loginInfo', 'loginStep', 'registerInfo', 'isAuthenticated']),
        categories() {
            return this.$store.state.auth.categories;
        },
    },
    methods: {
        ...mapActions('auth', ['verifyUser', 'login', 'register', 'Logout']),

        logout() {
            this.Logout();
        },
        redirectToForgotPassword() {
            ///
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
.forgot-password-container {
    text-align: center;
}

.forgot-password-link {
    text-decoration: underline;
    cursor: pointer;
    color:black;
}

.user-agreement {
    text-align: center;
    font-size: small;
}

.category-item {
    font-size:small;
    margin-right: 0.5rem;
    margin-top: 0.5rem;
}
.p-radiobutton {
    margin-right: 0.5rem; /* Добавляем отступ между значком и текстом радиокнопки */
}
</style>
