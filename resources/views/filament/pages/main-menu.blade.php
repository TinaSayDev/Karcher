<x-filament::page>
    @if(empty($itemsTree))
        <div style="color: #6b7280;">В главном меню пока нет пунктов</div>
    @else
        <div style="overflow-x: auto; color: #3f3f47;">
            <table style="width: 100%; border-collapse: collapse; border: 1px solid #cccccc;">
                <thead>
                <tr style="background-color: #f3f4f6;">
                    <th style="padding: 0.5rem 1rem; border: 1px solid #cccccc; text-align: left;">Название</th>
                    <th style="padding: 0.5rem 1rem; border: 1px solid #cccccc; text-align: center;">Редактировать</th>
                </tr>
                </thead>
                <tbody>
                @foreach($itemsTree as $node)
                    <tr>
                        <td style="padding: 0.5rem 1rem; border: 1px solid #cccccc;">
                                <span style="padding-left: {{ $node['level'] * 20 }}px;">
                                    {{ collect($node['item']->translations)->firstWhere('locale', app()->getLocale())?->menu_label
                                        ?? collect($node['item']->translations)->firstWhere('locale', app()->getLocale())?->name }}
                                </span>
                        </td>

                        <td style="padding: 0.5rem 1rem; border: 1px solid #cccccc; text-align: center;">
                            <a href="/admin/categories/{{ $node['item']->id }}/edit"
                               style="padding: 0.25rem 0.5rem; background-color: #3b82f6; color: white; border-radius: 0.25rem; font-size: 0.875rem; text-decoration: none;">
                                Перейти на страницу редактирования
                            </a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    @endif
</x-filament::page>
