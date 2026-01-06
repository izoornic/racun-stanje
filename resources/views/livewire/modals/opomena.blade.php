<div class="bg-gray-50 dark:bg-gray-900">
    <div class="pointer-events-auto relative flex w-full flex-col rounded-md border-none bg-white dark:bg-gray-800 bg-clip-padding dark:text-white text-current shadow-4 outline-none">
      <div class="flex flex-shrink-0 items-center justify-between rounded-t-md border-b-2 border-neutral-100 p-4">
        <h5 class="text-xl font-medium leading-normal text-surface">
          {{ $data['naslov'] }}
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


    <div class="p-4">
        <p class="mb-2">{{ $data['text'][0] }}</p>
        <p class="mb-2">{{ $data['text'][1] }} {{ $data['saldo'] }} {{ $data['text'][2] }}</p>
        <p class="mb-2">@if($data['rbr'] == 1) {{ $data['text'][4] }} @else {{ $data['text'][3] }} @endif </p>
        <p class="mb-2">{{ $data['text'][5] }}</p>
    </div>
    <div class="min-h-48">
        &nbsp;
    </div>
</div>