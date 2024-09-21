<template>
    <div v-if="props.display" class="bg-gray-900 py-12" ref="statsContainer">
        <div class="mx-auto max-w-7xl px-6 lg:px-8">
            <div class="mx-auto max-w-2xl lg:max-w-none">
                <div class="text-center">
                    <h2
                        class="text-3xl font-bold tracking-tight text-white sm:text-4xl"
                    >
                        {{ props.title }}
                    </h2>
                    <p class="mt-4 text-lg leading-8 text-gray-300">
                        {{ props.message }}
                    </p>
                </div>
                <dl
                    class="mt-16 grid grid-cols-1 gap-0.5 overflow-hidden rounded-2xl text-center sm:grid-cols-2 lg:grid-cols-4"
                >
                    <div
                        v-for="stat in props.items"
                        :key="stat.text"
                        class="flex flex-col bg-white/5 p-8"
                    >
                        <dt
                            class="text-sm font-semibold leading-6 text-gray-300"
                        >
                            {{ stat.text }}
                        </dt>
                        <dd
                            class="order-first text-3xl font-semibold tracking-tight text-white"
                        >
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
        props: {
            type: Object,
            default: () => ({}),
        },
    },
    data() {
        return {
            displayedNumbers: {},
        };
    },
    mounted() {
        const options = {
            root: null,
            rootMargin: "0px",
            threshold: 0.5,
        };

        const observer = new IntersectionObserver((entries) => {
            if (entries[0].isIntersecting) {
                this.props.items.forEach((stat) => {
                    this.animateNumber(stat);
                });
                observer.unobserve(this.$refs.statsContainer);
            }
        }, options);

        observer.observe(this.$refs.statsContainer);
    },
    methods: {
        displayedNumber(stat) {
            const displayed = this.displayedNumbers[stat.text] || 0;
            if (typeof displayed === "number") {
                return Number(displayed.toFixed(0));
            } else {
                return displayed;
            }
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
