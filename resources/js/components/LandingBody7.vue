<template>
    <section class="landing-block2 flow-expert-ai">
        <div class="content-container" style="max-width: 100%;">
            <div class="title-section">
                <h3>Остались вопросы?</h3>
                <p>Заполните форму и мы свяжемся с вами в ближайшее время </p>
            </div>
            <div class="flex align-items-stretch flex-column lg:flex-row">
                <div class="flex-1 lg:flex-none mt-3 lg:col-6 hidden lg:block">
                    <div class="flex-row">
                        <p>Контактная информация</p>
                    </div>
                    <div class="flex-row">
                        <i class="pi pi-map-marker feature-icon"></i>
                        <span>г. Иркутск, ул. Академическая, д. 26, ТЦ «БУМ»</span>
                    </div>
                    <div class="flex-row">
                        <i class="pi pi-phone feature-icon"></i>
                        <span>+ 7 (800) 500-1091</span>
                    </div>
                    <div class="flex-row">
                        <i class="pi pi-envelope feature-icon"></i>
                        <span>aptekar@irk.ru</span>
                    </div>
                </div>
                <div class="flex mt-3 lg:col-6">
                    <form class="form" @submit.prevent="submitForm">
                        <InputText placeholder="Название компании" v-model="formData.company_name" required
                                   class="field"/>
                        <InputText placeholder="Должность" v-model="formData.position" required class="field"/>
                        <div class="p-field">
                            <InputText placeholder="Фамилия" v-model="formData.surname" required class="field"/>
                        </div>
                        <div class="p-field">
                            <InputText placeholder="Имя" v-model="formData.name" required class="field"/>
                        </div>
                        <div class="p-field">
                            <InputText pattern=".{17,}" title="Номер телефона должен состоять из 11 цифр" v-mask="'# (###) ###-##-##'" placeholder="Телефон" v-model="formData.phone" required class="field"/>
                        </div>
                        <div class="p-field">
                            <InputText pattern="[^ ]+@[^ ]+\.[a-z]{2,3}" title="Email должен быть настоящим" placeholder="E-mail" v-model="formData.email" required class="field"/>
                        </div>
                        <div class="p-field">
                            <Textarea placeholder="Комментарии" v-model="formData.comments" class="field text-area"
                                      style="border-radius: 15px;" rows="4"/>
                        </div>
                        <div class="flex align-items-center">
                            <Checkbox v-model="formData.agreement" required binary inputId="agreement"/>
                            <label for="agreement" class="ml-2">Нажимая кнопку «Отправить», я даю свое согласие на
                                обработку моих персональных данных, в соответствии с Федеральным законом от 27.07.2006
                                года №152-ФЗ «О персональных данных», на условиях и для целей, определенных в <router-link to="agree_personal" target="_blank">Согласии
                                    на обработку персональных данных</router-link></label>
                        </div>
                        <Button type="submit" label="Заказать консультацию" class="consultation-button"/>
                    </form>
                </div>
            </div>
            <Dialog header="Отправка формы" v-model:visible="dialogVisible" @update:visible="handleDialogVisibilityChange" :modal="true" :showHeader="true" :dismissableMask="true"
                    :style="{ width: '450px' }">
                <div class="text-center" :style="{ color: dialogColor }">
                    <h3>{{ dialogMessage }}</h3>
                </div>
            </Dialog>
        </div>
    </section>
</template>

<script>
import {mapState, mapActions} from 'vuex';
import InputText from 'primevue/inputtext';
import Textarea from "primevue/textarea";
import Checkbox from 'primevue/checkbox';
import Button from 'primevue/button';
import Dialog from 'primevue/dialog';

export default {
    name: 'LandingBody7',
    components: {
        InputText,
        Textarea,
        Checkbox,
        Button,
        Dialog
    },
    computed: {
        ...mapState('landing', ['formData', 'dialogVisible', 'dialogMessage', 'dialogColor'])
    },
    methods: {
        ...mapActions('landing', ['setFormData', 'submitForm']),
        handleDialogVisibilityChange(newValue) {
            this.$store.commit('landing/SET_DIALOG_VISIBLE', newValue);
        },
    },
};
</script>

<style scoped>

.title-section p {
    font-size: 1.5em;
    color: #333;
    text-indent: 0;
}


</style>
