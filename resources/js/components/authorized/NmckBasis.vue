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
                                <DataTable v-model:selection="selectedFile" :value="files" selectionMode="single"
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

export default {
    components: {Header, Footer, DataTable, Checkbox, Column, InputNumber, Fieldset},
    data() {
        return {
            selectedFile: null,
            openSource: false,
            selectedOffers: [],
        };
    },
    methods: {
        ...mapActions('upload', ['fetchFiles', 'prepareNMCKFile', 'fetchOffers']),
        onRowSelect(event) {
            this.selectedFile = event.data;
        },
        onRowUnselect(event) {
            this.selectedFile = null;
        },
        async prepareFile() {
            if (!this.selectedFile) {
                alert('Пожалуйста, выберите файл.');
                return;
            }

            const requestData = {
                fileId: this.selectedFile.id,
                offerIds: this.selectedOffers.map(offer => offer.id),
                openSource: this.openSource
            };

            try {
                const fileUrl = await this.prepareNMCKFile(requestData);
                window.open(fileUrl, '_blank');
            } catch (error) {
                console.error('Ошибка при подготовке файла:', error);
            }
        },
        onCellEditComplete(event) {
            let {data, newValue, field} = event;
            data[field] = newValue;
        }
    },
    computed: {
        ...mapState('upload', ['files', 'offers']),
    },
    created() {
        this.fetchFiles();
        this.fetchOffers();
    }
}
</script>

<style scoped>
Fieldset {
    margin-bottom: 2%;
}
</style>
