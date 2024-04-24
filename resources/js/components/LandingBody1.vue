<template>
    <section class="landing-block flex flex-column lg:flex-row">
        <div class="content-container">
            <h1 class="title">Flow<br><span style="margin-left:5rem;">Expert</span></h1>
            <p class="subtitle">
                    Интеллектуальная система управления заказами лекарственных препаратов и
                    расходных материалов для медицины
                </p>
            <ConsultationButton/>
        </div>
        <div class="flex image-container">
            <img src="../../pics/landing_image1.webp" alt="Doctor"/>
        </div>
    </section>
</template>

<script>
import ConsultationButton from './buttons/ConsultationButton.vue'

export default {
    name: 'LandingBody1',
    components: {
        ConsultationButton
    }
}
</script>

<style scoped>

.title {
    font-size: 5.5rem;
}

.subtitle {
    font-size: 1rem;
    margin-bottom: 2rem;
}.image-container{
     margin-left: 10%;
     margin-right: 10%;
 }

.image-container img {
    width: auto;
    height: auto;
    max-width: 110%;
    max-height: 100%;
}
</style>
