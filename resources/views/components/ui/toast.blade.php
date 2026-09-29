@props(['duration' => 5000])

<div id="toast-container" class="fixed top-6 left-1/2 -translate-x-1/2 z-50 flex flex-col gap-3 items-center pointer-events-none">
    @if (session('Success'))
        <x-ui.toast-card type="success" :message="session('Success')" :duration="$duration" />
    @endif

    @if (session('Error'))
        <x-ui.toast-card type="error" :message="session('Error')" :duration="$duration" />
    @endif

    @if ($errors->any())
        @foreach ($errors->all() as $error)
            <x-ui.toast-card type="error" :message="$error" :duration="$duration" />
        @endforeach
    @endif
</div>
