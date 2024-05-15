<template>
    <Header></Header>
    <section class="landing-block2">
        <div class="content-container" style="max-width: 100%;">
            <div class="title-section">
                <h3>Формирование коммерческих предложений</h3>
                <p v-if="!offers.length || offers[0].file_status_id === 4"><small
                    v-if="offers.length && offers[0].file_status_id === 4" class="text-red-500">Ошибка в обработке файла<br></small>Укажите
                    данные</p>
                <p v-else-if="offers.length && offers[0].file_status_id === 3">Сформированное коммерческое предложение</p>
                <p v-else>Статус: {{ offers[0].file_status_name }}</p>
            </div>
            <form v-if="!offers.length || offers[0].file_status_id === 4" @submit.prevent="submitOfferForm">
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
                            <InputText v-mask="'#########'" class="field" v-model="formData.positions"
                                       required/>
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
            <div v-if="offers.length && (offers[0].file_status_id === 1 || offers[0].file_status_id === 2)">
                <Card class="flex-1 mt-3 lg:flex-row lg:col-6">
                    <template #content>
                        <span class="flex-1 lg:col-5 pi pi-file-pdf feature-icon"> {{ offers[0].sender }} </span>
                        <a :href="'/offers/' + offers[0].file_path" class="w-12  text-white" download>
                            <Button class="consultation-button flex-1 lg:col-5"
                                    id="download_offer_file" label="Скачать"/>
                        </a>
                    </template>
                </Card>
            </div>
        </div>
    </section>
    <Footer></Footer>
</template>

<script>
import Header from "./../Header.vue";
import Footer from "./../Footer.vue";
import {mapActions, mapState} from "vuex";
import DataTable from "primevue/datatable";
import Column from "primevue/column";
import Button from "primevue/button";
import InputText from "primevue/inputtext";
import FloatLabel from "primevue/floatlabel";
import Card from "primevue/card";

export default {
    components: {Header, Footer, DataTable, Column, Button, InputText, FloatLabel, Card},
    data() {
        return {
            formData: {
                sender: '',
                date: ' ',
                positions: ''
            },
            selectedFile: null
        };
    },
    computed: {
        ...mapState('upload', ['uploadStatus', 'offers']),
    },
    methods: {
        ...mapActions('upload', ['uploadOfferFile', 'fetchOffers']),
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
        }
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
