<template>
    <Button label="Заказать консультацию" class="consultation-button" @click="showDialog"/>
    <Dialog header="Заполните форму и мы свяжемся с вами в ближайшее время"
            v-model:visible="dialogConsultationVisible"
            :modal="true"
            :style="{ width: '450px' }"
            :dismissableMask="true">
        <template #header>
            <div class="inline-flex align-items-center justify-content-center gap-2">
                <span class="font-bold text-header">Заполните форму и мы свяжемся с вами в ближайшее время</span>
            </div>
        </template>
        <form class="form" @submit.prevent="submitForm">
            <InputText placeholder="Название компании" v-model="formDataConsultation.company_name" required class="field"/>
            <InputText placeholder="Должность" v-model="formDataConsultation.position" required class="field"/>
            <div class="p-field">
                <InputText placeholder="Фамилия" v-model="formDataConsultation.surname" required class="field"/>
            </div>
            <div class="p-field">
                <InputText placeholder="Имя" v-model="formDataConsultation.name" required class="field"/>
            </div>
            <div class="p-field">
                <InputText pattern=".{17,}" title="Номер телефона должен состоять из 11 цифр" v-mask="'# (###) ###-##-##'" placeholder="Телефон" v-model="formDataConsultation.phone" required class="field"/>
            </div>
            <div class="p-field">
                <InputText placeholder="E-mail" v-model="formDataConsultation.email" required class="field"/>
            </div>
            <div class="p-field">
                <Textarea placeholder="Комментарии" v-model="formDataConsultation.comments" class="field text-area"
                          style="border-radius: 15px;" rows="4"/>
            </div>
            <div class="flex align-items-center">
                <Checkbox v-model="formDataConsultation.agreement" required binary inputId="agreementConsultation"/>
                <label for="agreementConsultation" class="ml-2">Нажимая кнопку «Отправить», я даю свое согласие на обработку моих
                    персональных данных, в соответствии с Федеральным законом от 27.07.2006 года №152-ФЗ «О персональных
                    данных», на условиях и для целей, определенных в <router-link to="agree_personal" target="_blank">Согласии на обработку персональных данных</router-link></label>
            </div>
            <Button type="submit" label="Заказать консультацию" class="consultation-button"/>
        </form>
    </Dialog>
    <Dialog header="Отправка формы" v-model:visible="dialogVisible" @update:visible="handleDialogVisibilityChange" :modal="true" :showHeader="true" :dismissableMask="true"
            :style="{ width: '450px' }">
        <div class="text-center" :style="{ color: dialogColor }">
            <h3>{{ dialogMessage }}</h3>
        </div>
    </Dialog>
</template>

<script>
import Dialog from 'primevue/dialog';
import InputText from 'primevue/inputtext';
import Textarea from "primevue/textarea";
import Checkbox from 'primevue/checkbox';
import Button from 'primevue/button';
import {mapActions, mapState} from "vuex";

export default {
    name: 'ConsultationModal',
    components: {
        Dialog,
        InputText,
        Textarea,
        Checkbox,
        Button
    },
    data() {
        return {
            dialogConsultationVisible: false,
        };
    },
    computed: {
        ...mapState('consultation', ['formDataConsultation', 'dialogVisible', 'dialogMessage', 'dialogColor'])
    },
    methods: {
        ...mapActions('consultation', ['setFormData', 'submitForm']),

        showDialog() {
            this.dialogConsultationVisible = true;
        },
        hideDialog() {
            this.dialogConsultationVisible = false;
        },
        handleDialogVisibilityChange(newValue) {
            this.$store.commit('consultation/SET_DIALOG_VISIBLE', newValue);
        },
    }
}
</script>


<style scoped>


.text-area {
    border-radius: 10px;
}

.text-header {
    color: #00a950;
    text-align: center;
}
</style>
