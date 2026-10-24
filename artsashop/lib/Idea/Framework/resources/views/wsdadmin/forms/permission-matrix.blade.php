<div>
    @foreach($getPermissions() as $permission)
        <div class="card card-info card-outline mb-6">
            <div class="card-header">
                <h3 class="text-lg font-bold">Módulo: {{ $permission['module'] }}</h3>
            </div>
            <div class="card-body">
                <table class="w-full table-fixed border-collapse">
                    <thead>
                    <tr class="border-b border-gray-200">
                        <th class="text-left align-middle w-[250px] pb-2 font-semibold text-gray-700">
                            Modulo
                        </th>
                        <th class="text-center align-middle w-[140px] pb-2 font-semibold text-gray-700">
                            Marcar Todos
                        </th>
                        @foreach($getActions() as $action)
                            <th class="text-center align-middle w-[140px] pb-2 font-semibold text-gray-700">{{$action}}</th>
                        @endforeach
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($permission['permissions'] as $modulePermission)
                        <tr class="border-b border-gray-50 hover:bg-gray-50">
                            <td class="text-left align-middle py-3 pr-4 whitespace-nowrap">
                                <span class="text-gray-900 font-medium">{{ $modulePermission['title'] }}</span>
                            </td>
                            <td class="text-center align-middle py-3">
                                <input
                                    type="checkbox"
                                    x-on:change="
                                        let checked = $event.target.checked;

                                        @foreach($modulePermission['actions'] as $action)
                                            $wire.set(
                                                '{{ $getStatePath() }}.{{ $modulePermission['id'] }}.{{ $action['action'] }}',
                                                checked
                                            );
                                        @endforeach
                                    "
                                    class="rounded border-gray-300 text-blue-600"
                                />
                            </td>
                            @foreach($modulePermission['actions'] as $modulePermissionAction)
                                <td class="text-center align-middle py-3">
                                    <label class="inline-flex flex-col items-center justify-center gap-1 cursor-pointer select-none text-xs text-gray-600">
                                        <span>{{ $modulePermissionAction['label'] }}</span>
                                        <input
                                            type="checkbox"
                                            class="rounded border-gray-300 text-blue-600 focus:ring-blue-500"
                                            wire:model.live="{{ $getStatePath() }}.{{ $modulePermission['id'] }}.{{ $modulePermissionAction['action'] }}"
                                        />
                                    </label>
                                </td>
                            @endforeach
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endforeach
</div>
