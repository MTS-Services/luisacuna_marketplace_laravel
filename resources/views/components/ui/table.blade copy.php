{{-- @props([
    'columns' => [],
    'data' => [],
    'actions' => [],
    'searchProperty' => 'search',
    'showSearch' => true,
    'perPageProperty' => 'perPage',
    'showPerPage' => true,
    'perPageOptions' => [5, 10, 15, 20, 50, 100],
    'emptyMessage' => 'No records found.',
    'class' => '',
    'showRowNumber' => true,
    'mobileColumns' => 2,
]) --}}

@props([
    'data' => [],
    'columns' => [],
    'actions' => [],

    'class' => '',
    'sortField' => 'created_at',
    'sortDirection' => 'desc',
    'selectedIds' => [],
    'shortMethod' => 'sortBy',
])

<div class="glass-card static rounded-2xl p-4 mb-6 {{ $class }}">
    <div class="card">

        <table class="table w-full">
            <thead>
                <tr>
                    <th class="w-12">
                        <input type="checkbox" wire:model.live="selectAll" class="checkbox">
                    </th>

                    @if (in_array('id', array_column($columns, 'key')))
                        <th wire:click="sortBy('id')" class="cursor-pointer">
                            {{ __('ID') }}
                            @if ($sortField === 'id')
                                <span>{{ $sortDirection === 'asc' ? '↑' : '↓' }}</span>
                            @endif
                        </th>
                    @else
                        <th>
                            SL
                        </th>
                    @endif
                    @foreach ($columns as $column)
                        <th wire:click="sortBy('{{ $column['key'] }}')" class="cursor-pointer">
                            {{ $column['label'] }}
                            @if ($sortField === $column['key'])
                                <span>{{ $sortDirection === 'asc' ? '↑' : '↓' }}</span>
                            @endif
                        </th>
                    @endforeach
                    <th class="text-right">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($data as $item)
                    <tr wire:key="item-{{ $item->id }}">

                        <td>
                            <input type="checkbox" wire:model.live="selectedIds" value="{{ $item->id }}"
                                class="checkbox">
                        </td>
                        <td>{{ $item->id }}</td>

                        @foreach ($columns as $column)
                            {{-- <td>{{ $item->{$column['key']} }}</td> --}}
                            <td>
                                @if (isset($column['format']) && is_callable($column['format']))
                                    {!! $column['format']($item) !!}
                                @else
                                    {{ data_get($item, $column['key']) }}
                                @endif
                            </td>
                        @endforeach
                        @if (count($actions) > 0)
                            <td class="p-3 text-center ">
                                <div class="relative inline-block text-left">
                                    <div x-data="{ open: false }">
                                        <button type="button" @click="open = !open"
                                            class="flex items-center justify-center gap-2 text-sm font-medium hover:rotate-90 transition-all duration-300 ease-linear group mx-auto">
                                            <flux:icon icon="cog-6-tooth"
                                                class="w-6 h-6 group-hover:stroke-accent transition-all duration-300 ease-linear" />
                                        </button>

                                        <div x-show="open" x-cloak
                                            x-transition:enter="transition ease-out duration-100"
                                            x-transition:enter-start="transform opacity-0 scale-95"
                                            x-transition:enter-end="transform opacity-100 scale-100"
                                            x-transition:leave="transition ease-in duration-75"
                                            x-transition:leave-start="transform opacity-100 scale-100"
                                            x-transition:leave-end="transform opacity-0 scale-95"
                                            class="absolute z-10 mt-2 min-w-32 w-fit max-w-52 origin-top-right right-0 rounded-md shadow-lg text-center"
                                            @click.outside="open = false">
                                            <div class="rounded-md bg-white shadow-xs">
                                                <div class="py-1">
                                                    @foreach ($actions as $action)
                                                        @if (isset($action['href']) && $action['href'] != null && $action['href'] != '#')
                                                            @php
                                                                $param =
                                                                    (isset($action['param']) && $action['param']
                                                                        ? $action['param']
                                                                        : $action['key']) ?? '';
                                                                $actionValue = data_get($item, $param);
                                                                $actionParam = is_numeric($actionValue)
                                                                    ? $actionValue
                                                                    : "'{$actionValue}'";
                                                                $href = empty($actionParam)
                                                                    ? $action['href']
                                                                    : "{$action['href']}/{$actionParam}";
                                                            @endphp
                                                            <a href="{{ $href }}"
                                                                title="{{ $action['label'] }}"
                                                                target="{{ $action['target'] ?? '_self' }}"
                                                                class="block px-4 py-2 w-full text-sm text-left text-gray-700 hover:bg-gray-100 hover:text-gray-900"
                                                                wire:navigate>
                                                                {{ $action['label'] }}
                                                            </a>
                                                        @elseif (isset($action['route']) && $action['route'] != null && $action['route'] != '#')
                                                            @php
                                                                $param =
                                                                    (isset($action['param']) && $action['param']
                                                                        ? $action['param']
                                                                        : $action['key']) ?? '';
                                                                $actionValue = data_get($item, $param);
                                                                $actionParam = is_numeric($actionValue)
                                                                    ? $actionValue
                                                                    : "'{$actionValue}'";
                                                            @endphp
                                                            <a href="{{ route($action['route'], $actionParam) }}"
                                                                title="{{ $action['label'] }}"
                                                                target="{{ $action['target'] ?? '_self' }}"
                                                                class="block px-4 py-2 w-full text-sm text-left text-gray-700 hover:bg-gray-100 hover:text-gray-900"
                                                                wire:navigate>
                                                                {{ $action['label'] }}
                                                            </a>
                                                        @elseif(isset($action['method']) && $action['method'] != null)
                                                            @php
                                                                $actionValue = data_get(
                                                                    $item,
                                                                    (isset($action['param']) && $action['param']
                                                                        ? $action['param']
                                                                        : $action['key']) ?? 'id',
                                                                );
                                                                $actionParam = is_numeric($actionValue)
                                                                    ? $actionValue
                                                                    : "'{$actionValue}'";
                                                            @endphp
                                                            <button type="button"
                                                                wire:click="{{ $action['method'] }}({{ $actionParam }})"
                                                                class="block px-4 py-2 w-full text-left text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900"
                                                                @click="open = false">
                                                                {{ $action['label'] }}
                                                            </button>
                                                        @else
                                                            <button type="button"
                                                                class="block px-4 py-2 w-full text-left text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900"
                                                                @click="open = false">
                                                                {{ $action['label'] }}
                                                            </button>
                                                        @endif
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        @endif
                    </tr>

                @empty
                    <tr>
                        <td colspan="9" class="text-center py-8 text-gray-500">
                            No admins found
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div class="mt-6">
            {{ $data->links() }}
        </div>

    </div>

    <button @click="show = true" class="btn btn-error">delete</button>
    <button @click="show = false" class="btn btn-error">delete</button>
    <p x-show="show">Show</p>
    {{-- @if ($showDeleteModal) --}}

    {{-- @endif --}}

</div>
