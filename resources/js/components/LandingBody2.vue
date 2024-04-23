<template>
    <section class="landing-block2">
        <h2 class="activity-spheres__title">Сферы деятельности и их преимущества</h2>
        <div class="p-grid">
            <div class="p-col-12 p-md-6 p-lg-3" v-for="(sphere, index) in spheres" :key="index">
                <Card class="card-landing2">
                    <template #title>
                        <span class="card-title">{{ sphere.title }}</span>
                    </template>
                    <template #content>
                        <img :src="sphere.image" :alt="sphere.alt" class="activity-image"/>
                        <p>{{ sphere.description }}</p>
                    </template>
                    <template #footer>
                        <Button label="Подробнее →" class="p-button-outlined p-button-rounded"
                                @click="openDialog(index)"/>
                    </template>
                </Card>
                <Dialog v-model:visible="dialogVisible[index]" :style="{ width: '50vw' }" :closable="true"
                        :modal="true">
                    <template #header>
                        <h3>{{ sphere.title }}</h3>
                    </template>
                </Dialog>
            </div>
        </div>
    </section>

</template>

<script>
import Card from "primevue/card";
import Button from "primevue/button";
import Dialog from "primevue/dialog";

export default {
    name: 'LandingBody2',
    components: {
        Card,
        Button,
        Dialog
    },
    data() {
        return {
            spheres: [
                {
                    title: 'Частные клиники',
                    subtitle: '',
                    description: 'Описание частных клиник',
                    alt: 'Частные клиники',
                    image: 'path-to-private-clinics-image.jpg'
                },
                {
                    title: 'Государственные учреждения',
                    subtitle: '',
                    description: 'Описание государственных учреждений',
                    alt: 'Государственные учреждения',
                    image: 'path-to-government-institutions-image.jpg'
                },
                {
                    title: 'Аптечные сети федерального уровня',
                    subtitle: '',
                    description: 'Описание аптечных сетей',
                    alt: 'Аптечные сети',
                    image: 'path-to-pharmacy-networks-image.jpg'
                },
                {
                    title: 'Региональные министерства',
                    subtitle: '',
                    description: 'Описание региональных министерств',
                    alt: 'Региональные министерства',
                    image: 'path-to-regional-ministries-image.jpg'
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
    max-width: 300px;
    display: flex;
    flex-direction: column;
}

.card-title {
    text-align: center;
    margin-bottom: 1rem;
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
    margin-bottom: 1rem;
}

.p-button-outlined {
    width: 100%;
    margin-top: auto;
    background-color: #00A950;
    border: 2px solid #00A950;
    color: white;
}

</style>
