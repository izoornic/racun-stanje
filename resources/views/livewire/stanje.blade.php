<div>
    <!-- Main Content -->
    <main class="px-4 py-6 pb-20 max-w-md mx-auto">
        <!-- Vlasnik Card -->
        <div class="bg-white bg-sky-100 dark:bg-gray-800 rounded-2xl p-6 shadow-sm mb-4 flex justify-between">
            <div></div>
            <div>
                <div class="flex">
                    <x-heroicon-o-user-circle class="w-6 h-6 mt-1 mr-3 dark:text-white" />
                    <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-2">
                        {{ $vlasnik['vlasnik'] }}
                    </h2>
                </div>
                <div class="flex">
                    @if($vlasnik['naziv'] == 'stan')
                        <x-heroicon-o-home class="w-4 h-4 mt-1 mr-2 dark:text-white" />
                    @elseif($vlasnik['naziv'] == 'lokal')
                        <x-heroicon-o-building-storefront class="w-4 h-4 mt-1 mr-2 dark:text-white" />
                    @endif
                    <p class="text-gray-600 dark:text-gray-300">
                        {{ $zgrada['adresa'] }} - {{ $vlasnik['naziv'] }} {{ $vlasnik['stanbr'] }}
                    </p>
                </div>
                <div class="flex">
                    <x-heroicon-o-building-office class="w-4 h-4 mt-1 mr-2 dark:text-white" />
                    <p class="text-gray-600 dark:text-gray-300">
                        SZ {{ $zgrada['naziv'] }}, {{ $zgrada['sediste'] }}
                    </p>
                </div>
            </div>
            <div></div>
        </div>
        <!-- Stanje Card -->
        <div class="{{ $dug_labels['bg'] }} rounded-2xl mb-4 p-4 text-white flex justify-between">
            <div></div>
            <div>
                <div class="text-sm opacity-90">Trenutno stanje: <span class="font-bold">{{ $dug_labels['label'] }}</span></div>
                <div class="flex">
                    @if( $dug_labels['prefix'] == '-')
                        <x-heroicon-s-minus-circle class="w-8 h-8 mt-1 mr-8" />
                    @elseif( $dug_labels['prefix'] == '+')
                        <x-heroicon-c-check-circle class="w-8 h-8 mt-1 mr-8" />
                    @else
                        <x-heroicon-c-check-circle class="w-8 h-8 mt-1 mr-8"/>
                    @endif
                    <div class="text-3xl font-bold mb-1">{{ $dug_stanje['saldo_formated'] }}</div>
                </div>
                <div class="text-sm opacity-90">Datum poslednjeg knjiženja: <span class="font-bold">{{ $posledenje_knjizenje }}</span></div>
            </div>
            <div></div>
        </div>
        @if($aktivna_opomena)
            <!-- Opomena Card -->
           <button wire:click="showOpomena" class="bg-orange-400 dark:bg-orange-800 rounded-2xl mb-4 p-4 text-white flex justify-between w-full">
                <div class="my-auto"><x-heroicon-o-exclamation-triangle class="w-6 h-6 mt-1 mr-4" /></div>
                <div>
                    <div class="text-sm opacity-90">Aktivna opomena:</div>
                    <div class="flex">
                        <div class="text-xl font-bold mb-1">
                            {{ $aktivna_opomena['naslov'] }}
                        </div>
                    </div>
                </div>
                <div class="my-auto"><x-heroicon-o-arrows-pointing-out class="w-6 h-6 dark:text-white" /></div>
            </button>
        @endif

        @if($zgrada_visible) 
            <!-- Zgrada Card -->
            <div class="bg-blue-500 dark:bg-blue-900 rounded-2xl mb-4 p-4 text-white flex justify-between">
                <div></div>
                <div>
                    <div class="text-sm opacity-90">Zgrada: <span class="font-bold">{{ $zgrada['naziv'] }}</span> - Stanje na računu:</div> 
                    <div class="flex">
                        <div class="mr-4 my-auto"><x-heroicon-o-building-office class="w-8 h-8 mt-1 mr-2" /></div>
                        <div class="text-3xl font-bold mb-1">{{ $stanje_zgrada['stanja_formated'] }}</div>
                    </div>
                    <div class="text-sm opacity-90">Datum poslednjeg obrađenog izvoda: <span class="font-bold">{{$stanje_zgrada['datum_display'] }}</span></div>
                </div>
                <div></div>
            </div>
        @endif
        <!-- Stats Grid -->
        <!-- <div class="grid grid-cols-2 gap-4 mb-4">
            <div class="bg-blue-500 rounded-2xl p-4 text-white">
                <div class="text-3xl font-bold mb-1">24</div>
                <div class="text-sm opacity-90">Korisnika</div>
            </div>
            <div class="bg-purple-500 rounded-2xl p-4 text-white">
                <div class="text-3xl font-bold mb-1">142</div>
                <div class="text-sm opacity-90">Aktivnosti</div>
            </div>
        </div> -->

        <!-- Uplate -->
        <button wire:click="showUplate" style="cursor: pointer;" class="mx-auto bg-gray-200 dark:bg-gray-600 rounded-xl p-4 shadow-sm mb-3 flex justify-between">
            <div></div>
            <div>
                <div class="flex">
                    <x-icon-hand-holding-dollar class="w-6 h-6 mt-1 mr-2 fill-gray-700 dark:fill-white" />
                    <h3 class="text-2xl font-bold text-gray-600 dark:text-white">
                        Uplate
                    </h3>
                    @if($ulpateDisplay)
                        <x-heroicon-o-chevron-down class="w-6 h-6 mt-1 ml-2 text-gray-700 dark:text-white" />
                    @else
                        <x-heroicon-o-chevron-up class="w-6 h-6 mt-1 ml-2 text-gray-700 dark:text-white" />
                    @endif
                </div>
            </div>
            <div></div>    
        </button>
        <!-- List Items -->
        @if($ulpateDisplay)
        <div class="space-y-3" >
            @foreach ($uplate as $uplata)
                <div class="bg-white dark:bg-gray-800 dark:border dark:border-gray-600 rounded-xl p-2 shadow-sm">
                    <div>
                        <h3 class="font-semibold text-gray-900 dark:text-white">
                            {{ $uplata['mesec'] }} {{ $uplata['year'] }}
                        </h3>
                    </div>
                    <div class="flex items-center justify-between">
                        <div class="w-8 h-8 {{ $uplata['bg'] }} rounded-full flex items-center justify-center text-white">
                            @if($uplata['prefix'] == '-')
                                <x-heroicon-o-minus-circle class="w-6 h-6" />
                            @elseif($uplata['prefix'] == '+')
                                <x-heroicon-o-check-circle class="w-6 h-6" />
                            @else
                                <x-heroicon-o-check-circle class="w-6 h-6" />
                            @endif
                        </div>
                    
                        <div>
                            <p class="text-sm text-gray-600 dark:text-gray-300">
                                Zaduženo:
                            </p>
                            <h3 class="font-semibold text-gray-900 dark:text-white mb-1">
                                {{ $uplata['zaduzeno_formated'] }}
                            </h3>
                            <p class="text-sm text-gray-600 dark:text-gray-300">
                                {{ $uplata['datum'] }}
                            </p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600 dark:text-gray-300">
                                Razduženo:
                            </p>
                            <h3 class="font-semibold text-gray-900 dark:text-white mb-1">
                                {{ $uplata['razduzeno_formated'] }}
                            </h3>
                            <p class="text-sm text-gray-600 dark:text-gray-300">
                                {{ $uplata['r_date'] }}
                            </p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600 dark:text-gray-300">
                                Saldo:
                            </p>
                            <h3 class="font-semibold text-gray-900 dark:text-white mb-1">
                                {{ $uplata['saldo'] }}
                            </h3>
                            <p class="text-sm text-gray-600 dark:text-gray-300">
                                &nbsp;
                            </p>
                        </div>

                        <div>
                            @if($uplata['razduzeno'] == 0)
                                <button wire:click="showQr({{ $uplata['mid'] }})" style="cursor: pointer;" class="bg-gray-200 dark:bg-gray-600 rounded-sm p-1">
                                    <x-heroicon-o-qr-code class="w-6 h-6 dark:text-white" />
                                </button>
                            @elseif($uplata['prefix'] == '+')
                                <x-heroicon-o-plus-circle class="w-6 h-6 dark:text-white" />
                            @else
                                <x-heroicon-o-check-circle class="w-6 h-6 dark:text-white" />
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach

            @if($stari_dug['zaduzeno'] > 0)
                <div class="bg-white dark:bg-gray-800 dark:border dark:border-gray-600 rounded-xl p-4 shadow-sm">
                    <div class="flex items-center justify-between">
                            <div class="w-8 h-8 {{ $stari_dug['bg'] }} rounded-full flex items-center justify-center text-white font-bold">
                            @if($stari_dug['prefix'] == '-')
                                <x-heroicon-o-minus-circle class="w-6 h-6" />
                            @elseif($stari_dug['prefix'] == '+')
                                <x-heroicon-o-check-circle class="w-6 h-6" />
                            @else
                                <x-heroicon-o-check-circle class="w-6 h-6" />
                            @endif
                        </div>
                        <div>
                            <h3 class="font-semibold text-gray-900 dark:text-white mb-1 text-center">
                                Stari dug
                            </h3>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600 dark:text-gray-300">
                                Zaduženo:
                            </p>
                            <h3 class="font-semibold text-gray-900 dark:text-white mb-1">
                                {{ $stari_dug['zaduzeno_formated'] }}
                            </h3>
                            <p class="text-sm text-gray-600 dark:text-gray-300">
                                &nbsp;
                            </p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600 dark:text-gray-300">
                                Razduženo:
                            </p>
                            <h3 class="font-semibold text-gray-900 dark:text-white mb-1">
                                {{ $stari_dug['razduzeno'] }}
                            </h3>
                            <p class="text-sm text-gray-600 dark:text-gray-300">
                                &nbsp;
                            </p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600 dark:text-gray-300">
                                Saldo:
                            </p>
                            <h3 class="font-semibold text-gray-900 dark:text-white mb-1">
                                {{ $stari_dug['saldo'] }}
                            </h3>
                            <p class="text-sm text-gray-600 dark:text-gray-300">
                                &nbsp;
                            </p>
                        </div>
                    </div>
                </div>
            @endif

        <div class="bg-white dark:bg-gray-800 dark:border dark:border-gray-600 rounded-xl p-4 shadow-sm">
                <div class="flex items-center justify-between">
                    <div class="w-10 h-10 {{ $ukupno_dug['bg'] }} rounded-full flex items-center justify-center text-white font-bold">
                        @if($ukupno_dug['prefix'] == '-')
                            <x-heroicon-o-minus-circle class="w-6 h-6" />
                        @elseif($ukupno_dug['prefix'] == '+')
                            <x-heroicon-o-check-circle class="w-6 h-6" />
                        @else
                            <x-heroicon-o-check-circle class="w-6 h-6" />
                        @endif
                    </div>
                    <div>
                        <h3 class="font-semibold text-gray-900 dark:text-white mb-1 text-center">
                            Ukupno
                        </h3>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600 dark:text-gray-300">
                            Zaduženo:
                        </p>
                        <h3 class="font-semibold text-gray-900 dark:text-white mb-1">
                            {{ $ukupno_dug['zaduzeno'] }}
                        </h3>
                        <p class="text-sm text-gray-600 dark:text-gray-300">
                            &nbsp;
                        </p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600 dark:text-gray-300">
                            Razduženo:
                        </p>
                        <h3 class="font-semibold text-gray-900 dark:text-white mb-1">
                            {{ $ukupno_dug['razduzeno'] }}
                        </h3>
                        <p class="text-sm text-gray-600 dark:text-gray-300">
                            &nbsp;
                        </p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600 dark:text-gray-300">
                            Saldo:
                        </p>
                        <h3 class="font-semibold text-gray-900 dark:text-white mb-1">
                            {{ $ukupno_dug['saldo'] }}
                        </h3>
                        <p class="text-sm text-gray-600 dark:text-gray-300">
                            &nbsp;
                        </p>
                    </div>
            </div>
        </div>
        @endif
    </main>
    <!-- Footer -->
    <livewire:footer page="stanje" />
</div>