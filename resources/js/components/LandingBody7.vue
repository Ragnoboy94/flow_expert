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
                        <span>г. Иркутск, ул Байкальска 344</span>
                    </div>
                    <div class="flex-row">
                        <i class="pi pi-phone feature-icon"></i>
                        <span>+7 (934) 757-88-99</span>
                    </div>
                    <div class="flex-row">
                        <i class="pi pi-envelope feature-icon"></i>
                        <span>info@company24.com</span>
                    </div>
                </div>
                <div class="flex mt-3 lg:col-6">
                    <form class="form">
                        <InputText placeholder="Название компании" v-model="formData.companyName" class="field"/>
                        <InputText placeholder="Должность" v-model="formData.position" class="field"/>
                        <div class="p-field">
                            <InputText placeholder="Фамилия" v-model="formData.surname" class="field"/>
                        </div>
                        <div class="p-field">
                            <InputText placeholder="Имя" v-model="formData.name" class="field"/>
                        </div>
                        <div class="p-field">
                            <InputText placeholder="Телефон" v-model="formData.phone" class="field"/>
                        </div>
                        <div class="p-field">
                            <InputText placeholder="E-mail" v-model="formData.email" class="field"/>
                        </div>
                        <div class="p-field">
                            <Textarea placeholder="Комментарии" v-model="formData.comments" class="field text-area" style="border-radius: 15px;" rows="4"/>
                        </div>
                        <div class="flex align-items-center">
                            <Checkbox v-model="formData.agreement" binary inputId="agreement"/>
                            <label for="agreement" class="ml-2">Нажимая кнопку «Отправить», я даю свое согласие на обработку моих персональных данных, в соответствии с Федеральным законом от 27.07.2006 года №152-ФЗ «О персональных данных», на условиях и для целей, определенных в Согласии на обработку персональных данных *</label>
                        </div>
                        <Button label="Заказать консультацию" class="consultation-button"/>
                    </form>
                </div>
            </div>
        </div>
    </section>
</template>

<script>
import InputText from 'primevue/inputtext';
import Textarea from "primevue/textarea";
import Checkbox from 'primevue/checkbox';
import Button from 'primevue/button';
export default {
    name: 'LandingBody3',
    components: {
        InputText,
        Textarea,
        Checkbox,
        Button
    },
    data() {
        return {
            formData: {
                companyName: '',
                position: '',
                surname: '',
                name: '',
                phone: '',
                email: '',
                comments: '',
                agreement: false
            }
        };
    },
};
</script>

<style scoped>

.title-section p {
    font-size: 1.5em;
    color: #333;
}


</style>
