<a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="javascript:void(0);" role="button">
    <img src="/assets/flags/{{ session('localization','en')}}.png" alt="" height="20">
</a>
<div class="dropdown-menu dropdown-menu-right">

    @foreach (config('localizations.locales') as $key => $locale)

    <a href="{{ route('localization', $key) }}" class="dropdown-item {{ session('localization') == $key ? 'active' : '' }}">
        <img src="/assets/flags/{{ $key}}.png" alt="" height="16"> {{ strtoupper($locale) }}
    </a>

@endforeach
</div>