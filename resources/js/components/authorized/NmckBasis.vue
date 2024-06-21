<template>
    <Header></Header>
    <section class="landing-block2">
        <div class="content-container p-fluid">
            <div class="title-section">
                <h3>Формирование обоснование НМЦК</h3>
                <p>
                    Для того, чтобы перейти к скачиванию обоснования НМЦК необходимо загрузить потребность и
                    коммерческие предложения.
                </p>
                <p v-if="!selectedFile" class="text-green-600">Выберите предложение</p>
            </div>
            <div class="flex flex-column lg:flex-row lg:flex-wrap mt-3">
                <div class="lg:col-8">
                    <div class="flex-1 lg:mr-2 mb-3">
                        <Fieldset class="border-round-3xl border-1 border-green-400" legend="Загруженная потребность">
                            <p class="m-0">
                                <DataTable v-model:selection="selectedFile" :value="files_ready" selectionMode="single"
                                           dataKey="id"
                                           :metaKeySelection="false" @rowSelect="onRowSelect"
                                           @rowUnselect="onRowUnselect"
                                           table-style="border-color: green">
                                    <Column field="filename" header="Имя файла"></Column>
                                    <Column field="created_at" header="Дата загрузки">
                                        <template #body="{ data }">
                                            {{ new Date(data.created_at).toLocaleDateString() }}
                                        </template>
                                    </Column>
                                </DataTable>
                            </p>
                        </Fieldset>
                    </div>
                </div>
                <div class="flex-1 col-12 lg:mr-2 mb-3">
                    <Fieldset class="border-round-3xl border-1 border-green-400" legend="Коммерческое предложение">
                        <p class="m-0">
                            <DataTable v-model:selection="selectedOffers" :value="offers" selectionMode="multiple"
                                       dataKey="id"
                                       :metaKeySelection="false">
                                <Column field="sender" header="Имя файла"></Column>
                                <Column field="created_at" header="Дата загрузки">
                                    <template #body="{ data }">
                                        {{ new Date(data.created_at).toLocaleDateString() }}
                                    </template>
                                </Column>
                            </DataTable>
                        </p>
                    </Fieldset>
                </div>
            </div>
            <div class="flex mb-3 col-12">
                <Checkbox v-model="openSource" :binary="true" inputId="openSource"/>
                <label for="openSource"> Использовать цены из открытых источников</label>
            </div>
            <Button label="Подготовить файл для скачивания" class="consultation-button" @click="prepareFile"
                    :disabled="!selectedFile"/>
            <Toast/>
            <div v-if="loading" class="overlay">
                <ProgressSpinner></ProgressSpinner>
            </div>
        </div>
    </section>
    <Footer></Footer>
</template>

<script>
import Header from "./../Header.vue";
import Footer from "./../Footer.vue";
import DataTable from "primevue/datatable";
import Checkbox from 'primevue/checkbox';
import Column from 'primevue/column';
import InputNumber from "primevue/inputnumber";
import {mapActions, mapState} from "vuex";
import Fieldset from "primevue/fieldset";
import Toast from 'primevue/toast';
import ProgressSpinner from "primevue/progressspinner";

export default {
    components: {Header, Footer, DataTable, Checkbox, Column, InputNumber, Fieldset, Toast, ProgressSpinner},
    data() {
        return {
            selectedFile: null,
            openSource: false,
            selectedOffers: [],
            loading: false
        };
    },
    methods: {
        ...mapActions('upload', ['fetchReadyFiles', 'prepareNMCKFile', 'fetchOffers']),
        onRowSelect(event) {
            this.selectedFile = event.data;
        },
        onRowUnselect(event) {
            this.selectedFile = null;
        },
        async prepareFile() {
            if (!this.selectedFile || this.selectedOffers.length === 0) {
                this.$toast.add({ severity: 'warn', summary: 'Внимание', detail: 'Пожалуйста, выберите файл.' });
                return;
            }
            this.loading = true;

            const requestData = {
                fileId: this.selectedFile.id,
                offerIds: this.selectedOffers.map(offer => offer.id),
                openSource: this.openSource
            };

            try {
                const fileUrl = await this.prepareNMCKFile(requestData);
                if (this.openSource) {
                    this.$toast.add({
                        severity: 'success',
                        summary: 'Успех',
                        detail: 'Файл будет доступен в вашем профиле после обработки.'
                    });
                } else {
                    window.open(fileUrl, '_blank');
                    this.$toast.add({ severity: 'success', summary: 'Успех', detail: 'Файл успешно подготовлен и скачан!' });
                }
            } catch (error) {
                this.$toast.add({ severity: 'error', summary: 'Ошибка', detail: 'Ошибка при подготовке файла.' });
            } finally {
                this.loading = false;
            }
        },
        onCellEditComplete(event) {
            let {data, newValue, field} = event;
            data[field] = newValue;
        }
    },
    computed: {
        ...mapState('upload', ['files_ready', 'offers']),
    },
    created() {
        this.fetchReadyFiles();
        this.fetchOffers();
    }
}
</script>

<style scoped>
Fieldset {
    margin-bottom: 2%;
}
</style>
