@props(['items'])

<nav class="flex mb-4 text-sm text-gray-600">
    @foreach($items as $index => $item)
        @if($index > 0)
            <span class="mx-2">/</span>
        @endif
        
        @if(isset($item['url']) && !$loop->last)
            <a href="{{ $item['url'] }}" class="hover:text-blue-600">{{ $item['label'] }}</a>
        @else
            <span class="text-gray-900">{{ $item['label'] }}</span>
        @endif
    @endforeach
</nav>