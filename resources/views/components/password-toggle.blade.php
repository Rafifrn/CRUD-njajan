<div class="relative">
    {{ $slot }}
    <button type="button" tabindex="-1"
            onclick="const i=this.parentElement.querySelector('input'),s=i.type==='password';i.type=s?'text':'password';this.textContent=s?'Tutup':'Lihat'"
            class="absolute inset-y-0 right-3 my-auto h-fit text-xs font-semibold text-gray-500 hover:text-gray-800">Lihat</button>
</div>
