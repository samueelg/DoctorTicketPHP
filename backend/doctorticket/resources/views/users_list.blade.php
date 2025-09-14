<div>
    <h1>Teste</h1>

    @foreach ($users as $user)
        <h1>{{ $user->nome }}</h1>
        <p>{{ $user->ramal }}</p>
        <p>{{ $user->status }}</p>
        <p>{{ $user->tipo }}<p>
        <br>
    @endforeach
</div>
