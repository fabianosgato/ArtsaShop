<div id="sns_topheader" class="wrap">
    <div class="container">
        <div class="row-fluid">
            <div class="topheader-left span5">
                Seja Bem vindo
            </div>
            <div class="topheader-right span7">
                <div class="inner">

                    <div class="sns-quickaccess">
                        <div class="quickaccess-inner">

                            <span class="welcome">Seja bem vindo!</span>
                            <ul class="links">
                                <li class="first"><a href="{{ route('index.home') }}">Home</a></li>
                                <li><a href="{{ url('quem-somos') }}">Quem Somos</a></li>
                                @if(Auth::guard('customer')->check())
                                    <li><a class="customer-loggedin" href="{{ route('account.index') }}">Olá, {{ Auth::guard('customer')->user()->customer_name }}</a></li>
                                    <li><a class="customer-loggedin" href="{{ route('account.index') }}">Minha Conta</a></li>
                                    <li><a href="{{ route('account.index') }}" title="Meus Favoritos">Meus Favoritos</a></li>
                                    <li class="last"><a class="customer-loggedin" href="{{ route('account.logout') }}">Sair</a></li>
                                @else
                                    <li class="last"><a href="{{ route('account.login') }}">Entre / Registre-se</a></li>
                                @endif
                                <li><a href="{{ url('fale-conosco') }}">Fale Conosco</a></li>
                            </ul>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
