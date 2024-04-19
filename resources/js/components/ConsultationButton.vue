<template>
    <Button label="Заказать консультацию" class="consultation-button" @click="showDialog"/>
    <Dialog header="Заполните форму и мы свяжемся с вами в ближайшее время"
            v-model:visible="dialogVisible"
            :modal="true"
            :style="{ width: '400px' }"
            :dismissableMask="true">
        <template #header>
            <div class="inline-flex align-items-center justify-content-center gap-2">
                <span class="font-bold white-space-nowrap text-header">Заполните форму и мы свяжемся с вами в ближайшее время</span>
            </div>
        </template>
        <form @submit.prevent="submitForm" class="form">
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
                <Textarea placeholder="Комментарии" v-model="formData.comments" class="field text-area" rows="5"/>
            </div>
            <div class="flex align-items-center">
                <Checkbox v-model="formData.agreement" binary inputId="agreement"/>
                <label for="agreement" class="ml-2">Нажимая кнопку "Отправить", я даю согласие на обработку моих персональных данных...</label>
            </div>
            <Button label="Заказать консультацию" class="consultation-button"/>
        </form>
    </Dialog>
</template>

<script>
import Dialog from 'primevue/dialog';
import InputText from 'primevue/inputtext';
import Textarea from "primevue/textarea";
import Checkbox from 'primevue/checkbox';
import Button from 'primevue/button';

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
            dialogVisible: false,
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
    methods: {
        showDialog() {
            this.dialogVisible = true;
        },
        hideDialog() {
            this.dialogVisible = false;
        },
        submitForm() {
            this.hideDialog();
        }
    }
}
</script>


<style scoped>
.consultation-button {
    background: #00A950;
    color: white;
    border: none;
    margin-top: 10px;
    cursor: pointer;
    text-align: center;
    padding: 10px 20px;
    width: 100%;
    margin-bottom: 0.5rem;
    border-radius: 100px;
}

.field {
    margin-top: 10px;
    width: 100%;
    border-radius: 100px;
    padding-left: 20px;
    border-color: #00a950;
}

.text-area {
    border-radius: 10px;
}

.text-header {
    color: #00a950;
    text-align: center;
}
</style>
