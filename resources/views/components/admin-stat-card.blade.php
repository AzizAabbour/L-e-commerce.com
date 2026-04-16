@props(['title', 'value', 'icon', 'color'])

<div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-100 flex items-center gap-6 group hover:shadow-md transition-shadow">
    <div class="w-14 h-14 {{ $color }} rounded-2xl flex items-center justify-center text-white text-2xl shadow-lg transition-transform group-hover:scale-110">
        <i class="fa-solid {{ $icon }}"></i>
    </div>
    <div>
        <div class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1">{{ $title }}</div>
        <div class="text-2xl font-black text-slate-800 tracking-tight">{{ $value }}</div>
    </div>
</div>
