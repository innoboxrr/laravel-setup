<template>
    <div>
        <div v-if="!$store.getters['authPages/isAuth']">
            <!-- Content to display when the user is not authenticated -->
            <div class="px-4 lg:pt-24 pt-8 pb-72 lg:pb-80 mx-auto max-w-screen-sm text-center lg:px-6">
                <h2 class="mb-4 text-4xl tracking-tight font-extrabold text-gray-500 mb-8">
                    {{ __('Join Our Community') }}
                </h2>
                <p class="mb-16 font-light text-gray-400 sm:text-2xl">
                    {{ __('Become a part of our community. Sign up now to access exclusive content, create courses, and engage with learners around the world. Start your journey with us today!') }}
                </p>
                <button 
                    @click="$router.push('/auth/login?redirect=/join')"
                    class="py-3 px-6 text-base font-medium text-center text-white rounded-lg bg-primary-700 hover:bg-primary-800 focus:ring-4 focus:outline-none focus:ring-primary-300 dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800">
                    {{ __('Sign Up to Continue') }}
                </button>
            </div>
        </div>
        <section v-else class="bg-white dark:bg-gray-900">
            <div class="bg-[url('https://flowbite.s3.amazonaws.com/blocks/marketing-ui/contact/laptop-human.jpg')] bg-no-repeat bg-cover bg-center bg-gray-700 bg-blend-multiply">
                <div class="px-4 lg:pt-24 pt-8 pb-72 lg:pb-80 mx-auto max-w-screen-sm text-center lg:px-6 ">
                    <h2 class="mb-4 text-4xl tracking-tight font-extrabold text-white">
                        {{ __('Join Our Teaching Team') }}
                    </h2>
                    <p class="mb-16 font-light text-gray-400 sm:text-xl">
                        {{ __('Share your knowledge and inspire the next generation of learners by becoming a part of our teaching community.') }}
                    </p>
                </div>
            </div>
            <div class="py-16 px-4 mx-auto -mt-96 max-w-screen-xl sm:py-24 lg:px-6 ">
                <form 
                    v-if="showForm"
                    @submit.prevent="handleSubmit"
                    action="#" 
                    class="grid grid-cols-1 gap-8 p-6 mx-auto mb-16 max-w-screen-md bg-white rounded-lg border border-gray-200 shadow-sm lg:mb-28 dark:bg-gray-800 dark:border-gray-700 sm:grid-cols-2">
                    
                    <div>
                        <label 
                            for="first-name" 
                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300">
                            First Name
                        </label>
                        <input 
                            type="text" 
                            id="first-name" 
                            class="block p-3 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 shadow-sm focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500 dark:shadow-sm-light" 
                            placeholder="Bonnie"
                            v-model="form.firstname" 
                            required />
                    </div>

                    <div>
                        <label 
                            for="last-name" 
                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300">
                            Last Name
                        </label>
                        <input 
                            type="text" 
                            id="last-name" 
                            class="block p-3 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 shadow-sm focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500 dark:shadow-sm-light" 
                            placeholder="Green"
                            v-model="form.lastname" />
                    </div>

                    <div>
                        <label 
                            for="email" 
                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300">
                            Your email
                        </label>
                        <input 
                            type="email" 
                            id="email" 
                            class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500 dark:shadow-sm-light" 
                            placeholder="name@mymail.com" 
                            v-model="form.email" />
                    </div>

                    <div>
                        <div>
                        <country-select-input-component 
                            label="Phone"
                            class="uk-margin-remove"
                            container-class="w-full"
                            :dropdown-options="{
                                disabled: false,
                                showDialCodeInList: true,
                                showDialCodeInSelection: false,
                                showFlags:true,
                                showSearchBox: true,
                                tabindex: 0,
                                width: '100%'
                            }"
                            :input-options="{
                                autocomplete: 'on',
                                autofocus: false,
                                aria: '',
                                id: '',
                                maxlength: 12,
                                name: 'telephone',
                                showDialCode: false,
                                placeholder: 'Ingresa un número telefónico',
                                readonly: false,
                                required: false,
                                tabindex: 0,
                                type:  'tel',
                                styleClasses: 'block p-3 text-sm text-gray-900 bg-gray-50 rounded-r-lg border border-gray-300 shadow-sm focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500 dark:shadow-sm-light w-full' ,
                            }"
                            @change="setPhone"/>
                    </div>
                    </div>

                    <div class="sm:col-span-2">
                        <label 
                            for="message" 
                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-400">
                            Your message
                        </label>
                        <textarea 
                            id="message" 
                            rows="6" 
                            class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg shadow-sm border border-gray-300 focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" 
                            placeholder="Leave a comment..."
                            v-model="form.notes"></textarea>
                    </div>

                    <div class="sm:col-span-2">
                        <label 
                            for="attachment" 
                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-400">
                            CV
                        </label>
                        <file-drop-input-component
                            :key="fileDropDemoKey"
                            :main-text="__('Drop your file here')"
                            :sub-text="__('Formats: .pdf')"
                            @change="handleFileUpload($event)"
                        />
                        <div class="preview">
                            <div v-if="previewAttachmentFile != undefined" class="flex items-center p-4 mb-4 text-sm rounded-lg bg-blue-50 dark:bg-gray-800 dark:text-blue-400" role="alert">
                                <svg class="flex-shrink-0 inline w-4 h-4 me-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
                                </svg>
                                <span class="sr-only">Info</span>
                                <div class="flex-grow">
                                    <span>
                                        {{ __('Attached file:') }} 
                                    </span> 
                                    <a :href="previewAttachmentFile" target="_blank" class="text-blue-800 underline dark:text-blue-400 font-medium ml-1">
                                        {{ __('View file') }}
                                    </a>
                                </div>
                                <button 
                                    @click="removeFullFile()" 
                                    class="ml-4 flex-shrink-0 text-gray-700 dark:text-gray-300" aria-label="Eliminar archivo">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </button>
                            </div>
                        </div>

                        <p class="mt-4 text-sm text-gray-500">By submitting this form you agree to our <a href="/terms" class="text-primary-600 hover:underline dark:text-primary-500" target="_blank">terms and conditions</a> and our <a href="/policy" target="_blank" class="text-primary-600 hover:underline dark:text-primary-500">privacy policy</a> which explains how we may collect, use and disclose your personal information including to third parties.</p>
                    </div>

                    <button 
                        v-if="showSubmit" 
                        type="submit" 
                        class="py-3 px-5 text-sm font-medium text-center text-white rounded-lg bg-primary-700 sm:w-fit hover:bg-primary-800 focus:ring-4 focus:outline-none focus:ring-primary-300 dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800">
                        Send message
                    </button>
                    <button 
                        v-else 
                        type="button"
                        disabled 
                        class="py-3 px-5 text-sm font-medium text-center text-white rounded-lg bg-gray-400 sm:w-fit hover:bg-gray-500 focus:ring-4 focus:outline-none focus:ring-gray-300 dark:bg-gray-700 dark:hover:bg-gray-800 dark:focus:ring-gray-800">
                        Uploading...    
                    </button>
                    
                </form>

                <div v-else class="flex flex-col items-center gap-8 p-8 mx-auto mb-16 max-w-screen-md bg-white rounded-lg border border-gray-200 shadow-md lg:mb-28 dark:bg-gray-800 dark:border-gray-700 py-32">
                    <p class="mb-4 text-xl font-semibold text-center text-gray-700 dark:text-gray-300">
                        Thank you for your message. We will get back to you as soon as possible.
                    </p>
                    <button 
                        @click="redirectToHome"
                        class="py-3 px-6 text-base font-medium text-center text-white rounded-lg bg-primary-600 sm:w-fit hover:bg-primary-700 focus:ring-4 focus:outline-none focus:ring-primary-300 dark:bg-primary-500 dark:hover:bg-primary-600 dark:focus:ring-primary-800">
                        Go to Home
                    </button>
                </div>
            </div>
        </section>
    </div>
</template>

<script>
    import {
        FileDropInputComponent
    } from 'innoboxrr-form-elements';
    import { useReCaptcha } from 'vue-recaptcha-v3';
    import { createModel as createContactModel } from '@models/contact';
    import { CountrySelectInputComponent } from 'innoboxrr-form-elements'

    export default {
        components: {
            FileDropInputComponent,
            CountrySelectInputComponent
        },
        setup() {
            const { executeRecaptcha } = useReCaptcha();
            return {
                executeRecaptcha
            };
        },
        data() {
            return {
                showForm: true,
                form: {
                    context: 'teacher-join',
                    type: 'contact',
                    firstname: '',
                    lastname: '',
                    email: '',
                    phone: '',
                    phone_country_code: '',
                    country: '',
                    iso2: '',
                    notes: '',
                    attachment: null, // To store the file
                    website: location.href
                },
                showSubmit: true,
                fileDropDemoKey: 0, // To reset the file input
                previewAttachmentFile: null // For file preview if needed
            }
        },
        watch: {
            'form.phone_country_code': function(newVal) {
                if (newVal) {
                    if (!newVal.startsWith('+')) {
                        newVal = `+${newVal}`;
                    }
                    this.form.phone_country_code = `+${newVal.slice(1).replace(/\D/g, '')}`;
                }
            }
        },
        methods: {
            async handleSubmit() {
                const token = await this.executeRecaptcha('contactForm');
                const formData = { ...this.form, recaptcha: token };

                try {
                    const response = await axios.post('/validate-recaptcha', formData);
                    if (response.data.success) {
                        let res = await createContactModel(formData);
                        if (res.id) {
                            this.alert('success', {}, 'Your message has been sent');
                            this.resetForm();
                            this.showForm = false;
                            window.scrollTo({ top: 0, behavior: 'smooth' });
                            return;
                        } else {
                            this.alert('error', {}, 'There was an error sending your message');
                            return;
                        }
                    } else {
                        this.alert('error', {}, 'An error occurred');
                        return; 
                    }
                } catch (error) {
                    // Handle error
                }
            },
            handleFileUpload(file) {
                this.showSubmit = false;
                const extension = file[0].name.split('.').pop().toLowerCase();
                if(extension !== 'pdf') {
                    this.alert('error', {}, 'Only .pdf files are allowed.');
                    return;
                }
                this.previewAttachmentFile = URL.createObjectURL(file[0]);

                let formData = new FormData();
                formData.append('file', file[0]);
                let fetchOptions = {
                    method: 'POST',
                    body: formData,
                };
                fetch(route('lu.upload.file'), fetchOptions)
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Network response was not ok ' + response.statusText);
                        }
                        return response.json();
                    })
                    .then(res => {
                        this.form.attachment = res.uri;
                        this.showSubmit = true;
                    })
                    .catch(error => {
                        console.log(error);
                        this.alert('error', {}, 'There was an error uploading the file');
                        this.showSubmit = true;
                    });
            },
            resetForm() {
                this.form = {
                    context: 'teacher-join',
                    type: 'contact',
                    firstname: '',
                    lastname: '',
                    email: '',
                    phone_country_code: '',
                    phone: '',
                    country: '',
                    iso2: '',
                    notes: '',
                    attachment: null,
                    website: location.href
                };
                this.fileDropDemoKey += 1; // Reset the file input
                this.previewAttachmentFile = null;
            },
            removeFullFile() {
                this.form.attachment = null;
                this.previewAttachmentFile = null;
            },
            redirectToHome() {
                this.$router.push('/');
            },
            setPhone(data){
                this.form.phone = data.phone;
                this.form.phone_country_code = data.country.dialCode;
                this.form.country = data.country.name;
                this.form.iso2 = data.country.iso2;
            }
        }
    }
</script>
