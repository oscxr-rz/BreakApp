<div>
    @foreach ($ordenes as $orden)
        <p>{{ $orden['id_orden'] }}</p>
        <p>{{ $orden['usuario'] }}</p>
    @endforeach
</div>
