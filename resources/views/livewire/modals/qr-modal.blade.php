<div class="bg-gray-50 dark:bg-gray-900">
    <div class="pointer-events-auto relative flex w-full flex-col rounded-md border-none bg-white dark:bg-gray-800 bg-clip-padding dark:text-white text-current shadow-4 outline-none">
      <div class="flex flex-shrink-0 items-center justify-between rounded-t-md border-b-2 border-neutral-100 p-4">
        <h5 class="text-xl font-medium leading-normal text-surface">
          Račun za {{ $data['m_naziv'] }} {{ $data['year'] }}
        </h5>
        <button type="button"
          class="box-content rounded-none border-none text-neutral-500 hover:text-neutral-800 dark:text-white hover:no-underline focus:text-neutral-800 focus:opacity-100 focus:shadow-none focus:outline-none"
          wire:click="$dispatch('closeModal')"
          >
          <span class="[&>svg]:h-6 [&>svg]:w-6">
            <svg
              xmlns="http://www.w3.org/2000/svg"
              fill="currentColor"
              viewBox="0 0 24 24"
              stroke-width="1.5"
              stroke="currentColor">
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                d="M6 18L18 6M6 6l12 12" />
            </svg>
          </span>
        </button>
      </div>


    <div class="flex justify-between">
        <div></div>
        <div class="p-2 dark:text-white">
            @if (!empty($qrCode))
                <h3>NBS QR Code: </h3>
                <div class="bg-white p-2 mb-2">{!! $qrCode !!}</div>
            @endif
            <div class="p-2 max-w-[304px]">
                <div class="mb-2text-gray-600 dark:text-gray-200">Podaci za uplatu:</div>
                <div class="text-gray-600 dark:text-gray-200">Primalac: </div>
                <div class="ml-2 font-bold">SZ {{ $qr_data['naziv'] }}</div>
                <div class="text-gray-600 dark:text-gray-200">Račun primaoca: </div>
                <div class="ml-2 font-bold">{{ $qr_data['tr'] }}</div>
                <div class="text-gray-600 dark:text-gray-200">Iznos: </div>
                <div class="ml-2 font-bold">{{ $data['zaduzeno'] }}</div>
                <div class="text-gray-600 dark:text-gray-200">Model: </div>
                <div class="ml-2 font-bold">00</div>
                <div class="text-gray-600 dark:text-gray-200">Poziv na broj: </div>
                <div class="ml-2 font-bold">{{ $poziv_na_broj_display }}</div>
            </div>
        </div>
        <div></div>
    </div>
</div>
