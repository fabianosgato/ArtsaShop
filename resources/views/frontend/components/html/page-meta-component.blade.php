<meta http-equiv="X-UA-Compatible" content="IE=edge" />
<meta name="viewport" content="width=device-width, minimum-scale=1, maximum-scale=1" />
<link rel="profile" href="http://gmpg.org/xfn/11">
<link rel="preconnect" href="https://ecommerce.lef-tecnologia.com.br/">
<link rel="dns-prefetch" href="//{{ parse_url(config('app.url'), PHP_URL_HOST) }}">

@if (isset($seoData))
    {!! seo($seoData) !!}
@endif
