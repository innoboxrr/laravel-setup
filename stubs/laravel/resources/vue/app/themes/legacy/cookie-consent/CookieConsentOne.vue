<template>

    <div 
        v-if="showConsent" 
        class="pointer-events-none fixed inset-x-0 bottom-0 px-6 pb-6">
        <div class="pointer-events-auto ml-auto max-w-xl rounded-xl bg-white p-6 shadow-lg ring-1 ring-gray-900/10">
            <p class="text-sm leading-6 text-gray-900">This website uses cookies to supplement a balanced diet and provide a much deserved reward to the senses after consuming bland but nutritious meals. Accepting our cookies is optional but recommended, as they are delicious. See our 
                <router-link
                    :to="{ name: 'CookiesPolicy' }"
                    class="font-semibold text-indigo-600">
                    cookie policy
                </router-link>.
            </p>
            <div class="mt-4 flex items-center gap-x-5">
                <button
                    @click="acceptConsent"
                    type="button"
                    class="rounded-md bg-gray-900 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-gray-700 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-gray-900">
                    Accept all
                </button>
                <button
                    @click="rejectConsent"
                    type="button"
                    class="text-sm font-semibold leading-6 text-gray-900">
                    Reject all
                </button>
            </div>
        </div>
    </div>

</template>

<script>

    export default {
        data() {
            return {
                showConsent: true // Asumimos que el consentimiento no se ha dado inicialmente
            }
        },
        mounted() {
            this.checkCookieConsent();
        },
        methods: {
            getCookie(name) {
                let matches = document.cookie.match(new RegExp(
                    "(?:^|; )" + name.replace(/([\.$?*|{}\(\)\[\]\\\/\+^])/g, '\\$1') + "=([^;]*)"
                ));
                return matches ? decodeURIComponent(matches[1]) : undefined;
            },
            setCookie(name, value, days) {
                let expires = "";
                if (days) {
                    let date = new Date();
                    date.setTime(date.getTime() + (days*24*60*60*1000));
                    expires = "; expires=" + date.toUTCString();
                }
                document.cookie = name + "=" + (value || "")  + expires + "; path=/";
            },
            checkCookieConsent() {
                const consentGiven = this.getCookie('consentCookieName');
                if (consentGiven !== undefined) {
                    this.showConsent = false;
                }
            },
            acceptConsent() {
                // Establecer la cookie para el consentimiento durante 365 días
                this.setCookie('consentCookieName', 'true', 365);
                this.showConsent = false;
            },
            rejectConsent() {
                // Opcionalmente, manejar el rechazo de consentimiento
                this.showConsent = false;
                // Redirigir a una página de rechazo de consentimiento
                window.location.href = 'https://google.com';
            }
        }
    }



</script>
