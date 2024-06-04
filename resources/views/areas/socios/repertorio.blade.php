<x-app-layout>
    <section style="height: 40vh;" class="bg-secondary">
        <div class="container h-100 w-100 d-flex flex-column justify-center align-items-center">
            <div class="w-75">
                <div class="d-block fw-medium my-2">Buscador de socios</div>
                <form action="/menu/socios/repertorio/buscar" method="POST" class="d-flex">
                    @csrf
                    <input type="text" class="form-control m-auto" name="data_buscar" id="buscar_identificacion" placeholder="Ingresa número de identificación">
                    <button type="submit" class="btn btn-primary">Buscar</button>
                </form>
            </div>
        </div>
    </section>

    <section>
        <div class="container">
            <div class="row mt-5">
                <div class="d-flex flex-row-reverse gap-3 my-3">
                    <div class="btn btn-secondary">Exportar excel</div>
                    <div class="btn btn-secondary">Nuevo socio</div>
                </div>
                <table class="table" id="data-table-socios-repertorio">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Identificación</th>
                            <th scope="col">Nombre</th>
                            <th scope="col"></th>
                        </tr>
                    </thead>
                    <tbody>

                    
                        @foreach($socios as $socio)
                        <tr>
                            <th scope="row">{{$socio->id}}</th>
                            <td>{{$socio->identificacion}}</td>
                            <td>{{$socio->nombre}}</td>
                            <td>
                                <a href=""><i class="fa-solid fa-circle-info"></i></a>
                                <a href=""><i class="fa-solid fa-trash-can"></i></a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

               
            </div>
        </div>
    </section>



</x-app-layout>