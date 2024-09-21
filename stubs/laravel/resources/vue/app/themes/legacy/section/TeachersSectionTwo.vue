<template>
    <div
        v-if="props.display == 'true'" 
        class="bg-gradient-to-br from-slate-900 to-slate-700 py-12">
        <div class="mx-auto max-w-7xl px-6 text-center lg:px-8">
            <div class="mx-auto max-w-4xl">
                <h2 class="text-3xl font-bold tracking-tight text-white sm:text-4xl">
                    {{ props.title }}
                </h2>
                <p class="mt-4 text-lg leading-8 text-gray-400">
                    {{ props.subtitle }}
                </p>
            </div>
            <ul 
                role="list" 
                class="mx-auto mt-20 grid max-w-2xl grid-cols-1 gap-6 sm:grid-cols-2 lg:mx-0 lg:max-w-none lg:grid-cols-3 xl:grid-cols-4 lg:gap-8">
                <li
                    v-for="teacher in teachers"
                    :key="teacher.id"
                    class="rounded-2xl bg-gray-800 px-8 py-10">
                    <router-link
                        :to="{
                            name: 'ProfileUserShow',
                            params: { user_id: teacher.id }
                        }">
                        <img 
                            class="mx-auto h-48 w-48 rounded-full md:h-56 md:w-56"
                            style="object-fit: cover;" 
                            :src="teacher.avatar_url" 
                            alt="" />
                    </router-link>
                    <h3 class="mt-6 text-base font-semibold leading-7 tracking-tight text-white">
                        {{ teacher.name }}
                    </h3>
                    <p class="text-sm leading-6 text-gray-400">
                        {{ teacher.payload.position ?? 'DBCloud Teacher' }}
                    </p>
                    <ul 
                        v-if="false"
                        role="list" 
                        class="mt-6 flex justify-center gap-x-6">
                        <li>
                            <a :href="teacher.links.twitter" class="text-gray-400 hover:text-gray-300">
                                <span class="sr-only">X</span>
                                <svg class="h-5 w-5" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M11.4678 8.77491L17.2961 2H15.915L10.8543 7.88256L6.81232 2H2.15039L8.26263 10.8955L2.15039 18H3.53159L8.87581 11.7878L13.1444 18H17.8063L11.4675 8.77491H11.4678ZM9.57608 10.9738L8.95678 10.0881L4.02925 3.03974H6.15068L10.1273 8.72795L10.7466 9.61374L15.9156 17.0075H13.7942L9.57608 10.9742V10.9738Z" />
                                </svg>
                            </a>
                        </li>
                        <li>
                            <a :href="teacher.links.linkedin" class="text-gray-400 hover:text-gray-300">
                                <span class="sr-only">LinkedIn</span>
                                <svg class="h-5 w-5" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.338 16.338H13.67V12.16c0-.995-.017-2.277-1.387-2.277-1.39 0-1.601 1.086-1.601 2.207v4.248H8.014v-8.59h2.559v1.174h.037c.356-.675 1.227-1.387 2.526-1.387 2.703 0 3.203 1.778 3.203 4.092v4.711zM5.005 6.575a1.548 1.548 0 11-.003-3.096 1.548 1.548 0 01.003 3.096zm-1.337 9.763H6.34v-8.59H3.667v8.59zM17.668 1H2.328C1.595 1 1 1.581 1 2.298v15.403C1 18.418 1.595 19 2.328 19h15.34c.734 0 1.332-.582 1.332-1.299V2.298C19 1.581 18.402 1 17.668 1z" clip-rule="evenodd" />
                                </svg>
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</template>
<script>
    import { indexModel as indexUserModel } from '@models/user';
    export default {
        props: {
            props: {
                type: Object,
                default: () => ({}),
            }
        },
        data() {
            return {
                teachers: [],
            }
        },
        mounted() {
            this.fetchData();
        },
        methods: {
            async fetchData() {
                await this.fetchHeadTeachers();
            },
            async fetchHeadTeachers() {
                this.teachers = await indexUserModel({
                    paginate: 0,
                    visibility: 'public',
                    head_teacher: 1,
                });
            }
        }
    }
</script>