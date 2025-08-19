<x-app-layout>
    <section class="py-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">

            @php
                $modulos = [
                    [
                        'titulo' => 'Usuarios',
                        'descripcion' => 'Gestión de pagos y abonos por usuario.',
                        'ruta' => '/usuarios',
                        'icono' => 'credit-card',
                        'color' => 'text-blue-600',
                        'bg' => 'bg-blue-100',
                    ],
                    [
                        'titulo' => 'Tipos de Usuarios',
                        'descripcion' => 'Gestión de tipado de usuarios.',
                        'ruta' => '/tipousuarios',
                        'icono' => 'type',
                        'color' => 'text-rose-600',
                        'bg' => 'bg-rose-100',
                    ],
                    [
                        'titulo' => 'Tasas',
                        'descripcion' => 'Control de tasas administrativas.',
                        'ruta' => '/tasas',
                        'icono' => 'percent',
                        'color' => 'text-emerald-600',
                        'bg' => 'bg-emerald-100',
                    ],
                    [
                        'titulo' => 'Distribución',
                        'descripcion' => 'Seguimiento y reportes de distribución.',
                        'ruta' => '/distribucion',
                        'icono' => 'send',
                        'color' => 'text-indigo-600',
                        'bg' => 'bg-indigo-100',
                    ],
                ];
            @endphp

            @foreach ($modulos as $modulo)
                <div class="rounded-xl border border-gray-200 bg-white p-5 shadow-sm hover:shadow-md transition">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="p-2 rounded-lg {{ $modulo['bg'] }} {{ $modulo['color'] }}">
                            <!-- Icono moderno -->
                            @switch($modulo['icono'])
                                @case('credit-card')
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor" stroke-width="2">
                                        <path d="M2 7h20M2 11h20M2 15h10" />
                                    </svg>
                                @break

                                @case('percent')
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor" stroke-width="2">
                                        <path d="M19 5L5 19M7 5a2 2 0 100 4 2 2 0 000-4zm10 10a2 2 0 100 4 2 2 0 000-4z" />
                                    </svg>
                                @break

                                @case('send')
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor" stroke-width="2">
                                        <path d="M22 2L11 13" />
                                        <path d="M22 2L15 22L11 13L2 9L22 2Z" />
                                    </svg>
                                @break

                                @case('type')
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                        fill="currentColor" class="icon icon-tabler icons-tabler-filled icon-tabler-filters">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path
                                            d="M19.396 11.056a6 6 0 0 1 -5.647 10.506q .206 -.21 .396 -.44a8 8 0 0 0 1.789 -6.155a8.02 8.02 0 0 0 3.462 -3.911" />
                                        <path d="M4.609 11.051a7.99 7.99 0 0 0 9.386 4.698a6 6 0 1 1 -9.534 -4.594z" />
                                        <path d="M12 2a6 6 0 1 1 -6 6l.004 -.225a6 6 0 0 1 5.996 -5.775" />
                                    </svg>
                                @break
                            @endswitch
                        </div>
                        <h3 class="text-lg font-semibold text-gray-800">{{ $modulo['titulo'] }}</h3>
                    </div>
                    <p class="text-sm text-gray-500 mb-4">{{ $modulo['descripcion'] }}</p>
                    <a href="{{ $modulo['ruta'] }}" class="text-sm text-sky-600 hover:underline font-medium transition">
                        Ir al módulo →
                    </a>
                </div>
            @endforeach

        </div>
    </section>
</x-app-layout>
