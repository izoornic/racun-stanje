<div>
   <nav class="fixed bottom-0 left-0 right-0 bg-white dark:bg-gray-800 border-t border-gray-200 dark:border-gray-700 px-4 pb-2">
        <div class="flex items-center justify-around max-w-md mx-auto">
            @if($page == 'stanje')
                <div class="flex flex-col items-center py-2 text-blue-500">
                    <x-heroicon-o-home class="w-6 h-6 mb-1"/>
                    <span class="text-xs">Stanje</span>
                </div>
            @else
                <button wire:click="showStanje" class="flex flex-col items-center py-2 text-gray-600 dark:text-gray-300">
                    <x-heroicon-o-home class="w-6 h-6 mb-1"/>
                    <span class="text-xs">Stanje</span>
                </button>
            @endif

            @if($prikaz == 'poslovanje')
                @if($page == 'poslovanje')
                    <div class="flex flex-col items-center py-2 text-blue-500">
                        <x-heroicon-o-building-office class="w-6 h-6 mb-1"/>
                        <span class="text-xs">Poslovanje</span>
                    </div>
                @else
                    <button wire:click="showPoslovanje" class="flex flex-col items-center py-2 text-gray-600 dark:text-gray-300">
                        <x-heroicon-o-building-office class="w-6 h-6 mb-1"/>
                        <span class="text-xs">Poslovanje</span>
                    </button>
                @endif
            @endif

            @if($page == 'profil')
                <div class="flex flex-col items-center py-2 text-blue-500">
                    <x-heroicon-o-user class="w-6 h-6 mb-1"/>
                    <span class="text-xs">Profil</span>
                </div>
            @else
                <button wire:click="showProfil" class="flex flex-col items-center py-2 text-gray-600 dark:text-gray-300">
                    <x-heroicon-o-user class="w-6 h-6 mb-1"/>
                    <span class="text-xs">Profil</span>
                </button>
            @endif
        </div>
        <div class="flex justify-between m-0 py-0 max-h-[8px]"> 
            <div>&nbsp;</div>
            <div class="text-xs leading-none text-gray-700 dark:text-gray-400">{{ config('global.siteFooter') }}</div>
            <div class="text-right text-xs leading-none text-gray-700 dark:text-gray-400">{{ config('global.version') }}</div>
        </div>
    </nav>
</div>
