<div>
    <main class="px-4 py-6 pb-20 max-w-md mx-auto">
        <div class="bg-blue-500 dark:bg-blue-900 rounded-2xl mb-4 p-4 text-white flex justify-between">
            <div></div>
            <div>
                <div class="text-xl">SZ {{ $zgrada['naziv'] }}</div> 
                
                <div class="text-sm opacity-90 mt-2">{{ $stanje_zgrada[0]['fond'] }}:</div>
                <div class="flex">
                    <div class="mr-4 my-auto"><x-heroicon-o-wrench-screwdriver class="w-6 h-6 mt-1 mr-2" /></div>
                    <div class="text-2xl font-bold mb-1">{{ $stanje_zgrada[0]['stanja_formated'] }}</div>
                </div>
                <div class="text-sm opacity-90 mt-2">{{ $stanje_zgrada[1]['fond'] }}:</div>
                <div class="flex">
                    <div class="mr-4 my-auto"><x-heroicon-o-building-office-2 class="w-6 h-6 mt-1 mr-2" /></div>
                    <div class="text-2xl font-bold mb-1">{{ $stanje_zgrada[1]['stanja_formated'] }}</div>
                </div>
                <div class="text-sm opacity-90 mt-2">Ukupno stambena zajednica:</div>
                <div class="flex">
                    <div class="mr-4 my-auto"><x-heroicon-o-building-office class="w-8 h-8 mt-1 mr-2" /></div>
                    <div class="text-3xl font-bold mb-1">{{ $stanje_zgrada[2]['ukupno'] }}</div>
                </div>
                <div class="text-sm opacity-90">Datum poslednjeg obrađenog izvoda:</div>
                 <div class="font-bold ml-4">{{ $stanje_zgrada[2]['poslednje_knjizenje'] }}</div>
            </div>
            <div></div>
        </div>

        <div class="bg-orange-400 dark:bg-orange-800 rounded-2xl mb-4 p-4 text-white flex justify-between w-full">
            <div class="my-auto"><x-heroicon-o-information-circle class="w-8 h-8 mr-4" /></div>
            <div>
                <div class="text-sm font-bold">Informacija:</div>
                <div class="text-base">Poslovanje prikazuje iznose i stanje zaključno sa poslednjim obrađenim izvodom i ono može biti različito od stanja prikazanog na početnom ekranu.</div>
            </div>
            <div></div>
        </div>

        <!-- Uplate -->
        <button wire:click="showUplate" style="cursor: pointer;" class="mx-auto bg-gray-200 dark:bg-gray-600 rounded-xl p-4 shadow-sm mb-3 w-full">
            <div class="text-sm dark:text-white">Pregled poslovanja za poslednja dva meseca</div>
            <div class="flex justify-between">
                <div></div>
                <div>
                    <div class="flex">
                        <x-heroicon-o-document-text class="w-6 h-6 mt-1 mr-2 text-gray-600 dark:text-white" />
                        <h3 class="text-2xl font-bold text-gray-600 dark:text-white">
                            Poslovanje
                        </h3>
                        @if($ulpateDisplay)
                            <x-heroicon-o-chevron-down class="w-6 h-6 mt-1 ml-2 text-gray-700 dark:text-white" />
                        @else
                            <x-heroicon-o-chevron-up class="w-6 h-6 mt-1 ml-2 text-gray-700 dark:text-white" />
                        @endif
                    </div>
                </div>
                <div></div> 
            </div>   
        </button>

        @if($ulpateDisplay)
            <div class="space-y-3" >
                @foreach ($poslovanje as $transakcija)
                    <div class="bg-white dark:bg-gray-800 dark:border dark:border-gray-600 rounded-xl p-2 shadow-sm">
                        <div class="flex items-center justify-between">
                            <div class="flex">
                                <div class="w-4 h-4 {{ $transakcija['bg'] }} rounded-full flex items-center justify-center text-white font-bold mt-1">
                                    @if($transakcija['vrsta'] == 'Uplata') 
                                        <x-heroicon-c-arrow-turn-right-up class="w-3 h-3"/>
                                    @else
                                        <x-heroicon-c-arrow-turn-right-down class="w-3 h-3"/>
                                    @endif
                                </div>
                                <div class="text-gray-600 dark:text-gray-200 text-sm ml-2">{{ $transakcija['vrsta'] }}</div> 
                                <div class="text-gray-600 dark:text-gray-200 text-sm ml-2 font-bold">{{ $transakcija['datum_display'] }}</div> 
                            </div>

                            <div>
                                <h3 class="font-semibold text-gray-900 dark:text-white">
                                    {{ $transakcija['iznos_display'] }}
                                </h3>
                            </div>
                        </div>
                       
                        <div class="text-sm text-gray-600 dark:text-gray-300 flex mb-2">
                            <div class="min-w-[50px]"> @if($transakcija['vrsta'] == 'Uplata') Uplatilac: @else Primaoc: @endif</div>
                            <div class="pl-4">{{ $transakcija['naziv'] }}</div>
                        </div>

                        <div class="text-sm text-gray-600 dark:text-gray-300 flex">
                            <div class="min-w-[50px]"> Opis: </div>
                            <div class="pl-4">{{ $transakcija['opis'] }}</div>
                        </div>

                        <div class="text-sm text-gray-600 dark:text-gray-300 flex">
                            <div class="min-w-[50px]"> Fond: </div>
                            <div class="pl-4">{{ $transakcija['fond'] }}</div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </main>
    <!-- Footer -->
    <livewire:footer page="poslovanje" :prikaz="$zgrada['stanje']"/>
</div>
