<div class="table-responsive scrollbar" style="max-height: 350px; overflow: auto;">
    <span wire:loading> Loading</span>
    <table class="table mb-0 minitabla table-hover table-striped" style="font-size: 12px;"
        wire:loading.class="opacity-50">
        <thead class="text-black bg-200">
            <tr>
                
                <th class="align-middle" width="15%">Cant</th>
                <th class="align-middle" >Material</th>
                <th class="align-middle" width="30%">Presentacion</th>
                <th class="align-middle" width="10%">Entregado</th>
            </tr>
        </thead>
        <tbody id="bulk-select-body">
            @foreach ($motor->materialesPedidos->sortByDesc('id') as $material)
                <tr>
                    <td class="align-middle">{{ $material->cantidad }}</td>
                    <td class="align-middle">{{ $material->material }}</td>
                    <td class="align-middle">{{ $material->presentacion }}</td>
                    <td class="align-middle">
                       
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
   
    
</div>
