<template>
    <Header></Header>
    <section class="landing-block2">
        <div class="content-container" style="max-width: 100%;">
            <div class="title-section">
                <h3>Инструкция</h3>
                <p>В данном разделе вы можете ознакомится с инструкциями к данной платформе</p>
                <p>Все процедуры, осуществляемые на интернет-ресурсе FlowExpert описаны в:</p>
            </div>
            <div class="flex sm:flex-row flex-column">
                <a href="https://base.garant.ru/70353464/" target="_blank">
                    <Button rounded class="mr-2" label="ФЗ-44" icon="pi pi-arrow-right" icon-pos="right"></Button>
                </a>
                <a href="https://base.garant.ru/12188083/" target="_blank">
                    <Button rounded label="ФЗ-222" icon="pi pi-arrow-right" icon-pos="right"></Button>
                </a>
            </div>
            <DataView :value="instructions">
                <template #list="slotProps">
                    <div class="grid grid-nogutter">
                        <div v-for="(item, index) in slotProps.items" :key="index" class="col-12">
                            <div class="flex flex-column sm:flex-row sm:align-items-center p-4 gap-3" :class="{ 'border-top-1 surface-border': index !== 0 }">
                                <div class="flex flex-column md:flex-row justify-content-between md:align-items-center flex-1 gap-4">
                                    <div class="flex flex-row md:flex-column justify-content-between align-items-start gap-2">
                                        <div>
                                            <div class="text-lg font-medium text-900 mt-2">{{ item.name }}</div>
                                        </div>
                                    </div>
                                    <div class="flex flex-column md:align-items-end gap-5">
                                        <router-link :to="'/instruction/' + item.link">
                                            <Button icon="pi pi-arrow-right" icon-pos="right" rounded label="Подробнее"/>
                                        </router-link>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                </template>
            </DataView>
        </div>
    </section>
    <Footer></Footer>
</template>

<script>

import Header from "./Header.vue";
import Footer from "./Footer.vue";
import DataView from "primevue/dataview";

export default {
    components: {Header, Footer, DataView},
    data() {
        return {
            instructions: [
                {
                    name: 'Как заказать консультацию по продукту?',
                    link: 'order_consultation',
                },
                {
                    name: 'Как мне узнать подробнее вашей компании?',
                    link: 'about_company',
                },
                {
                    name: 'Как мне зарегистрироваться на сайте FlowExpert?',
                    link: 'register',
                },
                {
                    name: 'Что делать, если я забыл пароль от своего личного кабинета?',
                    link: 'forgot_password',
                },
                {
                    name: 'Где мне прочитать процедуры, реализуемые на ресурсе, описанные в законодательных актах Российской Федерации?',
                    link: 'procedures',
                },
                {
                    name: 'Как мне привести начальную потребность медицинского учреждения в требуемый вид?',
                    link: 'initial_needs'
                },
                {
                    name: 'Как мне сформировать лоты для отправки на аукцион?',
                    link: 'auction_lots',
                },
                {
                    name: 'Как мне рассчитать НМЦК?',
                    link: 'calculate_nmck',
                },
                {
                    name: 'Как мне внести существующие коммерческие предложения для расчета НМЦК?',
                    link: 'set_comers',
                },
                {
                    name: 'Как мне задать параметры для расчета НМЦК?',
                    link: 'set_parameters_nmck',
                },
                {
                    name: 'Как мне получить обоснование НМЦК?',
                    link: 'get_justification_nmck',
                },
                {
                    name: 'Как посмотреть все мои загруженные файлы?',
                    link: 'view_files',
                },
            ]
        };
    }
}
</script>
<style scoped>
.title-section p {
    font-size: 1.5em;
    color: #333;
    text-indent: 0;
}
</style>
