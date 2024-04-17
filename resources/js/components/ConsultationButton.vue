<template>
    <Button class="consultation-button" label="Заказать консультацию" @click="consultation"/>
</template>

<script>
import Button from 'primevue/button';

export default {
    name: 'ConsultationButton',
    components: {
        Button
    },
    methods: {
        consultation() {
            console.log('Консультация заказана');
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
    margin-bottom: 10px;
    cursor: pointer;
    width: 100%;
    text-align: center;
    border-radius: 5px;
    font-weight: bold;
    padding: 10px 20px;
}
</style>
