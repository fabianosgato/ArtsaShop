<div class="block block-account">
    <div class="block-title">
        <strong><span>Minha Conta</span></strong>
    </div>
    <div class="block-content">
        <ul>

            @if(request()->route()->getName() == 'account.index')
                <li class="current"><a href="{{ route('account.index') }}"><strong>Painel da conta</strong></a></li>
            @else
                <li><a href="{{ route('account.index') }}">Painel da conta</a></li>
            @endif

            @if(request()->route()->getName() == 'account.edit')
                <li class="current"><a href="{{ route('account.edit') }}"><strong>Informações da conta</strong></a></li>
            @else
                <li><a href="{{ route('account.edit') }}">Informações da conta</a></li>
            @endif

            @if(request()->route()->getName() == 'account.address')
                <li class="current"><a href="{{ route('account.address') }}"><strong>Meus Endereços</strong></a></li>
            @else
                <li><a href="{{ route('account.address') }}">Meus Endereços</a></li>
            @endif

            @if(request()->route()->getName() == 'account.orders')
                <li class="current"><a href="{{ route('account.orders') }}"><strong>Minhas Compras</strong></a></li>
            @else
                <li><a href="{{ route('account.orders') }}">Minhas Compras</a></li>
            @endif

            @if(request()->route()->getName() == 'account.wishlist.index')
                <li class="current last"><a href="{{ route('account.wishlist.index') }}"><strong>Favoritos</strong></a></li>
            @else
                <li class="last"><a href="{{ route('account.wishlist.index') }}">Favoritos</a></li>
            @endif

        </ul>
    </div>
</div>
