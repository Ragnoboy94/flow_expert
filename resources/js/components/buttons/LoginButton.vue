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
                        <InputText pattern=".{17,}" title="Номер телефона должен состоять из 11 цифр" v-mask="'# (###) ###-##-##'" placeholder="Телефон" v-model="loginInfo.phone" class="field" required/>
                        <span v-if="loginErrorText" style="color: red">{{ loginErrorText }}</span>
                        <Button type="submit" label="Далее" class="consultation-button" :disabled="!isLoginValid"/>
                        <div class="forgot-password-container">
                            <Button link class="forgot-password-link" type="button" label="Забыли пароль?"
                                    @click="openChangePasswordDialog"/>
                        </div>
                        <div class="user-agreement">
                            Авторизуясь, я соглашаюсь с условиями <router-link to="user_agreement" target="_blank"><span link class="forgot-password-link">Пользовательского соглашения</span></router-link>.
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
                    <InputText pattern=".{17,}" title="Номер телефона должен состоять из 11 цифр" v-mask="'# (###) ###-##-##'" placeholder="Телефон" v-model="registerInfo.phone" class="field" required/>
                    <InputText pattern="[^ ]+@[^ ]+\.[a-z]{2,3}" title="Email должен быть настоящим" placeholder="E-mail" v-model="registerInfo.email" class="field" required/>
                    <div class="category-item">Хочу зарегистрироваться, как сотрудник</div>
                    <div v-for="category in categories" :key="category.key" class="flex align-items-center category-item">
                        <RadioButton v-model="registerInfo.category_id" :inputId="category.key" name="dynamic" :value="category.key"/>
                        <label :for="category.key" class="ml-2">{{ category.name }}</label>
                    </div>
                    <InputText pattern=".{8,}" title="Пароль должен быль больше 8 символов" type="password" placeholder="Пароль" v-model="registerInfo.password" class="field"
                               required/>
                    <InputText pattern=".{8,}" title="Пароль должен быль больше 8 символов" type="password" placeholder="Пароль ещё раз" v-model="registerInfo.password_confirmation"
                               class="field" required/>
                    <Button type="submit" label="Зарегистрироваться" class="consultation-button" :disabled="!isRegistrationValid"/>
                    <div class="user-agreement">
                        Продолжая регистрацию, вы соглашаетесь с нашим <router-link to="user_agreement" target="_blank"><span link class="forgot-password-link">пользовательским соглашением</span></router-link>
                        и <router-link to="privacy_policy" target="_blank"><span link class="forgot-password-link" type="button">политикой конфиденциальности</span></router-link>.
                    </div>
                </form>
            </TabPanel>
        </TabView>
    </Dialog>
    <Dialog v-model:visible="showLoginDialog" v-else :modal="true" @update:visible="handleDialogClose"
            :showHeader="true" :dismissableMask="true"
            :style="{ width: '450px' }">
        <div class="text-center text-success">
            <h3>Авторизация прошла успешно!</h3>
            <p>Добро пожаловать в систему. Теперь вы можете воспользоваться всеми функциями платформы.</p>
        </div>
    </Dialog>
    <Dialog header="Забыли пароль?" v-model:visible="changePasswordDialogVisible" @update:visible="handleDialogVisibilityChange" :modal="true" :closable="true"
            :showHeader="true" :style="{ width: '450px' }">
        <form v-if="!dialogProfileMessage" @submit.prevent="submitPasswordChange">
            <InputText pattern=".{17,}" title="Номер телефона должен состоять из 11 цифр" v-mask="'# (###) ###-##-##'" placeholder="Телефон" v-model="changePassword.phone" class="field" required/>
            <InputText placeholder="ФИО" v-model="changePassword.fullName" class="field" required/>
            <Button type="submit" label="Получить новый пароль" class="consultation-button"/>
        </form>
        <div v-else class="text-center" :style="{ color: dialogProfileColor }">
            <h3>{{ dialogProfileMessage }}</h3>
        </div>
    </Dialog>
    <Dialog header="Регистрация" v-model:visible="dialogRegistrationVisible" @update:visible="handleDialogRegistrationVisibilityChange" :modal="true" :showHeader="true" :dismissableMask="true"
            :style="{ width: '450px' }">
        <div class="text-center" :style="{ color: dialogRegistrationColor }">
            <h3>{{ dialogRegistrationMessage }}</h3>
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
            changePasswordDialogVisible: false,
            changePassword: {
                phone: '',
                fullName: ''
            },
        };
    },
    computed: {
        ...mapState('auth', ['loginInfo', 'loginStep', 'registerInfo', 'isAuthenticated', 'dialogRegistrationMessage', 'dialogRegistrationColor', 'dialogRegistrationVisible', 'loginErrorText']),
        ...mapState('profile', ['dialogProfileMessage', 'dialogProfileColor']),
        categories() {
            return this.$store.state.auth.categories;
        },
        isLoginValid() {
            return this.loginInfo.fullName.split(' ').filter(Boolean).length >= 2 && this.loginInfo.phone.length === 17;
        },
        isRegistrationValid() {
            return this.registerInfo.fullName.split(' ').filter(Boolean).length >= 2 && this.registerInfo.phone.length === 17;
        }
    },
    methods: {
        ...mapActions('auth', ['verifyUser', 'Logout']),

        logout() {
            this.Logout();
        },
        login() {
            this.loginInfo.phone = this.loginInfo.phone.replace(/[^\d]/g, '');
            this.$store.dispatch('auth/login');
        },
        register() {
            this.registerInfo.phone = this.registerInfo.phone.replace(/[^\d]/g, '');
            this.$store.dispatch('auth/register');
        },
        handleDialogClose(newValue) {
            if (!newValue && this.isAuthenticated) {
                const redirectUrl = this.$route.query.redirect || '/';
                this.$router.push(redirectUrl);
            }
        },
        openChangePasswordDialog() {
            this.changePasswordDialogVisible = true;
        },
        submitPasswordChange() {
            this.$store.dispatch('profile/forgotPassword', this.changePassword);
        },
        handleDialogVisibilityChange() {
            this.$store.commit('profile/SET_DIALOG_PROFILE_MESSAGE', '');
        },
        handleDialogRegistrationVisibilityChange(newValue) {
            this.$store.commit('auth/SET_DIALOG_REGISTRATION_VISIBLE', newValue);
        },
    }
}
</script>

<style scoped>
.sidebar-button--outline {
    width: 100%;
    margin-bottom: 0.5rem;
    border-radius: 3vw;
    margin-top: 10px;
}

.forgot-password-container {
    text-align: center;
}

.forgot-password-link {
    text-decoration: underline;
    cursor: pointer;
    color: black;
}

.user-agreement {
    text-align: center;
    font-size: small;
}

.category-item {
    font-size: small;
    margin-right: 0.5rem;
    margin-top: 0.5rem;
}

.p-radiobutton {
    margin-right: 0.5rem; /* Добавляем отступ между значком и текстом радиокнопки */
}
</style>
