<template>
    <Header></Header>
    <section class="landing-block2">
        <div class="content-container">
            <div class="title-section">
                <h3>Настройка параметров расчёта НМЦК</h3>
            </div>
            <div class="flex justify-content-end flex-wrap">
                <span class="flex justify-content-end" @click="clickChangePassword">
                    Изменить заказчика
                </span>
            </div>
            <Fieldset class="bg-green-100 border-round-3xl" legend="ЗАКАЗЧИК">
                <p class="m-0">
                    {{ customer.name }}<br>
                    {{ customer.inn }} / {{ customer.kpp }}
                </p>
            </Fieldset>

            <Fieldset class="border-round-3xl" legend="РАСЧЁТ ОСУЩЕСТВЛЯЕТСЯ В СООТВЕТСТВИИ">
                <div class="flex-1 lg:flex lg:flex-row">
                    <div class="flex col-6 ">
                        <Checkbox v-model="calculationOptions.order567" inputId="order567" :binary="true"
                                  @change="handleCheckboxChange('order567')"/>
                        <label for="order567" class="ml-2"> Приказ 567 </label>
                    </div>
                    <div class="flex col-6">
                        <Checkbox v-model="calculationOptions.order450n" inputId="order450n" :binary="true"
                                  @change="handleCheckboxChange('order450n')"/>
                        <label for="order450n" class="ml-2"> Приказ 450н </label>
                    </div>
                </div>
            </Fieldset>
            <Fieldset class="border-round-3xl" legend="В КАКИХ КОНТРАКТАХ ИСКАТЬ ЦЕНЫ?">
                <div class="flex-1 lg:flex lg:flex-row">
                    <div class="flex col-6 ">
                        <Checkbox v-model="contractOptions.fz44" inputId="fz44" :binary="true"
                                  @change="handleContractChange('fz44')"/>
                        <label for="fz44" class="ml-2"> 44-ФЗ </label>
                    </div>
                    <div class="flex col-6">
                        <Checkbox v-model="contractOptions.fz223" inputId="fz223" :binary="true"
                                  @change="handleContractChange('fz223')"/>
                        <label for="fz223" class="ml-2"> 223-ФЗ </label>
                    </div>
                </div>

                <div v-if="contractOptions.fz44 || contractOptions.fz223"
                     class="flex lg:flex-row border-round-2xl bg-green-100 my-2">
                    <div class="flex col-12">
                        <p class="ml-2">Способ определения исполнителя {{
                                contractOptions.fz44 ? '44-ФЗ' : '223-ФЗ'
                            }}</p>
                    </div>
                </div>

                <div class="flex lg:flex-row">
                    <div class="flex col-12">
                        <Checkbox v-model="contractOptions.eaec" inputId="eaec"
                                  :binary="true"/>
                        <label for="eaec" class="ml-2"> Учитывать контракты с поставкой только из стран ЕАЭС </label>
                    </div>
                </div>
            </Fieldset>
            <Fieldset class="border-round-3xl" legend="СТАТУС ЗАКУПОК">
                <div class="flex lg:flex-row flex-column">
                    <div class="lg:flex flex-auto align-items-center justify-content-center lg:col-6 flex-wrap">
                            <div class="flex col-6">
                                <Checkbox v-model="purchaseStatus.completed" inputId="completed" :binary="true"/>
                                <label for="completed" class="ml-2"> Исполнение завершено </label>
                            </div>
                            <div class="flex col-6">
                                <Checkbox v-model="purchaseStatus.inProgress" inputId="inProgress" :binary="true"/>
                                <label for="inProgress" class="ml-2"> Исполнение </label>
                            </div>
                        <div class="flex col-12">
                            <p class="ml-2">ДАТА ОКОНЧАНИЯ ИСПОЛНЕНИЯ КОНТРАКТА</p>
                        </div>
                    </div>
                    <div class="lg:flex flex-auto align-items-center justify-content-center lg:col-6 flex-wrap">
                        <div class="flex col-6">
                            <Checkbox v-model="purchaseStatus.terminated" inputId="terminated" :binary="true"/>
                            <label for="terminated" class="ml-2"> Исполнение прекращено </label>
                        </div>
                        <div class="flex col-6">
                            <Checkbox v-model="purchaseStatus.cancelled" inputId="cancelled" :binary="true"/>
                            <label for="cancelled" class="ml-2"> Аннулирован </label>
                        </div>
                        <div class="flex col-12">
                            <p class="ml-2">ДАТА подписания КОНТРАКТА (необязательно)</p>
                        </div>
                    </div>
                </div>

            </Fieldset>


            <div class="block">
                <label class="block-label">СТАТУС ЗАКУПОК</label>

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
import Fieldset from "primevue/fieldset";

export default {
    components: {Header, Footer, InputText, Button, Checkbox, ToggleButton, Dropdown, InputNumber, Fieldset},
    data() {
        return {
            customer: {name: 'Осипов Пётр Иванович', inn: 89644488, kpp: 213123213},
            calculationOptions: {
                order567: false,
                order450n: true
            },
            contractOptions: {
                fz44: true,
                fz223: false,
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
    },
    methods: {
        handleCheckboxChange(checkbox) {
            if (checkbox === 'order567') {
                this.calculationOptions.order450n = false;
            } else if (checkbox === 'order450n') {
                this.calculationOptions.order567 = false;
            }
        },
        handleContractChange(contractType) {
            if (contractType === 'fz44') {
                this.contractOptions.fz223 = false;
            } else if (contractType === 'fz223') {
                this.contractOptions.fz44 = false;
            }
        }
    }
}
</script>


<style scoped>

Fieldset {
    margin-bottom: 2%;
}
</style>

