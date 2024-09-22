<!DOCTYPE html>
<html lang="{{ session()->get('app_locale', 'en') }}">
	<head>
		@if(config('app.tracking.gtm'))
			<!-- Google Tag Manager -->
			<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
				new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
				j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
				'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
			})(window,document,'script','dataLayer','{{ config('app.tracking.gtm') }}');</script>
			<!-- End Google Tag Manager -->
		@endif
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta name="csrf-token" content="{{ csrf_token() }}">
		@auth
			<meta name="usr" content="{{ base64_encode(@user()->id) }}">
			<meta name="conf" content="{{ @user()->email_verified_at }}">
			<meta name="adm" content="{{ @user()->isAdmin() ? base64_encode(@user()->id) : '' }}">
		@endauth
		@if(session()->has('impersonating'))
			<meta name="impersonating" content="true">
		@endif
		<title>{{ config('app.name') }}</title>
		@vite('resources/vue/assets/css/app.css')
		<link rel="apple-touch-icon" sizes="57x57" href="{{ config('app.favicons.apple-touch-icon-57x57') }}">
		<link rel="apple-touch-icon" sizes="60x60" href="{{ config('app.favicons.apple-touch-icon-60x60') }}">
		<link rel="apple-touch-icon" sizes="72x72" href="{{ config('app.favicons.apple-touch-icon-72x72') }}">
		<link rel="apple-touch-icon" sizes="76x76" href="{{ config('app.favicons.apple-touch-icon-76x76') }}">
		<link rel="apple-touch-icon" sizes="114x114" href="{{ config('app.favicons.apple-touch-icon-114x114') }}">
		<link rel="apple-touch-icon" sizes="120x120" href="{{ config('app.favicons.apple-touch-icon-120x120') }}">
		<link rel="apple-touch-icon" sizes="144x144" href="{{ config('app.favicons.apple-touch-icon-144x144') }}">
		<link rel="apple-touch-icon" sizes="152x152" href="{{ config('app.favicons.apple-touch-icon-152x152') }}">
		<link rel="apple-touch-icon" sizes="180x180" href="{{ config('app.favicons.apple-touch-icon-180x180') }}">
		<link rel="icon" type="image/png" sizes="192x192" href="{{ config('app.favicons.icon-192x192') }}">
		<link rel="icon" type="image/png" sizes="32x32" href="{{ config('app.favicons.icon-32x32') }}">
		<link rel="icon" type="image/png" sizes="96x96" href="{{ config('app.favicons.icon-96x96') }}">
		<link rel="icon" type="image/png" sizes="16x16" href="{{ config('app.favicons.icon-16x16') }}">
		<link rel="icon" type="image/x-icon" href="{{ config('app.favicons.icon') }}">
		<link rel="manifest" href="{{ config('app.favicons.manifest') }}">
		<meta name="msapplication-TileColor" content="{{ config('app.favicons.msapplication-TileColor') }}">
		<meta name="msapplication-TileImage" content="{{ config('app.favicons.msapplication-TileImage') }}">
		<meta name="theme-color" content="{{ config('app.favicons.theme-color') }}">

		@if(config('app.tracking.clarity'))
			<script type="text/javascript">
				(function(c,l,a,r,i,t,y){
					c[a]=c[a]||function(){(c[a].q=c[a].q||[]).push(arguments)};
					t=l.createElement(r);t.async=1;t.src="https://www.clarity.ms/tag/"+i;
					y=l.getElementsByTagName(r)[0];y.parentNode.insertBefore(t,y);
				})(window, document, "clarity", "script", "{{ config('app.tracking.clarity')}}");
			</script>
		@endif

		@if(config('app.tracking.google'))
			<!-- Google tag (gtag.js) -->
			<script async src="https://www.googletagmanager.com/gtag/js?id={{ config('app.tracking.google') }}"></script>
			<script>
				window.dataLayer = window.dataLayer || [];
				function gtag(){dataLayer.push(arguments);}
				gtag('js', new Date());

				gtag('config', '{{ config('app.tracking.google') }}');
			</script>
		@endif

		@if(config('app.tracking.tiktok'))
			<!-- TikTok Pixel -->
			<script>
				(function(w, d, t) {
					w.TiktokAnalyticsObject=t;
					var ttq=w[t]=w[t]||[];
					ttq.methods=["page","track","identify","instances","debug","on","off","once","ready","alias","group","enableCookie","disableCookie"],ttq.setAndDefer=function(t,e){t[e]=function(){t.push([e].concat(Array.prototype.slice.call(arguments,0)))}};for(var i=0;i<ttq.methods.length;i++)ttq.setAndDefer(ttq,ttq.methods[i]);
					ttq.load=function(e,n){var i="https://analytics.tiktok.com/i18n/pixel/events.js";ttq.instance=e,ttq.load(i,n)};
					ttq.load('{{ config('app.tracking.tiktok') }}');
					ttq.page();
				}(window, document, "ttq"));
			</script>
		@endif

		@if(config('app.tracking.facebook'))
			<!-- Meta Pixel Code -->
			<script>
				!function(f,b,e,v,n,t,s)
				{if(f.fbq)return;n=f.fbq=function(){n.callMethod?
				n.callMethod.apply(n,arguments):n.queue.push(arguments)};
				if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
				n.queue=[];t=b.createElement(e);t.async=!0;
				t.src=v;s=b.getElementsByTagName(e)[0];
				s.parentNode.insertBefore(t,s)}(window, document,'script',
				'https://connect.facebook.net/en_US/fbevents.js');
				fbq('init', '{{ config('app.tracking.facebook') }}');
				fbq('track', 'PageView');
			</script>
			<noscript><img height="1" width="1" style="display:none"
			src="https://www.facebook.com/tr?id={{ config('app.tracking.facebook') }}&ev=PageView&noscript=1"
			/></noscript>
			<!-- End Meta Pixel Code -->
		@endif

		@if(config('app.tracking.linkedin'))
			<!-- LinkedIn Insight Tag -->
			<script type="text/javascript">
				_linkedin_partner_id = "{{ config('app.tracking.linkedin') }}";
				window._linkedin_data_partner_ids = window._linkedin_data_partner_ids || [];
				window._linkedin_data_partner_ids.push(_linkedin_partner_id);
				(function(l) {
					if (!l){window.lintrk = function(a,b){window.lintrk.q.push([a,b])};
					window.lintrk.q=[]}
					var s = document.getElementsByTagName("script")[0];
					var b = document.createElement("script");
					b.type = "text/javascript";b.async = true;
					b.src = "https://snap.licdn.com/li.lms-analytics/insight.min.js";
					s.parentNode.insertBefore(b, s);})(window.lintrk);
			</script>
			<noscript>
				<img height="1" width="1" style="display:none;" alt=""
					src="https://px.ads.linkedin.com/collect/?pid={{ config('app.tracking.linkedin') }}&fmt=gif" />
			</noscript>
		@endif

	</head>

	<body>
		@if(config('app.tracking.gtm'))
			<!-- Google Tag Manager (noscript) -->
			<noscript><iframe src="https://www.googletagmanager.com/ns.html?id={{ config('app.tracking.gtm') }}"
			height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
			<!-- End Google Tag Manager (noscript) -->
		@endif

		<div id="app-loader" class="loader" style="display: none;">
			<div role="status">
				<svg aria-hidden="true" class="w-8 h-8 mr-2 text-gray-200 animate-spin dark:text-gray-600 fill-blue-600" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
					<path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="currentColor"/>
					<path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentFill"/>
				</svg>
				<span class="sr-only">Loading...</span>
			</div>
		</div>

		<div id="loader" class="loader" style="display: none;">
			<div role="status">
				<svg aria-hidden="true" class="w-8 h-8 mr-2 text-gray-200 animate-spin dark:text-gray-600 fill-blue-600" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
					<path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="currentColor"/>
					<path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentFill"/>
				</svg>
				<span class="sr-only">Loading...</span>
			</div>
		</div>

		<div id="app"></div>

		@vite('resources/vue/assets/js/bootstrap.js')
		@vite('resources/vue/assets/js/vue.js')
		<style>
			/* Override any style here */
			.dark .vs__search::placeholder, .dark .vs__dropdown-toggle, .dark .vs__dropdown-menu {
				background-color: rgb(30 41 59) !important;
				border: none;
				color: #fff;
				font-size: 14px;
				padding: 6px 0;
			}			
		</style>
	</body>
</html>