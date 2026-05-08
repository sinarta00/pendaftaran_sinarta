<!-- resources/views/filament/widgets/quick-actions.blade.php -->
<div class="fi-wi-quick-actions">
    <div class="fi-section-header">
        <div class="fi-section-header-heading">
            <h3 class="fi-section-title">
                Aksi Cepat
            </h3>
        </div>
    </div>
    
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mt-4">
        @foreach($actions as $action)
            <div class="fi-stats-card relative rounded-xl bg-white p-6 shadow-sm ring-1 ring-gray-950/5 dark:bg-gray-900 dark:ring-white/10">
                <div class="flex items-center justify-center">
                    {{ $action }}
                </div>
            </div>
        @endforeach
    </div>
</div>