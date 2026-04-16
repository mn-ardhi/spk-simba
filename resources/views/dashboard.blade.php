<x-layouts::app :title="__('Dashboard Pendaftaran Beasiswa')">
    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl p-4 md:p-6 lg:p-8 bg-gray-50 dark:bg-neutral-900">
        
        <livewire:form-pendaftaran />

        <livewire:admin-pendaftar />
        
        <livewire:admin-hasil-seleksi />

    </div>
</x-layouts::app>