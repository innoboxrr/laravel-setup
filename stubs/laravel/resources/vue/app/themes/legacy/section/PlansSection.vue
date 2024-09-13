<template>
    <div v-if="false" class="bg-gray-900 pt-12 pb-32">
      <div class="mx-auto max-w-7xl px-6 lg:px-8">
        <div class="mx-auto max-w-4xl text-center">
          <h2 class="text-base font-semibold leading-7 text-indigo-400">Pricing</h2>
          <p class="mt-2 text-4xl font-bold tracking-tight text-white sm:text-5xl">
            Let's Get You Signed Up
          </p>
        </div>
        <p class="mx-auto mt-6 max-w-2xl text-center text-lg leading-8 text-gray-300">
            It takes less than a minute, and just might be the best decision you'll make all day. But you can always do this later, if you prefer.
        </p>
        <div class="mt-16 flex justify-center">
          <RadioGroup v-model="frequency" class="grid grid-cols-2 gap-x-1 rounded-full bg-white/5 p-1 text-center text-xs font-semibold leading-5 text-white">
            <RadioGroupLabel class="sr-only">Payment frequency</RadioGroupLabel>
            <RadioGroupOption as="template" v-for="option in frequencies" :key="option.value" :value="option" v-slot="{ checked }">
              <div :class="[checked ? 'bg-indigo-500' : '', 'cursor-pointer rounded-full px-2.5 py-1']">
                <span>{{ option.label }}</span>
              </div>
            </RadioGroupOption>
          </RadioGroup>
        </div>
        <div class="isolate mx-auto mt-10 grid max-w-md grid-cols-1 gap-8 lg:mx-0 lg:max-w-none lg:grid-cols-3">
          <div v-for="tier in tiers" :key="tier.id" :class="[tier.mostPopular ? 'bg-white/5 ring-2 ring-indigo-500' : 'ring-1 ring-white/10', 'rounded-3xl p-8 xl:p-10']">
            <div class="flex items-center justify-between gap-x-4">
              <h3 :id="tier.id" class="text-lg font-semibold leading-8 text-white">{{ tier.name }}</h3>
              <p v-if="tier.mostPopular" class="rounded-full bg-indigo-500 px-2.5 py-1 text-xs font-semibold leading-5 text-white">Most popular</p>
            </div>
            <p class="mt-4 text-sm leading-6 text-gray-300">{{ tier.description }}</p>
            <p class="mt-6 flex items-baseline gap-x-1">
              <span class="text-4xl font-bold tracking-tight text-white">{{ tier.price[frequency.value] }}</span>
              <span class="text-sm font-semibold leading-6 text-gray-300">{{ frequency.priceSuffix }}</span>
            </p>
            <a :href="tier.href" :aria-describedby="tier.id" :class="[tier.mostPopular ? 'bg-indigo-500 text-white shadow-sm hover:bg-indigo-400 focus-visible:outline-indigo-500' : 'bg-white/10 text-white hover:bg-white/20 focus-visible:outline-white', 'mt-6 block rounded-md py-2 px-3 text-center text-sm font-semibold leading-6 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2']">Buy plan</a>
            <ul role="list" class="mt-8 space-y-3 text-sm leading-6 text-gray-300 xl:mt-10">
              <li v-for="feature in tier.features" :key="feature" class="flex gap-x-3">
                <CheckIcon class="h-6 w-5 flex-none text-white" aria-hidden="true" />
                {{ feature }}
              </li>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </template>
  
  <script setup>
  import { ref } from 'vue'
  import { RadioGroup, RadioGroupLabel, RadioGroupOption } from '@headlessui/vue'
  import { CheckIcon } from '@heroicons/vue/20/solid'
  
  const frequencies = [
    { value: 'monthly', label: 'Monthly', priceSuffix: '/month' },
    { value: 'annually', label: 'Annually', priceSuffix: '/year' },
  ]
  const tiers = [
  {
    name: 'Individual Learner',
    id: 'tier-individual',
    href: '#',
    price: { monthly: '$19', annually: '$180' },
    description: 'Essential courses and resources for self-paced learning.',
    features: [
      'Access to 10 courses',
      'Up to 100 PDF test downloads',
      'Basic analytics on progress',
      'Email support with 72-hour response time'
    ],
    mostPopular: false,
  },
  {
    name: 'Professional',
    id: 'tier-professional',
    href: '#',
    price: { monthly: '$39', annually: '$372' },
    description: 'Advanced learning tools for professionals expanding their skillset.',
    features: [
      'Access to 50 courses',
      'Unlimited PDF test downloads',
      'Simulation tests',
      '24-hour email and chat support',
      'Monthly webinar access'
    ],
    mostPopular: true,
  },
  {
    name: 'Organization',
    id: 'tier-organization',
    href: '#',
    price: { monthly: '$99', annually: '$948' },
    description: 'Comprehensive training solutions for teams and enterprises.',
    features: [
      'Unlimited course access',
      'Unlimited simulation tests',
      'Advanced progress analytics',
      'Priority support with 1-hour response time',
      'Customizable learning paths',
      'Exclusive live bootcamps'
    ],
    mostPopular: false,
  },
]

  
  const frequency = ref(frequencies[0])
  </script>