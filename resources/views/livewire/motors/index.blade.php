<div>
    <table
    class="table mb-0 table-borderless fs--2 border-200 overflow-hidden table-running-project table-hover">
    <thead class="bg-light">
        <tr class="text-800">
            <th style="width:30px"><input type="checkbox" name="" id=""> </th>
            <th style="width:1rem"></th>
            <th class="sort" style="width:15%">Orden de Servicio</th>
            <th class="sort" style="width:25%">Cliente</th>
            <th class="sort ">Potencia</th>
            <th class="sort ">Estado</th>
            <th class="sort ">Progreso</th>
            <th>Tecnicos</th>
            <th class="text-end">Acciones</th>
        </tr>
    </thead>
    @foreach ($motores as $motor)
    <tr>
        <td style="width:30px"><input type="checkbox" name="" id="" class="align-bottom"></td>
        <td>
           
        </td>
        <td>
            {{$motor->year}}-{{$motor->os}}
            
        </td>
        <td class="align-middle">{{$motor->cliente->cliente}}</td>
    </tr>
    @endforeach
    </table>
</div>