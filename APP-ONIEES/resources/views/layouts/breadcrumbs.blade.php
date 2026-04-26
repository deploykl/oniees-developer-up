<!-- Breadcrumbs -->
<nav class="flex items-center text-sm" aria-label="Breadcrumb">
    <ol class="inline-flex items-center space-x-1 md:space-x-3 flex-wrap">
        <li class="inline-flex items-center">
            <a href="{{ route('dashboard') }}" class="text-gray-500 hover:text-blue-600 transition">
                <i class="fas fa-home mr-1"></i>
                <span class="hidden sm:inline">Dashboard</span>
            </a>
        </li>
        
        @php
            $segments = request()->segments();
            $currentUrl = '';
        @endphp
        
        @foreach($segments as $index => $segment)
            @php
                $currentUrl .= '/' . $segment;
                $segmentName = ucfirst(str_replace('-', ' ', $segment));
                $isLast = $index === count($segments) - 1;
            @endphp
            
            @if(!$isLast)
                <li>
                    <div class="flex items-center">
                        <i class="fas fa-chevron-right text-gray-400 text-xs mx-1"></i>
                        <a href="{{ url($currentUrl) }}" class="text-gray-500 hover:text-blue-600 transition">
                            {{ $segmentName }}
                        </a>
                    </div>
                </li>
            @else
                <li aria-current="page">
                    <div class="flex items-center">
                        <i class="fas fa-chevron-right text-gray-400 text-xs mx-1"></i>
                        <span class="text-blue-600 font-medium">{{ $segmentName }}</span>
                    </div>
                </li>
            @endif
        @endforeach
    </ol>
</nav>