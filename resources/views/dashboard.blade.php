<x-app-layout>
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
    <section>
        <div class="container">
            <div class="row mt-5">
                <div class="areas">
                    <a href="#">
                        <div class="card px-4 py-2">
                            <div class="card-body d-flex gap-2 justify-between align-items-center">
                                <i class="fa-solid fa-folder fs-1"></i>
                                <span class="title_card">Jurídica</span>
                            </div>
                        </div>
                    </a>
                    <a href="#">
                        <div class="card px-4 py-2">
                            <div class="card-body d-flex gap-2 justify-between align-items-center">
                                <i class="fa-solid fa-folder fs-1"></i>
                                <span class="title_card">Distribución</span>
                            </div>
                        </div>
                    </a>
                    <a href="{{url('/menu/socios')}}">
                        <div class="card px-4 py-2">
                            <div class="card-body d-flex gap-2 justify-between align-items-center">
                                <i class="fa-solid fa-folder fs-1"></i>
                                <span class="title_card">Socios</span>
                            </div>
                        </div>
                    </a>
                    <a href="#">
                        <div class="card px-4 py-2">
                            <div class="card-body d-flex gap-2 justify-between align-items-center">
                                <i class="fa-solid fa-folder fs-1"></i>
                                <span class="title_card">Bienestar</span>
                            </div>
                        </div>
                    </a>

                </div>
            </div>
        </div>
    </section>

</x-app-layout>