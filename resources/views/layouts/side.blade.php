@foreach ($menuGroups as $group)
    <h3>{{ $group->title }}</h3>

    @foreach ($group->items as $item)
        <div>
            <a href="{{ $item->path ?? '#' }}">
                {{ $item->name }}
            </a>

            @if ($item->children->count())
                <ul>
                    @foreach ($item->children as $child)
                        <li><a href="{{ $child->path }}">{{ $child->name }}</a></li>
                    @endforeach
                </ul>
            @endif
        </div>
    @endforeach
@endforeach
