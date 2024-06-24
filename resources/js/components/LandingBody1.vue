<template>
    <section class="landing-block flex lg:flex-column flex-row lg:flex-wrap">
        <div class="content-container lg:flex align-items-center justify-content-center">
            <div class="flex-1 font-medium col-12 mr-3 lg:text-left text-center">
                <b><span class="title lg:ml-8 -ml-8">Flow<br><span class="lg:p-8 ml-8">Expert</span></span></b>
                <p class="subtitle">
                    Интеллектуальная система управления заказами лекарственных препаратов и
                    расходных материалов для медицины
                </p>
                <ConsultationButton/>
            </div>
            <div class="flex-1 col-12">
                <img class="w-full" src="../../pics/landing_image1.webp" alt="Doctor"/>
            </div>
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
    font-size: 10vmin;
}

.subtitle {
    margin-bottom: 2rem;
}

.image-container img {
    width: auto;
    height: auto;
    max-width: 100%;
    max-height: 100%;
}
</style>
