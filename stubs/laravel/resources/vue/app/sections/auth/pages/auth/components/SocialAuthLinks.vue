<template>

    <div class="mt-10">
        <div class="relative">
            <div class="absolute inset-0 flex items-center" aria-hidden="true">
                <div class="w-full border-t border-gray-200"></div>
            </div>
            <div class="relative flex justify-center text-sm font-medium leading-6">
                <span class="bg-white px-6 text-gray-900">Or continue with</span>
            </div>
        </div>

        <div class="mt-6 grid grid-cols-1 gap-4">

            <a 
                v-if="googleLogin"
                :href="googleRedirect" 
                class="flex w-full items-center justify-center gap-3 rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 focus-visible:ring-transparent">
                <svg class="h-5 w-5" aria-hidden="true" viewBox="0 0 24 24">
                    <path d="M12.0003 4.75C13.7703 4.75 15.3553 5.36002 16.6053 6.54998L20.0303 3.125C17.9502 1.19 15.2353 0 12.0003 0C7.31028 0 3.25527 2.69 1.28027 6.60998L5.27028 9.70498C6.21525 6.86002 8.87028 4.75 12.0003 4.75Z" fill="#EA4335" />
                    <path d="M23.49 12.275C23.49 11.49 23.415 10.73 23.3 10H12V14.51H18.47C18.18 15.99 17.34 17.25 16.08 18.1L19.945 21.1C22.2 19.01 23.49 15.92 23.49 12.275Z" fill="#4285F4" />
                    <path d="M5.26498 14.2949C5.02498 13.5699 4.88501 12.7999 4.88501 11.9999C4.88501 11.1999 5.01998 10.4299 5.26498 9.7049L1.275 6.60986C0.46 8.22986 0 10.0599 0 11.9999C0 13.9399 0.46 15.7699 1.28 17.3899L5.26498 14.2949Z" fill="#FBBC05" />
                    <path d="M12.0004 24.0001C15.2404 24.0001 17.9654 22.935 19.9454 21.095L16.0804 18.095C15.0054 18.82 13.6204 19.245 12.0004 19.245C8.8704 19.245 6.21537 17.135 5.2654 14.29L1.27539 17.385C3.25539 21.31 7.3104 24.0001 12.0004 24.0001Z" fill="#34A853" />
                </svg>
                <span class="text-sm font-semibold leading-6">Google</span>
            </a>

            <a 
                v-if="facebookLogin"
                :href="facebookRedirect"
                class="flex w-full items-center justify-center gap-3 rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 focus-visible:ring-transparent">
                <svg class="h-7 w-7" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 48 48" width="48px" height="48px"><path fill="#039be5" d="M24 5A19 19 0 1 0 24 43A19 19 0 1 0 24 5Z"/><path fill="#fff" d="M26.572,29.036h4.917l0.772-4.995h-5.69v-2.73c0-2.075,0.678-3.915,2.619-3.915h3.119v-4.359c-0.548-0.074-1.707-0.236-3.897-0.236c-4.573,0-7.254,2.415-7.254,7.917v3.323h-4.701v4.995h4.701v13.729C22.089,42.905,23.032,43,24,43c0.875,0,1.729-0.08,2.572-0.194V29.036z"/></svg>
                <span class="text-sm font-semibold leading-6">Facebook</span>
            </a>

            <a 
                v-if="microsoftLogin"
                :href="microsoftRedirect" 
                class="flex w-full items-center justify-center gap-3 rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 focus-visible:ring-transparent">
                <svg class="h-5 w-5" aria-hidden="true" viewBox="0 0 24 24">
                    <path d="M23.499 12.25H12.749V23H23.499V12.25ZM11.249 12.25V23H0.499016V12.25H11.249ZM23.499 0.5H12.749V11.25H23.499V0.5ZM11.249 0.5V11.25H0.499016V0.5H11.249Z" fill="#F25022" />
                    <path d="M11.25 0.5H0.5V11.25H11.25V0.5Z" fill="#7FBA00" />
                    <path d="M23.5 0.5H12.75V11.25H23.5V0.5Z" fill="#00A4EF" />
                    <path d="M23.5 12.25H12.75V23H23.5V12.25Z" fill="#FFB900" />
                    <path d="M11.25 12.25H0.5V23H11.25V12.25Z" fill="#F25022" />
                </svg>
                <span class="text-sm font-semibold leading-6">Microsoft</span>
            </a>

        </div>
    </div>
</template>
<script>
    export default {
        name: "SocialAuthLinks",
        data() {
            return {
                googleRedirect: route('auth.socialite.redirect', 'google'),
                facebookRedirect: route('auth.socialite.redirect', 'facebook'),
                microsoftRedirect: route('auth.socialite.redirect', 'microsoft'),
            };
        },
        mounted() {
            if(this.$route.query.error == 'register-provider-not-match') {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: this.__('The email you are trying to login with is already registered with another provider or email is already in use. Please login with the provider you used to register or use another email.'),
                })
            }
        }
    }
</script>