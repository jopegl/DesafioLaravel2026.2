@props(['namePrefix' => null])

@php
$fieldName = fn (string $field) => $namePrefix ? "{$namePrefix}[{$field}]" : $field;
@endphp

<div>
    <label class="block text-gray-400 text-xs mb-1">CEP</label>
    <div class="flex items-center gap-2">
        <input type="text" name="{{ $fieldName('zip_code') }}" maxlength="8" required
            x-model="addr.zip_code"
            @input="onZipInput()"
            placeholder="Somente números"
            class="w-full bg-[#15171e] border border-gray-700 rounded-lg px-3 py-2 text-white text-sm focus:outline-none focus:ring-1 focus:ring-cyan-400">
        <span x-show="cepLoading" class="text-xs text-gray-400 whitespace-nowrap">buscando...</span>
    </div>
    <p x-show="cepError" x-text="cepError" class="text-red-400 text-xs mt-1"></p>
</div>

<div>
    <label class="block text-gray-400 text-xs mb-1">Rua</label>
    <input type="text" name="{{ $fieldName('street') }}" x-model="addr.street" required
        class="w-full bg-[#15171e] border border-gray-700 rounded-lg px-3 py-2 text-white text-sm focus:outline-none focus:ring-1 focus:ring-cyan-400">
</div>

<div class="flex gap-3">
    <div class="flex-1">
        <label class="block text-gray-400 text-xs mb-1">Número</label>
        <input type="text" name="{{ $fieldName('number') }}" x-model="addr.number" required
            class="w-full bg-[#15171e] border border-gray-700 rounded-lg px-3 py-2 text-white text-sm focus:outline-none focus:ring-1 focus:ring-cyan-400">
    </div>
    <div class="flex-1">
        <label class="block text-gray-400 text-xs mb-1">Bairro</label>
        <input type="text" name="{{ $fieldName('neighborhood') }}" x-model="addr.neighborhood" required
            class="w-full bg-[#15171e] border border-gray-700 rounded-lg px-3 py-2 text-white text-sm focus:outline-none focus:ring-1 focus:ring-cyan-400">
    </div>
</div>

<div class="flex gap-3">
    <div class="flex-1">
        <label class="block text-gray-400 text-xs mb-1">Cidade</label>
        <input type="text" name="{{ $fieldName('city') }}" x-model="addr.city" required
            class="w-full bg-[#15171e] border border-gray-700 rounded-lg px-3 py-2 text-white text-sm focus:outline-none focus:ring-1 focus:ring-cyan-400">
    </div>
    <div class="w-20">
        <label class="block text-gray-400 text-xs mb-1">UF</label>
        <input type="text" name="{{ $fieldName('state') }}" maxlength="2" x-model="addr.state" required
            class="w-full bg-[#15171e] border border-gray-700 rounded-lg px-3 py-2 text-white text-sm focus:outline-none focus:ring-1 focus:ring-cyan-400">
    </div>
</div>

<div>
    <label class="block text-gray-400 text-xs mb-1">Complemento</label>
    <input type="text" name="{{ $fieldName('complement') }}" x-model="addr.complement"
        class="w-full bg-[#15171e] border border-gray-700 rounded-lg px-3 py-2 text-white text-sm focus:outline-none focus:ring-1 focus:ring-cyan-400">
</div>