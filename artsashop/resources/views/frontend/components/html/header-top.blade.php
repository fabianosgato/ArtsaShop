<div id="top_header">
    <div class="container">
        <div class="row-fluid">
            <div class="topheader-left">
                <ul class="links">
                    @if(Auth::guard('customer')->check())
                        <li class="wellcome"><a class="customer-loggedin" href="{{ route('account.index') }}">Olá, {{ Auth::guard('customer')->user()->customer_name }}</a></li>
                        <li class="link"><a class="customer-loggedin" href="{{ route('account.index') }}">Minha Conta</a></li>
                        <li class="link"><a href="{{ route('account.index') }}" title="Meus Favoritos">Meus Favoritos</a></li>
                        <li class="link"><a class="customer-loggedin" href="{{ route('account.logout') }}">Sair</a></li>
                    @else
                        <li class="wellcome">Seja Bem-vindo</li>
                        <li><a href="{{ route('account.login') }}">Entre / Registre-se</a></li>
                    @endif
                </ul>

            </div>
            <div class="topheader-right">
                <ul class="links">
                    <li class="link"><a href="{{ route('index.home') }}">Home</a></li>
                    <li class="link"><a href="{{ url('quem-somos') }}">Quem Somos</a></li>
                    <li class="contact-us-now"><a href="{{ url('fale-conosco') }}">Fale Conosco</a></li>
                </ul>
            </div>
        </div>
    </div>
</div>
