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
            <InputText placeholder="Название компании" v-model="formData.company_name" required class="field"/>
            <InputText placeholder="Должность" v-model="formData.position" required class="field"/>
            <div class="p-field">
                <InputText placeholder="Фамилия" v-model="formData.surname" required class="field"/>
            </div>
            <div class="p-field">
                <InputText placeholder="Имя" v-model="formData.name" required class="field"/>
            </div>
            <div class="p-field">
                <InputText placeholder="Телефон" v-model="formData.phone" required class="field"/>
            </div>
            <div class="p-field">
                <InputText placeholder="E-mail" v-model="formData.email" required class="field"/>
            </div>
            <div class="p-field">
                <Textarea placeholder="Комментарии" v-model="formData.comments" class="field text-area"
                          style="border-radius: 15px;" rows="4"/>
            </div>
            <div class="flex align-items-center">
                <Checkbox v-model="formData.agreement" required binary inputId="agreement"/>
                <label for="agreement" class="ml-2">Нажимая кнопку «Отправить», я даю свое согласие на обработку моих
                    персональных данных, в соответствии с Федеральным законом от 27.07.2006 года №152-ФЗ «О персональных
                    данных», на условиях и для целей, определенных в Согласии на обработку персональных данных *</label>
            </div>
            <Button type="submit" label="Заказать консультацию" class="consultation-button"/>
        </form>
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
        ...mapState('landing', ['formData'])
    },
    methods: {
        ...mapActions('landing', ['setFormData', 'submitForm']),

        showDialog() {
            this.dialogConsultationVisible = true;
        },
        hideDialog() {
            this.dialogConsultationVisible = false;
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
