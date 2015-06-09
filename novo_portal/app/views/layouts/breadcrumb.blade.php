@section('breadcrumb')

	@if (isset($breadcrumb) && ! is_null($breadcrumb))
        <ol class="breadcrumb">
            @foreach ($breadcrumb as $bc)
                <li {{ ($bc['active']) ? 'class="active"' : '' }}>
                	@if ($bc['url'] == '#')
                		{{ $bc['nome'] }}
                	@else 
                		<a href="{{ url($bc['url']) }}">{{ $bc['nome'] }}</a>
                	@endif
                </li>
            @endforeach
        </ol>
    @endif

@stop