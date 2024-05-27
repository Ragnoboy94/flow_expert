<template>
    <Header></Header>
    <section class="landing-block2">
        <div class="content-container p-fluid">
            <div class="title-section">
                <h3>Настройка параметров расчёта НМЦК</h3>
            </div>
            <div class="flex justify-content-end flex-wrap">
                <span class="flex justify-content-end" @click="showCustomerDialog = true">
                    Изменить заказчика
                </span>
            </div>
            <Dialog v-model:visible="showCustomerDialog" header="Изменить заказчика" :modal="true"
                    :dismissableMask="true"
                    :style="{ width: '450px' }">
                <form @submit.prevent="updateCustomerDialog">
                    <div class="p-fluid">
                        <div class="p-field">
                            <label for="name">ФИО</label>
                            <InputText id="name" class="field" v-model="customerForm.name" required/>
                        </div>
                        <div class="p-field">
                            <label for="inn">ИНН</label>
                            <InputText pattern=".{12,}" title="ИНН должен состоять из 12 цифр" v-mask="'############'"
                                       id="inn" class="field" v-model="customerForm.inn" required/>
                        </div>
                        <div class="p-field">
                            <label for="kpp">КПП</label>
                            <InputText pattern=".{9,}" title="КПП должен состоять из 9 цифр" v-mask="'#########'"
                                       id="kpp" class="field" v-model="customerForm.kpp" required/>
                        </div>
                    </div>
                    <Button type="submit" label="Изменить заказчика" class="consultation-button"/>
                </form>
            </Dialog>
            <form @submit.prevent="saveAdditionalData">
            <Fieldset class="bg-green-100 border-round-3xl" legend="ЗАКАЗЧИК">
                <p class="m-0">
                    {{ customer.name }}<br>
                    <span v-if="customer.inn">
                        {{ customer.inn }}
                    </span>
                    <span v-else>
                        ИНН
                    </span>
                    / <span v-if="customer.kpp">
                        {{ customer.kpp }}
                    </span>
                    <span v-else>
                        КПП
                    </span>
                </p>
            </Fieldset>

            <Fieldset class="border-round-3xl" legend="РАСЧЁТ ОСУЩЕСТВЛЯЕТСЯ В СООТВЕТСТВИИ">
                <div class="flex-1 lg:flex lg:flex-row">
                    <div class="flex col-6 ">
                        <Checkbox v-model="customer.order567" inputId="order567" :binary="true"
                                  @change="handleCheckboxChange('order567')"/>
                        <label for="order567" class="ml-2"> Приказ 567 </label>
                    </div>
                    <div class="flex col-6">
                        <Checkbox v-model="customer.order450n" inputId="order450n" :binary="true"
                                  @change="handleCheckboxChange('order450n')"/>
                        <label for="order450n" class="ml-2"> Приказ 450н </label>
                    </div>
                </div>
            </Fieldset>
            <Fieldset class="border-round-3xl" legend="В КАКИХ КОНТРАКТАХ ИСКАТЬ ЦЕНЫ?">
                <div class="flex-1 lg:flex lg:flex-row">
                    <div class="flex col-6 ">
                        <Checkbox v-model="customer.fz44" inputId="fz44" :binary="true"
                                  @change="handleContractChange('fz44')"/>
                        <label for="fz44" class="ml-2"> 44-ФЗ </label>
                    </div>
                    <div class="flex col-6">
                        <Checkbox v-model="customer.fz223" inputId="fz223" :binary="true"
                                  @change="handleContractChange('fz223')"/>
                        <label for="fz223" class="ml-2"> 223-ФЗ </label>
                    </div>
                </div>

                <div v-if="customer.fz44 || customer.fz223"
                     class="flex lg:flex-row border-round-2xl bg-green-100 my-2">
                    <div class="flex col-12">
                        <p class="ml-2">Способ определения исполнителя {{
                                customer.fz44 ? '44-ФЗ' : '223-ФЗ'
                            }}</p>
                    </div>
                </div>

                <div class="flex lg:flex-row">
                    <div class="flex col-12">
                        <Checkbox v-model="customer.eaec" inputId="eaec"
                                  :binary="true"/>
                        <label for="eaec" class="ml-2"> Учитывать контракты с поставкой только из стран ЕАЭС </label>
                    </div>
                </div>
            </Fieldset>
            <Fieldset class="border-round-3xl" legend="СТАТУС ЗАКУПОК">
                <div class="flex lg:flex-row flex-column">
                    <div class="lg:flex flex-auto align-items-center justify-content-center lg:col-6 flex-wrap">
                        <div class="flex lg:col-6 col-12">
                            <Checkbox v-model="customer.completed" inputId="completed" :binary="true"/>
                            <label for="completed" class="ml-2"> Исполнение завершено </label>
                        </div>
                        <div class="flex lg:col-6 col-12">
                            <Checkbox v-model="customer.inProgress" inputId="inProgress" :binary="true"/>
                            <label for="inProgress" class="ml-2"> Исполнение </label>
                        </div>
                        <div class="flex col-12">
                            <p class="ml-2">ДАТА ОКОНЧАНИЯ ИСПОЛНЕНИЯ КОНТРАКТА</p>
                        </div>
                        <div class="flex lg:col-6 col-12">
                            <InputText required class="w-12" v-model="customer.endDate" type="date"/>
                        </div>
                        <div class="flex lg:col-6 col-12">
                            <InputText required class="w-12" v-model="customer.endDate2" type="date"/>
                        </div>
                    </div>
                    <div class="lg:flex flex-auto align-items-center justify-content-center lg:col-6 flex-wrap">
                        <div class="flex lg:col-6 col-12">
                            <Checkbox v-model="customer.terminated" inputId="terminated" :binary="true"/>
                            <label for="terminated" class="ml-2"> Исполнение прекращено </label>
                        </div>
                        <div class="flex lg:col-6 col-12">
                            <Checkbox v-model="customer.cancelled" inputId="cancelled" :binary="true"/>
                            <label for="cancelled" class="ml-2"> Аннулирован </label>
                        </div>
                        <div class="flex col-12">
                            <p class="ml-2">ДАТА подписания КОНТРАКТА (необязательно)</p>
                        </div>
                        <div class="flex lg:col-6 col-12">
                            <InputText class="w-12" v-model="customer.signDate" type="date"/>
                        </div>
                        <div class="flex lg:col-6 col-12">
                            <InputText class="w-12" v-model="customer.signDate2" type="date"/>
                        </div>
                    </div>
                </div>
                <div class="flex lg:flex-row flex-column">
                    <div class="lg:flex flex-auto align-items-center justify-content-center lg:col-12 flex-wrap">
                        <div class="flex col-12">
                            <Dropdown v-model="customer.region_name" editable :options="regions" optionLabel="name"
                                      placeholder="Регион заказчика" class="w-12"/>
                        </div>
                        <div class="flex col-12">
                            <Checkbox v-model="customer.noPenalties1" :binary="true" inputId="noPenalties"/>
                            <label for="noPenalties"> Без штрафов и пеней</label>
                        </div>
                        <div class="flex col-12">
                            <label class="w-12">ИСКЛЮЧИТЬ КОНТРАКТЫ ВЫБРАННЫХ ОРГАНИЗАЦИЙ</label>
                        </div>
                        <div class="flex col-12">
                            <InputText class="w-12" v-model="excludedContracts"
                                       placeholder="Название / Реквизиты / Адрес / Генеральный директор"/>
                        </div>
                    </div>
                </div>

            </Fieldset>

            <Fieldset class="border-round-3xl" legend="НАСТРОЙКА РАСЧЁТА ЦЕН">
                <div class="flex lg:flex-row flex-column">
                    <div class="lg:flex flex-auto align-items-center justify-content-start lg:col-6 flex-wrap">
                        <div class="flex lg:col-6 col-12">
                            <InputSwitch v-model="customer.noPenalties2"
                                         inputId="priceCalculationOptions.noPenalties"/>
                            <label for="priceCalculationOptions.noPenalties" class="ml-2"> Без штрафов и пеней </label>
                        </div>
                    </div>
                    <div class="lg:flex flex-auto align-items-center justify-content-start lg:col-6 flex-wrap">
                        <div class="flex lg:col-6 col-12">
                            <Dropdown class="w-12" v-model="priceCalculationOptions.category" editable
                                      optionLabel="name" :options="categories"
                                      placeholder="Категория товаров"/>
                        </div>
                    </div>
                </div>
                <div class="flex lg:flex-row flex-column">
                    <div class="lg:flex flex-auto align-items-center justify-content-start lg:col-12 flex-wrap">
                        <div class="flex col-12">
                            <Checkbox v-model="customer.noIndexation" :binary="true"
                                      inputId="priceCalculationOptions.noIndexation"/>
                            <label for="priceCalculationOptions.noIndexation"> Не применять индексацию цен для
                                контрактов заключённых ранее 6 месяцев назад</label>
                        </div>
                    </div>
                </div>
                <div class="flex lg:flex-row flex-column">
                    <div class="lg:flex flex-auto align-items-center justify-content-start lg:col-6 flex-wrap">
                        <div class="flex col-12">
                            <p class="ml-2">ПРЕДЕЛЬНОЕ ЗНАЧЕНИЕ КОЭФ. ВАРИАЦИИ</p>
                        </div>
                        <div class="flex lg:col-6 col-12">
                            <InputNumber class="w-12" v-model="customer.variationLimit" mode="decimal"/>
                        </div>
                    </div>
                    <div class="lg:flex flex-auto align-items-center justify-content-start lg:col-6 flex-wrap">
                        <div class="flex col-12">
                            <p class="ml-2">КОЛИЧЕСТВО ЗНАКОВ ПОСЛЕ ЗАПЯТОЙ</p>
                        </div>
                        <div class="flex lg:col-6 col-12">
                            <InputNumber required class="lg:w-auto w-12" v-model="customer.decimalPlaces"
                                         mode="decimal"
                                         showButtons :min="0" :max="15"/>
                        </div>
                    </div>
                </div>
            </Fieldset>

            <Button type="submit" label="ДАЛЕЕ" icon="pi pi-arrow-right" icon-pos="right"/>
            </form>
        </div>
    </section>
    <Footer></Footer>
</template>

<script>
import Header from "./../Header.vue";
import Footer from "./../Footer.vue";
import InputText from 'primevue/inputtext';
import Checkbox from 'primevue/checkbox';
import Dropdown from 'primevue/dropdown';
import InputNumber from 'primevue/inputnumber';
import Fieldset from "primevue/fieldset";
import InputSwitch from "primevue/inputswitch";
import {mapActions, mapState} from "vuex";
import Dialog from "primevue/dialog";

export default {
    components: {Header, Footer, InputText, Checkbox, Dropdown, InputNumber, Fieldset, InputSwitch, Dialog},
    data() {
        return {
            customerForm: { ...this.customer },
            showCustomerDialog: false,
            priceCalculationOptions: {
                category: '',
            },
            categories: [
                {name: 'Категория 1', code: 'cat1'},
                {name: 'Категория 2', code: 'cat2'}
            ],
        };
    },
    methods: {
        ...mapActions('nmck', ['fetchCustomer', 'updateCustomer', 'fetchRegions', 'saveAdditionalData']),
        handleCheckboxChange(checkbox) {
            if (checkbox === 'order567') {
                this.customer.order450n = false;
            } else if (checkbox === 'order450n') {
                this.customer.order567 = false;
            }
        },
        handleContractChange(contractType) {
            if (contractType === 'fz44') {
                this.customer.fz223 = false;
            } else if (contractType === 'fz223') {
                this.customer.fz44 = false;
            }
        },
        async updateCustomerDialog() {
            await this.updateCustomer(this.customerForm);
            this.showCustomerDialog = false;
        },
        async saveAdditionalData() {
            await this.$store.dispatch('nmck/saveAdditionalData');
            this.$router.push('nmck_basis');
        }
    },
    computed: {
        ...mapState('nmck', ['customer', 'regions'])
    },
    created() {
        this.fetchCustomer();
        this.fetchRegions();
    },
    watch: {
        customer(newCustomer) {
            this.customerForm = {...newCustomer};
        }
    },
}
</script>


<style scoped>

Fieldset {
    margin-bottom: 2%;
}
</style>

