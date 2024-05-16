<template>
    <Header></Header>
    <section class="landing-block2">
        <div class="content-container">
            <div class="title-section">
                <h3>Настройка параметров расчёта НМЦК</h3>
            </div>
            <div class="flex justify-content-between flex-wrap">
                <span class="flex align-items-center justify-content-center">
                    ЗАКАЗЧИК
                </span>
                <span class="flex align-items-center justify-content-center" @click="clickChangePassword">
                    Изменить заказчика
                </span>
            </div>
            <Fieldset legend="ЗАКАЗЧИК">
                <p class="m-0">
                    {{ customer.name }}<br>
                    {{ customer.inn }} / {{ customer.kpp }}
                </p>
            </Fieldset>

            <Divider/>

            <div class="block">
                <label class="block-label">РАСЧЁТ ОСУЩЕСТВЛЯЕТСЯ В СООТВЕТСТВИИ</label>
                <div class="checkbox-group">
                    <Checkbox v-model="calculationOptions.order567" label="Приказ 567"/>
                    <Checkbox v-model="calculationOptions.order450n" label="Приказ 450н"/>
                </div>
            </div>

            <div class="block">
                <label class="block-label">В КАКИХ КОНТРАКТАХ ИСКАТЬ ЦЕНЫ?</label>
                <div class="checkbox-group">
                    <Checkbox v-model="contractOptions.fz44" label="44-ФЗ"/>
                    <Checkbox v-model="contractOptions.fz223" label="223-ФЗ"/>
                </div>
                <div class="button-group">
                    <Button label="Способ определения исполнителя 44-ФЗ"/>
                    <Button label="Способ определения исполнителя 223-ФЗ"/>
                </div>
                <Checkbox v-model="contractOptions.eaec" label="Учитывать контракты с поставкой только из стран ЕАЭС"/>
            </div>

            <div class="block">
                <label class="block-label">СТАТУС ЗАКУПОК</label>
                <div class="checkbox-group">
                    <Checkbox v-model="purchaseStatus.completed" label="Исполнение завершено"/>
                    <Checkbox v-model="purchaseStatus.inProgress" label="Исполнение"/>
                    <Checkbox v-model="purchaseStatus.terminated" label="Исполнение прекращено"/>
                    <Checkbox v-model="purchaseStatus.cancelled" label="Аннулирован"/>
                </div>
                <div class="date-group">
                    <label>ДАТА ОКОНЧАНИЯ ИСПОЛНЕНИЯ КОНТРАКТА</label>
                    <InputText v-model="dates.endDate" type="date"/>
                    <InputText v-model="dates.endDate2" type="date"/>
                </div>
                <div class="date-group">
                    <label>ДАТА ПОДПИСАНИЯ КОНТРАКТА (НЕОБЯЗАТЕЛЬНО)</label>
                    <InputText v-model="dates.signDate" type="date"/>
                    <InputText v-model="dates.signDate2" type="date"/>
                </div>
                <InputText v-model="region" placeholder="Регион заказчика"/>
                <Checkbox v-model="noPenalties" label="Без штрафов и пеней"/>
            </div>

            <div class="block">
                <label class="block-label">ИСКЛЮЧИТЬ КОНТРАКТЫ ВЫБРАННЫХ ОРГАНИЗАЦИЙ</label>
                <InputText v-model="excludedContracts"
                           placeholder="Название / Реквизиты / Адрес / Генеральный директор"/>
            </div>

            <div class="block">
                <label class="block-label">НАСТРОЙКА РАСЧЁТА ЦЕН</label>
                <div class="toggle-group">
                    <ToggleButton v-model="priceCalculationOptions.noPenalties" onLabel="Без штрафов и пеней"
                                  offLabel="Со штрафами и пенями"/>
                    <Dropdown v-model="priceCalculationOptions.category" :options="categories"
                              placeholder="Категория товаров"/>
                </div>
                <Checkbox v-model="priceCalculationOptions.noIndexation"
                          label="Не применять индексацию цен для контрактов заключённых ранее 6 месяцев назад"/>
                <div class="input-group">
                    <label>ПРЕДЕЛЬНОЕ ЗНАЧЕНИЕ КОЭФ. ВАРИАЦИИ</label>
                    <InputText v-model="priceCalculationOptions.variationLimit"/>
                </div>
                <div class="input-group">
                    <label>КОЛИЧЕСТВО ЗНАКОВ ПОСЛЕ ЗАПЯТОЙ</label>
                    <InputNumber v-model="priceCalculationOptions.decimalPlaces"/>
                </div>
            </div>

            <Button label="ДАЛЕЕ" class="next-button"/>
        </div>
    </section>
    <Footer></Footer>
</template>

<script>
import Header from "./../Header.vue";
import Footer from "./../Footer.vue";
import InputText from 'primevue/inputtext';
import Button from 'primevue/button';
import Checkbox from 'primevue/checkbox';
import ToggleButton from 'primevue/togglebutton';
import Dropdown from 'primevue/dropdown';
import InputNumber from 'primevue/inputnumber';
import Divider from "primevue/divider";
import Fieldset from "primevue/fieldset";

export default {
    components: {Header, Footer, InputText, Button, Checkbox, ToggleButton, Dropdown, InputNumber, Divider, Fieldset},
    data() {
        return {
            customer: {name: 'Осипов Пётр Иванович', inn: 89644488, kpp: 213123213},
            calculationOptions: {
                order567: false,
                order450n: true
            },
            contractOptions: {
                fz44: true,
                fz223: true,
                eaec: true
            },
            purchaseStatus: {
                completed: true,
                inProgress: true,
                terminated: true,
                cancelled: true
            },
            dates: {
                endDate: '2024-01-01',
                endDate2: '2024-01-31',
                signDate: '2024-01-01',
                signDate2: '2024-01-31'
            },
            region: '',
            noPenalties: true,
            excludedContracts: '',
            priceCalculationOptions: {
                noPenalties: true,
                category: null,
                noIndexation: true,
                variationLimit: 33,
                decimalPlaces: 2
            },
            categories: [
                {label: 'Категория 1', value: 'cat1'},
                {label: 'Категория 2', value: 'cat2'}
            ]
        };
    }
}
</script>


<style scoped>

.block {
    margin-bottom: 20px;
}

.block-label {
    font-weight: bold;
    margin-bottom: 10px;
    display: block;
}

.input-group, .checkbox-group, .button-group, .date-group, .toggle-group {
    margin-bottom: 10px;
}

.input-readonly {
    background-color: #e0f7fa;
    padding: 10px;
    border-radius: 1rem;
    width: 100%;
    display: inline-block;
}

.next-button {
    display: block;
    margin: 20px auto;
    padding: 10px 20px;
}
</style>

