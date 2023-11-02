<x-filament-panels::page>
    {{-- <div>
        <form wire:submit="save" class="w-full max-w-sm flex mt-2">
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="fileInput">Upload Client</label>
                <input wire:model="file" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="fileInput" type="file">
            </div>
            <div class="flex items-center justify-between mt-3">
                <button class="font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="submit">Submit</button>
            </div>
        </form>
    </div> --}}

    {{ $this->table }}
</x-filament-panels::page>
