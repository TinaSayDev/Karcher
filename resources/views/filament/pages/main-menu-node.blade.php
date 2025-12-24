<li class="pl-{{ $level * 6 }}">
    <div class="flex justify-between items-center border p-2 rounded">
        <div>
            <strong>
                {{ collect($node['item']->translations)->firstWhere('locale', app()->getLocale())?->menu_label
                    ?? collect($node['item']->translations)->firstWhere('locale', app()->getLocale())?->name }}
            </strong>
        </div>
        <div>
            <a href="/admin/categories/{{ $node['item']->id }}/edit"
               class="px-2 py-1 bg-blue-500 text-white rounded text-sm">Edit</a>
        </div>
    </div>

    @if(!empty($node['children']))
        <ul class="ml-6 mt-2 space-y-1">
            @foreach($node['children'] as $child)
                @include('filament.pages.main-menu-node', ['node' => $child, 'level' => $level + 1])
            @endforeach
        </ul>
    @endif
</li>
