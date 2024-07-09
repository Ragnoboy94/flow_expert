<template>
    <Dialog header="Подтверждение" v-model:visible="showConfirmationModal" :modal="true" class="xl:w-6 lg:w-7 md:w-8 sm:w-9"
            :dismissableMask="true">
        <p><b>Уважаемый пользователь!</b></p>
        <p> Благодарим Вас за использование нашего ресурса.</p>
        <p>Полный функционал системы FlowExpert в демонстрационной версии доступен бесплатно в течение первых 14 календарных
            дней после регистрации и акцепта (подписания) лицензионного соглашения.</p>
        <p>Для использования полного функционала системы FlowExpert после истечения указанного срока, пожалуйста,
            производите оплату лицензионного вознаграждения в размере и сроки, установленные в лицензионном соглашении
            для вашей категории учреждения (организации).
        </p>
        <Button label="Подтвердить" class="consultation-button" @click="confirm"/>
    </Dialog>
</template>

<script>
import Dialog from "primevue/dialog";
import {mapState, mapActions} from 'vuex';

export default {
    name: 'ConfirmationModal',
    components: {
        Dialog
    },
    computed: {
        ...mapState('organization', ['showConfirmationModal']),
    },
    methods: {
        ...mapActions('organization', ['setTrialPeriod']),
        confirm() {
            this.setTrialPeriod();
        }
    }
};
</script>


<style scoped>

</style>
