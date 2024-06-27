<template>
    <Button label="Регистрация организации" class="sidebar-button" text link icon="pi pi-plus"
            @click="showDialog = true"/>
    <Dialog header="Зарегистрировать организацию" v-model:visible="showDialog" :modal="true"
            :style="{ width: '450px' }"
            :dismissableMask="true">
        <template #header>
            <div class="inline-flex align-items-center justify-content-center gap-2">
                <span v-if="!confirmationMessage" class="font-bold text-header">Зарегистрировать организацию</span>
                <span v-else class="font-bold text-header">На вашу почту отправлено письмо для подтверждения</span>
            </div>
        </template>
        <template v-if="!confirmationMessage">
            <form @submit.prevent="registerOrganizationVue">
                <div class="p-field">
                    <InputText placeholder="Полное наименование организации" id="name" v-model="organization.name"
                               class="field" required/>
                </div>
                <div class="p-field">
                    <InputText placeholder="Юридический адрес" id="juridical_address"
                               v-model="organization.juridical_address" class="field" required/>
                </div>
                <div class="p-field">
                    <InputText placeholder="Почтовый адрес" id="postal_address" v-model="organization.postal_address"
                               class="field" required/>
                </div>
                <div class="p-field">
                    <InputText placeholder="ИНН" id="inn" v-model="organization.inn" class="field" required/>
                </div>
                <div class="p-field">
                    <InputText placeholder="Казначейский/расчетный счет" id="account_number"
                               v-model="organization.account_number" class="field" required/>
                </div>
                <div class="p-field">
                    <InputText placeholder="Банковский счет" id="bank_account" v-model="organization.bank_account"
                               class="field" required/>
                </div>
                <div class="p-field">
                    <InputText placeholder="БИК" id="bik" v-model="organization.bik" class="field" required/>
                </div>
                <div class="p-field">
                    <InputText placeholder="ОГРН" id="ogrn" v-model="organization.ogrn" class="field" required/>
                </div>
                <div class="p-field">
                    <InputText placeholder="E-mail" id="email" v-model="organization.email" class="field" required/>
                </div>
                <div class="p-field">
                    <InputText placeholder="Телефон" id="phone" v-model="organization.phone" class="field" required/>
                </div>
                <div class="p-field">
                    <Button label="Добавить организацию" type="submit" class="consultation-button"/>
                </div>
            </form>
        </template>
    </Dialog>
</template>

<script>
import Dialog from 'primevue/dialog';
import InputText from 'primevue/inputtext';
import Button from 'primevue/button';
import {mapState, mapActions} from 'vuex';

export default {
    name: 'OrganizationRegistrationDialog',
    components: {
        Dialog,
        InputText,
        Button
    },
    data() {
        return {
            visible: false,
            showDialog: false,
            confirmationMessage: false
        };
    },
    computed: {
        ...mapState('organization', ['organization'])
    },
    methods: {
        ...mapActions('organization', ['registerOrganization', 'setOrganizationField']),
        async registerOrganizationVue() {
            await this.registerOrganization();
            this.confirmationMessage = true;
        },
    }
}
</script>

<style scoped>

</style>
