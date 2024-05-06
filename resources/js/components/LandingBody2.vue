<template>
    <section class="landing-block2">
        <h2 class="activity-spheres__title">Сферы деятельности и их преимущества</h2>
        <div class="p-grid">
            <div class="p-col-12 p-md-6 p-lg-3" v-for="(sphere, index) in spheres" :key="index">
                <Card class="card-landing2">
                    <template #title>
                        <img :src="sphere.image" :alt="sphere.alt" class="activity-image"/>
                    </template>
                    <template #content>
                        <span class="card-title">{{ sphere.title }}</span>
                    </template>
                    <template #footer>
                        <Button label="Подробнее →" class="p-button-outlined p-button-rounded"
                                @click="openDialog(index)"/>
                    </template>
                </Card>
                <Dialog v-model:visible="dialogVisible[index]" :style="{ width: '50vw' }" :modal="true"
                        :dismissableMask="true">
                    <template #header>
                        <h3>{{ sphere.title }}</h3>
                    </template>
                    <div class="dialog-container">
                        <Card class="specialized-card">
                            <template #title>
                                <h4 style="color:green">Специализированные решения</h4>
                            </template>
                            <template #content>
                                <ul>
                                    <li v-for="solution in sphere.specializedSolutions" :key="solution">
                                        <i class="pi pi-check-circle icon-green"></i>
                                        {{ solution }}
                                    </li>
                                </ul>
                            </template>
                        </Card>
                        <Card class="advantages-card no-border">
                            <template #title>
                                <h4 style="color:green">Преимущества для заказчика</h4>
                            </template>
                            <template #content>
                                <ul>
                                    <li v-for="advantage in sphere.advantages" :key="advantage">
                                        <i class="pi pi-chevron-circle-right icon-grey"></i>
                                        {{ advantage }}
                                    </li>
                                </ul>
                                {{ sphere.add }}
                            </template>
                            <template #footer>
                                <ConsultationButton/>
                            </template>
                        </Card>
                    </div>

                </Dialog>
            </div>
        </div>
    </section>
</template>

<script>
import Card from "primevue/card";
import Dialog from "primevue/dialog";
import ConsultationButton from "./buttons/ConsultationButton.vue";

export default {
    name: 'LandingBody2',
    components: {
        Card,
        Dialog,
        ConsultationButton
    },
    data() {
        return {
            spheres: [
                {
                    title: 'Частные клиники',
                    alt: 'Частные клиники',
                    image: 'images/private-clinics-image.webp',
                    imageSrc: '',
                    specializedSolutions: [
                        'Загрузка данных из учетной системы заказчика',
                        'Приведение номенклатуры к единым наименованиям в привязке к МНН',
                        'Формирование модулей для работы с заказом: модуль исторических данных с информацией о закупках и расходовании в разрезе отделений, модуль новой заявки с возможностью редактирования количества в разрезе отделений',
                        'Модуль формирования заявок по группе позиций (разделение технических заданий по типу)',
                        'Автоматическое размещение запросов на получение коммерческих предложений для формирования МЦК',
                        'Формирование структурированной заявки для технического задания',
                    ],
                    advantages: [
                        'Возможность контроля закупочных цен',
                        'Автоматизация закупок за счет цифрового контура «заявка-закупка-отгрузка» с полностью электронным документооборотом',
                        'Возможность интеграции складского учета между МИС и бухгалтерской учетной системой',
                    ],
                    add: ''
                },
                {
                    title: 'Государственные учреждения здравоохранения',
                    alt: 'Государственные учреждения',
                    image: 'images/government-institutions-image.webp',
                    imageSrc: '',
                    specializedSolutions: [
                        'Загрузка данных из учетной системы заказчика',
                        'Приведение номенклатуры к единым наименованиям в привязке к МНН',
                        'Формирование модулей для работы с заказом: модуль исторических данных с информацией о закупках и расходовании в разрезе отделений, модуль новой заявки с возможностью редактирования количества в разрезе отделений',
                        'Модуль формирования заявок по группе позиций (разделение технических заданий по типу)',
                        'Автоматическое размещение запросов на получение коммерческих предложений для формирования МЦК',
                        'Формирование структурированной заявки для технического задания',
                    ],
                    advantages: [
                        'Снижение сроков обработки исторических данных на 80%',
                        'Разделение ролей по уровням доступа для отделений/аптеки/управленческих ролей',
                        'Возможность внесения ограничений бюджета заявки на уровне отделений',
                        'Консолидация общей заявки для медицинского учреждения',
                        'Формирование раздельных технических заданий на закупку',
                        'Автоматизированный запрос коммерческих предложений',
                    ],
                    add: ''
                },
                {
                    title: 'Аптечные сети федерального уровня',
                    alt: 'Аптечные сети',
                    image: 'images/pharmacy-networks-image.webp',
                    imageSrc: '',
                    specializedSolutions: [
                        'Загрузка данных из учетной системы заказчика;',
                        'Приведение номенклатуры к единым наименованиям в привязке к МНН;',
                        'Формирование модулей для работы с заказом: модуль исторических данных с информацией о закупках и расходовании в разрезе отделений, модуль новой заявки с возможностью редактирования количества в разрезе отделений;',
                        'Модуль формирования заявок по группе позиций (разделение технических заданий по типу);',
                        'Автоматическое размещение запросов на получение коммерческих предложений для формирования МЦК;',
                        'Формирование структурированной заявки для технического задания.',
                    ],
                    advantages: [
                        'Автоматизация процесса формирования технических заданий для консолидированных закупок',
                        'Получение структурированных данных для анализа региональной потребности в лекарственных препаратах на уровне учреждений и на уровне льготного обеспечения',
                    ],
                    add: 'Для подробной консультации заполните форму обратной связи и наш специалист свяжется с вами в ближайшее время.'
                },
                {
                    title: 'Региональные министерства',
                    alt: 'Региональные министерства',
                    image: 'images/regional-ministries-image.webp',
                    specializedSolutions: [
                        'Загрузка данных заявок подведомственных учреждений',
                        'Консолидация заявок в разрезе номенклатуры и количества',
                        'Формирование единого структурированного технического задания',
                        'Формирование модулей для работы с заказом: модуль исторических данных с информацией о закупках и расходовании в разрезе отделений, модуль новой заявки с возможностью редактирования количества в разрезе отделений',
                        'Модуль формирования заявок по группе позиций (разделение технических заданий по типу)',
                        'Автоматическое размещение запросов на получение коммерческих предложений для формирования МЦК',
                        'Формирование структурированной заявки для технического задания',
                    ],
                    advantages: [
                        'Автоматизация процесса формирования технических заданий для консолидированных закупок',
                        'Получение структурированных данных для анализа региональной потребности в лекарственных препаратах на уровне учреждений и на уровне льготного обеспечения',
                    ],
                    add: ''
                }
            ],
            dialogVisible: [false, false, false, false],
            selectedSphere: null
        };
    },
    methods: {
        openDialog(index) {
            this.selectedSphere = this.spheres[index];
            this.dialogVisible[index] = true;
        }
    }
};
</script>

<style scoped>
.activity-spheres__title {
    text-align: center;
    margin-bottom: 2rem;
}

.p-grid {
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
    gap: 2rem;
}

.p-col-12.p-md-6.p-lg-3 {
    flex: 1;
    max-width: 350px;
    display: flex;
    flex-direction: column;
}

.card-title {
    display: block;
    text-align: center;
    min-height: 40px;
}


.card-landing2 {
    min-height: 300px;
    height: 100%;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    border: 2px solid #00A950;
    padding: 1rem;
    box-shadow: 0 4px 8px rgba(0, 169, 80, 0.2);
}

.activity-image {
    width: 100%;
    height: 200px;
    object-fit: cover;
    border-radius: 10%;
}

.p-button-outlined {
    width: 100%;
    margin-top: auto;
    background-color: #00A950;
    border: 2px solid #00A950;
    color: white;
}

.dialog-container {
    display: flex;
    flex-direction: row;
    justify-content: space-between;
}


.specialized-card {
    flex: 1;
    margin-right: 2rem;
    border: 2px solid #00A950;
    box-shadow: 0 4px 8px rgba(0, 169, 80, 0.2);
    border-radius: 16px;
}


.advantages-card.no-border {
    flex: 1;
    box-shadow: none;
    border: none;
    padding: 1rem;
}


.no-border .p-card-content {
    border: none;
}


.specialized-card ul, .advantages-card ul {
    list-style-type: none;
    padding: 0;
    margin: 0;
}

.specialized-card li, .advantages-card li {
    margin-bottom: 0.5rem;
    padding: 0.5rem 0;
}


.no-border .p-card-content {
    padding: 0;
}

.icon-green {
    color: #00A950;
    margin-right: 0.5rem;
}

.icon-grey {
    color: #555;
    margin-right: 0.5rem;
}


.specialized-list li, .advantages-list li {
    display: flex;
    align-items: center;
    margin-bottom: 0.5rem;
}

</style>

