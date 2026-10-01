@if($breadcrumbs)
    <div id="sns_breadcrumbs" class="wrap">
        <div class="container">
            <div id="sns_titlepage">
                <h2>{{ $seoData->title }}</h2>
            </div>
            <div id="sns_pathway" class="clearfix">
                <div class="pathway-inner">
                    <ul class="breadcrumbs">
                        @foreach ($breadcrumbs as $breadcrumb)

                            @if ($breadcrumb->url && !$loop->last)
                                @if($breadcrumb->title == 'Home')
                                    <li class="home"><a href="{{ $breadcrumb->url }}">{{ $breadcrumb->title }}</a></li>
                                @else
                                    <li><a href="{{ $breadcrumb->url }}">{{ $breadcrumb->title }}</a></li>
                                @endif
                            @else
                                <li aria-current="page">{{ $breadcrumb->title }}</li>
                            @endif
                        @endforeach

                    </ul>
                </div>
            </div>
        </div>
    </div>
@endif
