<template>
    <Header></Header>
    <section class="landing-block2">
        <div class="content-container" style="max-width: 100%;">
            <div class="title-section">
                <h3>Формирование коммерческих предложений</h3>
            </div>
            <form @submit.prevent="submitOfferForm">
                <div class="flex flex-column lg:flex-row">
                    <div class="flex mt-3 lg:col-3">
                        <FloatLabel class="w-12">
                            <InputText class="field" v-model="formData.sender" required/>
                            <label for="formData.sender">От кого предложение</label>
                        </FloatLabel>
                    </div>
                    <div class="flex mt-3 lg:col-3">
                        <FloatLabel class="w-12">
                            <InputText type="date" class="field" v-model="formData.date" required/>
                            <label for="formData.date">Дата</label>
                        </FloatLabel>
                    </div>
                    <div class="flex mt-3 lg:col-3">
                        <FloatLabel class="w-12">
                            <InputText v-mask="'#########'" class="field" v-model="formData.positions" required/>
                            <label class="mb-1" for="formData.positions">Сколько позиций</label>
                        </FloatLabel>
                    </div>
                    <div class="flex lg:col-3" style="margin-top: 0.9rem; margin-bottom: 0.4rem;">
                        <Button label="Выбрать файл" @click="triggerFileInput"
                                class="consultation-button text-green-500 bg-white border-green-500 border-1"
                                icon="pi pi-file" iconPos="right"/>
                        <input type="file" ref="fileInput" @change="handleFileUpload" accept=".pdf"
                               style="display: none;"/>
                    </div>
                </div>
            </form>
            <Accordion v-if="offers.length">
                <AccordionTab v-for="offer in offers" :header="'Предложение от ' + offer.sender" :key="offer.id">
                    <div v-if="offer.file_status_id === 3 && offerRows[offer.id]?.length">
                        <DataTable v-model:editingRows="editingRows[offer.id]" :value="offerRows[offer.id]" editMode="row"
                                   class="editable-cells-table" @row-edit-save="onRowEditSave">
                            <Column field="mnn" header="Международное не патентованное наименование" editor="true" style="width: 15%">
                                <template #editor="{ data, field }">
                                    <InputText v-model="data[field]" />
                                </template>
                            </Column>
                            <Column field="name" header="Торговое наименование" editor="true" style="width: 15%">
                                <template #editor="{ data, field }">
                                    <InputText v-model="data[field]" />
                                </template>
                            </Column>
                            <Column field="trade_name" header="Форма выпуска" editor="true" style="width: 30%">
                                <template #editor="{ data, field }">
                                    <Textarea autoResize v-model="data[field]" />
                                </template>
                            </Column>
                            <Column field="quantity" header="Кол-во" editor="true" style="width: 10%">
                                <template #editor="{ data, field }">
                                    <InputText class="w-12" v-model="data[field]" />
                                </template>
                            </Column>
                            <Column field="price" header="Цена (без ндс и оптовой надбавки)" editor="true" style="width: 10%">
                                <template #editor="{ data, field }">
                                    <InputText class="w-12" v-model="data[field]" />
                                </template>
                            </Column>
                            <Column field="total" header="Цена (без ндс и оптовой надбавки)" editor="true" style="width: 10%">
                                <template #editor="{ data, field }">
                                    <InputText class="w-12" v-model="data[field]" />
                                </template>
                            </Column>
                            <Column :rowEditor="true" style="width: 10%; min-width: 8rem" bodyStyle="text-align:center"></Column>
                        </DataTable>
                    </div>
                    <div v-else>
                        Коммерческое предложение обрабатывается...
                    </div>
                </AccordionTab>
            </Accordion>
        </div>
    </section>
    <Footer></Footer>
</template>

<script>
import Header from "./../Header.vue";
import Footer from "./../Footer.vue";
import { mapActions, mapState } from "vuex";
import DataTable from "primevue/datatable";
import Column from "primevue/column";
import InputText from "primevue/inputtext";
import FloatLabel from "primevue/floatlabel";
import Textarea from 'primevue/textarea';
import Accordion from 'primevue/accordion';
import AccordionTab from 'primevue/accordiontab';

export default {
    components: { Header, Footer, DataTable, Column, InputText, FloatLabel, Textarea, Accordion, AccordionTab },
    data() {
        return {
            formData: {
                sender: '',
                date: ' ',
                positions: ''
            },
            selectedFile: null,
            editingRows: {}
        };
    },
    computed: {
        ...mapState('upload', ['offers', 'offerRows']),
    },
    methods: {
        ...mapActions('upload', ['uploadOfferFile', 'fetchOffers', 'updateMedicineRow']),
        handleFileUpload(event) {
            this.selectedFile = event.target.files[0];
            if (this.selectedFile) {
                this.submitOfferForm();
            }
        },
        triggerFileInput() {
            this.$refs.fileInput.click();
        },
        async submitOfferForm() {
            if (this.formData.sender && this.formData.date && this.formData.positions && this.selectedFile) {
                const formData = new FormData();
                formData.append('sender', this.formData.sender);
                formData.append('date', this.formData.date);
                formData.append('positions', this.formData.positions);
                formData.append('file', this.selectedFile);

                await this.uploadOfferFile(formData);

                this.formData.sender = '';
                this.formData.date = ' ';
                this.formData.positions = '';
                this.selectedFile = null;
                this.$refs.fileInput.value = '';
                this.fetchOffers();
            } else {
                alert('Пожалуйста, заполните все поля формы и выберите файл.');
            }
        },
        onRowEditSave(event) {
            let { newData } = event;
            this.updateMedicineRow(newData);
        },
    },
    created() {
        this.fetchOffers();
    },
}
</script>


<style scoped>
.title-section p {
    font-size: 1.5em;
    color: #333;
}

.files-table table {
    width: 100%;
    border-collapse: collapse;
}

.files-table th, .files-table td {
    border: 1px solid #ccc;
    padding: 8px;
    text-align: left;
}

label {
    margin-left: 1.2rem;
    margin-top: -0.7rem;
}
</style>
