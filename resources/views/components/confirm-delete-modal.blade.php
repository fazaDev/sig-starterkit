@props([
    'id',
    'action',
    'title' => 'Hapus data ini?',
    'description' => 'Tindakan ini tidak dapat dibatalkan.',
    'buttonLabel' => 'Ya, hapus',
])

<div
    id="{{ $id }}"
    tabindex="-1"
    aria-hidden="true"
    class="fixed inset-0 z-50 hidden h-full w-full overflow-y-auto overflow-x-hidden bg-gray-900/50 p-4"
>
    <div class="relative w-full max-w-md">
        <div class="relative rounded-lg bg-white p-4 shadow-sm dark:bg-gray-800 sm:p-5">
            <button
                type="button"
                class="absolute right-2.5 top-2.5 inline-flex items-center rounded-lg bg-transparent p-1.5 text-sm text-gray-400 hover:bg-gray-200 hover:text-gray-900 dark:hover:bg-gray-600 dark:hover:text-white"
                data-modal-hide="{{ $id }}"
            >
                <x-icon name="x" />
                <span class="sr-only">Tutup</span>
            </button>

            <div class="mb-4 flex h-11 w-11 items-center justify-center rounded-full bg-red-100 text-red-600 dark:bg-red-900 dark:text-red-300">
                <x-icon name="trash" />
            </div>

            <h3 class="mb-2 text-lg font-semibold text-gray-900 dark:text-white">{{ $title }}</h3>
            <p class="mb-4 text-sm text-gray-500 dark:text-gray-400">{{ $description }}</p>

            <form method="POST" action="{{ $action }}">
                @csrf
                @method('DELETE')

                <div class="flex items-center justify-end gap-3">
                    <button
                        type="button"
                        class="rounded-lg border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-900 hover:bg-gray-100 focus:outline-none focus:ring-4 focus:ring-gray-200 dark:border-gray-600 dark:bg-gray-800 dark:text-white dark:hover:bg-gray-700 dark:focus:ring-gray-700"
                        data-modal-hide="{{ $id }}"
                    >
                        Batal
                    </button>
                    <button
                        type="submit"
                        class="rounded-lg bg-red-600 px-4 py-2 text-sm font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-4 focus:ring-red-300 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-800"
                    >
                        {{ $buttonLabel }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
