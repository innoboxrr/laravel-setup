<template>
    <div v-if="display" class="bg-gray-900 py-12" ref="statsContainer">
        <div class="mx-auto max-w-7xl px-6 lg:px-8">
            <div class="mx-auto max-w-2xl lg:max-w-none">
                <div class="text-center">
                    <h2 class="text-3xl font-bold tracking-tight text-white sm:text-4xl">
                        {{ title }}
                    </h2>
                    <p class="mt-4 text-lg leading-8 text-gray-300">
                        {{ message }}
                    </p>
                </div>
                <dl class="mt-16 grid grid-cols-1 gap-0.5 overflow-hidden rounded-2xl text-center sm:grid-cols-2 lg:grid-cols-4">
                    <div v-for="stat in filteredStats" :key="stat.text" class="flex flex-col bg-white/5 p-8">
                        <dt class="text-sm font-semibold leading-6 text-gray-300">
                            {{ stat.text }}
                        </dt>
                        <dd class="order-first text-3xl font-semibold tracking-tight text-white">
                            {{ displayedNumber(stat) }}
                        </dd>
                    </div>
                </dl>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        // Asegúrate de que los props están correctamente definidos
        props: {
            type: Object,
            default: () => ({}),
        },
    },
    data() {
        return {
            display: false,
            title: '',
            message: '',
            stats: {},
            displayedNumbers: {},
        };
    },
    computed: {
        filteredStats() {
            // Mapea solo los valores que deseas mostrar
            return [
                { text: this.__('Courses'), number: this.stats.courses || 0 },
                { text: this.__('Students'), number: this.stats.students || 0 },
                { text: this.__('Teachers'), number: this.stats.teachers || 0 },
                { text: this.__('Reviews'), number: this.stats.reviews || 0 },
            ];
        },
    },
    async mounted() {
        try {
            await this.fetchStats(); // Asegúrate de obtener los datos antes de iniciar el observador

            this.title = this.props.title;
            this.message = this.props.message;
            this.display = true;

            this.$nextTick(() => { // Usa $nextTick para asegurar que el DOM está actualizado
                const options = {
                    root: null,
                    rootMargin: "0px",
                    threshold: 0.5,
                };

                if (this.$refs.statsContainer) { // Verifica que el ref esté disponible
                    const observer = new IntersectionObserver((entries) => {
                        if (entries[0].isIntersecting) {
                            this.filteredStats.forEach((stat) => {
                                this.animateNumber(stat);
                            });
                            observer.unobserve(this.$refs.statsContainer);
                        }
                    }, options);

                    observer.observe(this.$refs.statsContainer);
                }
            });

        } catch (error) {
            console.error("Error fetching stats:", error);
        }
    },
    methods: {
        async fetchStats() {
            try {
                const response = await this.$httpRequest('GET', route('quick.stats'));
                this.stats = response;
            } catch (error) {
                console.error("Error fetching stats:", error);
            }
        },
        displayedNumber(stat) {
            const displayed = this.displayedNumbers[stat.text] || 0;
            return typeof displayed === "number" ? Number(displayed.toFixed(0)) : displayed;
        },
        animateNumber(stat) {
            let currentNumber = this.displayedNumbers[stat.text] || 0;
            const targetNumber = stat.number;
            const increment = targetNumber / 50;
            const interval = setInterval(() => {
                currentNumber += increment;
                this.displayedNumbers[stat.text] = currentNumber;
                if (currentNumber >= targetNumber) {
                    this.displayedNumbers[stat.text] = targetNumber;
                    clearInterval(interval);
                }
            }, 50);
        },
    },
};
</script>
