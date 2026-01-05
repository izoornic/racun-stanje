<div>
    <!-- Main Content -->
    <main class="px-4 py-6 pb-20 max-w-md mx-auto">
        <!-- Vlasnik -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-sm mb-4 flex justify-between">
            <div></div>
            <div>
                <div class="flex justify-between">
                    <div class="text-gray-600 dark:text-gray-200">Vlasnik:</div>
                    <div class="text-gray-600 dark:text-gray-200"> @if($vlasnik['pib']) Pravno @else Fizičko @endif lice</div>
                </div>
                <div class="flex ml-4 ">
                    <x-heroicon-o-user-circle class="w-6 h-6 mt-1 mr-3 dark:text-white" />
                    <h2 class="text-2xl font-bold text-gray-900 dark:text-white">
                        {{ $vlasnik['vlasnik'] }}
                    </h2>
                </div>

                @if($vlasnik['pib'] || $vlasnik['povrsina'] == 0)
                    @if($vlasnik['pib'])
                        <div class="text-gray-600 dark:text-gray-200">PIB: <span class="font-bold">{{ $vlasnik['pib'] }}</span></div>
                        <div class="text-gray-600 dark:text-gray-200">MB: <span class="font-bold">{{ $vlasnik['mb'] }}</span></div>
                    @endif
                    <div class="flex text-gray-600 dark:text-gray-200">
                        <div>Adresa:</div> 
                        <div>
                            <div class="ml-2 font-bold">{{ $vlasnik['adresa'] }}</div>
                            <div class="ml-2 font-bold">{{ $vlasnik['zip'] }} {{ $vlasnik['sediste'] }}</div>
                        </div>
                    </div>
                @endif

                <div class="flex mt-4 text-gray-600 dark:text-gray-200">
                    @if($vlasnik['naziv'] == 'stan')
                        <x-heroicon-o-home class="w-4 h-4 mt-1 mr-2 dark:text-white" />
                    @elseif($vlasnik['naziv'] == 'lokal')
                        <x-heroicon-o-building-storefront class="w-4 h-4 mt-1 mr-2 dark:text-white" />
                    @elseif($vlasnik['naziv'] == 'garaza')
                        <x-heroicon-s-building-library class="w-4 h-4 mt-1 mr-2 dark:text-white" />
                    @endif
                    Vrsta posebnog dela:&nbsp;
                    <span class="font-bold">{{ $vlasnik['naziv'] }}</span>
                </div>
                <div class="text-gray-600 dark:text-gray-200">Adresa: <span class="font-bold">{{ $zgrada['adresa'] }}-{{ $vlasnik['stanbr'] }}</span></div>
                <div class="text-gray-600 dark:text-gray-200">Površina: <span class="font-bold">{{ $vlasnik['povrsina'] }} m<sup>2</sup></span></div>
                <div class="text-gray-600 dark:text-gray-200">Vlasništvo: <span class="font-bold">{{ $vlasnik['vlasnistvo'] }} %</span></div>
                <div class="text-gray-600 dark:text-gray-200">Email: <span class="font-bold">{{ $vlasnik['email'] }}</span></div>
                <div class="text-gray-600 dark:text-gray-200">Račun se šalje na email: <span class="font-bold">@if($vlasnik['email'] && $vlasnik['rac_na_email'] == 1) Da @else Ne @endif</span></div>
                <div class="text-gray-600 dark:text-gray-200">Račun se štampa: <span class="font-bold">@if($vlasnik['rac_se_stampa'] == 1) Da @else Ne @endif</span></div>
            </div>
            <div></div>
        </div>

        <!-- Zgrada -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-sm mb-4 flex justify-between">
            <div></div>
            <div>
                <div class="flex justify-between">
                    <div class="text-gray-600 dark:text-gray-200">Stambena zajednica:</div>
                    <div class="text-gray-600 dark:text-gray-200"> &nbsp; </div>
                </div>
                <div class="flex ml-4 ">
                    <x-heroicon-o-building-office class="w-6 h-6 mt-1 mr-3 dark:text-white" />
                    <h2 class="text-2xl font-bold text-gray-900 dark:text-white">
                        SZ {{ $zgrada['naziv'] }}
                    </h2>
                </div>
                <div class="flex mt-4 text-gray-600 dark:text-gray-200">
                    <div>Adresa:</div> 
                    <div>
                        <div class="ml-2 font-bold">{{ $zgrada['adresa'] }}</div>
                        <div class="ml-2 font-bold">{{ $zgrada['zip'] }} {{ $zgrada['sediste'] }}</div>
                    </div>
                </div>
                <div class="text-gray-600 dark:text-gray-200">PIB: <span class="font-bold">{{ $zgrada['pib'] }}</span></div>
                <div class="text-gray-600 dark:text-gray-200">MB: <span class="font-bold">{{ $zgrada['mb'] }}</span></div>
                <div class="text-gray-600 dark:text-gray-200">Tekuci račun:</div>
                <div class="ml-4 text-gray-600 dark:text-gray-200 font-bold">{{   $zgrada['tr'] }}</div>
                <div class="text-gray-600 dark:text-gray-200">Banka: <span class="font-bold">{{ $zgrada['banka'] }}</span></div>

            </div>
            <div></div>
        </div>
        @if(count($garaze) > 0)
            <!-- Garaze -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-sm mb-4 flex justify-between">
                <div></div>
                <div>
                    <div class="flex ml-4 ">
                        <x-heroicon-s-building-library class="w-6 h-6 mt-1 mr-3 dark:text-white" />
                        <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Garaže</h2>
                    </div>
                    @foreach ($garaze as $garaza)
                        <div class="mt-2 text-gray-600 dark:text-gray-200">Vrsta: <span class="font-bold">{{ $garaza['naziv_display'] }}</span> Površina: <span class="font-bold">{{ $garaza['gpovrsina'] }} m<sup>2</sup></span></div>    
                    @endforeach
                   
                </div>
                <div></div>
            </div>
        @endif
    </main>
    <!-- Footer -->
    <livewire:footer page="profil"/>
</div>
