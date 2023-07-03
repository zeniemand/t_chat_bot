
        Помилка в {{ env('APP_NAME') }}
        <b>Опис: </b> <code>{{ $description }}</code>
        <b>Файл: </b> <code>{{ $file }}</code>
        <b>Стрічка: </b> <code>{{ $line }}</code>
        @if(Auth::user())
        <b>Користувач: </b> <a href="t.me/{{ Auth::user()->telegram_username }}">{{ Auth::user()->firstname }} {{ Auth::user()->lastname }}</a>
        @endif
