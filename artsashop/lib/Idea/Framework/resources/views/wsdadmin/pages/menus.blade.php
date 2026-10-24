<div>
    <ul class="dy-menu nav nav-pills nav-sidebar flex-column">
        <li class="nav-item @if(in_array(Request::segment(1), ['dashboard'])){{ 'from-violet-500/[0.12] dark:from-violet-500/[0.24] to-violet-500/[0.04]' }}@endif">
            <a class="nav-link text-sky-50 @if(Request::route()->getName() == 'wsdadm.dashboard')) {{ "dy-active" }} @endif" href="{{ route('wsdadm.dashboard') }}"><i class="fa-solid fa-house"></i> Dashboard</a>
        </li>
        @foreach($menus as $menu)
            @if(isset($menu['submenu']))
            <li class="nav-item">
                <details class="nav-item" {{$menu['status']}}>
                    <summary class="nav-link"> <span><i class="{{$menu['icon']}}"></i> {{$menu['text']}}</span></summary>
                    <ul class="nav nav-treeview">
                        @foreach($menu['submenu'] as $submenu)
                            @if (!isset($submenu['submenu']))
                                <li class="nav-item"><a class="nav-link text-sky-50 {{$submenu['class']}}" href="{{$submenu['url']}}"><i class="far fa-fw fa-circle "></i>  {{ $submenu['text'] }}</a></li>
                            @else
                                <li>
                                    <details @if(Request::route()->getName() == $submenu['key'])) {{ "open" }} @else {{ "close" }} @endif>
                                        <summary><span class="nav-link text-sky-50"><i class="far fa-fw fa-circle "></i> {{$submenu['text'] }}</span></summary>
                                        <ul class="nav nav-treeview">
                                            @foreach($submenu['submenu'] as $subSubMenu)
                                                <li class="nav-item"><a class="nav-link text-sky-50 {{$subSubMenu['class']}}" href="{{$subSubMenu['url']}}">{{ $subSubMenu['text'] }}</a></li>
                                            @endforeach
                                        </ul>
                                    </details>
                                </li>
                            @endif
                        @endforeach
                    </ul>
                </details>
            </li>
            @endif
        @endforeach
    </ul>
</div>
