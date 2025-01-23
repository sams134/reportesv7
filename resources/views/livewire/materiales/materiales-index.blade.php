<div>
    {{-- Because she competes with no one, no one can compete with her. --}}

    <x-page-title>
        <x-slot:title>Listado de Materiales</x-slot:title>
        Vea todos los clientes en el sistema
    </x-page-title>
    <div class="card mb-3">
        <div class="bg-holder d-none d-lg-block bg-card"
            style="background-image:url(/img/icons/spot-illustrations/corner-2.png);">
        </div>
        <!--/.bg-holder-->
        <div class="card-body position-relative">
            <div class="row">
                <div class="col-lg-12">
                    <a class="btn btn-danger me-1 mb-3" type="button" href="">Agregar
                        Material
                    </a>
                    <div class="input-group mb-3">

                        <input class="form-control" type="text" placeholder="Buscar Material"
                            aria-label="BuscarMaterial" aria-describedby="basic-addon1" wire:model="search" />

                        <button class="btn btn-primary " type="button">
                            <i class="fa fa-search"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div class="card mb-3">
            <div class="bg-holder d-none d-lg-block bg-card"
                style="background-image:url(/img/icons/spot-illustrations/corner-3.png);">
            </div>
            <div class="card-body position-relative">
                <div class="row">
                    <div class="col-12">
                        {{-- ``empieza la tabla
                         --}}
                        <div class="table-responsive scrollbar">
                            <div class="table-responsive scrollbar">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th scope="col">Name</th>
                                            <th scope="col">Email</th>
                                            <th scope="col"> </th>
                                            <th scope="col">joined</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr class="hover-actions-trigger">
                                            <td class="align-middle text-nowrap">
                                                <div class="d-flex align-items-center">
                                                    <div class="avatar avatar-xl">
                                                        <img class="rounded-circle" src="../../assets/img/team/4.jpg"
                                                            alt="" />
                                                    </div>
                                                    <div class="ms-2">Ricky Antony</div>
                                                </div>
                                            </td>
                                            <td class="align-middle text-nowrap">ricky@example.com</td>
                                            <td class="w-auto">
                                                <div class="btn-group btn-group hover-actions end-0 me-4">
                                                    <button class="btn btn-light pe-2" type="button"
                                                        data-bs-toggle="tooltip" data-bs-placement="top"
                                                        title="Edit"><span class="fas fa-edit"></span></button>
                                                    <button class="btn btn-light ps-2" type="button"
                                                        data-bs-toggle="tooltip" data-bs-placement="top"
                                                        title="Delete"><span class="fas fa-trash-alt"></span></button>
                                                </div>
                                            </td>
                                            <td class="align-middle text-nowrap">30/03/2018</td>
                                        </tr>
                                        <tr class="hover-actions-trigger">
                                            <td class="align-middle text-nowrap">
                                                <div class="d-flex align-items-center">
                                                    <div class="avatar avatar-xl">
                                                        <img class="rounded-circle" src="../../assets/img/team/13.jpg"
                                                            alt="" />
                                                    </div>
                                                    <div class="ms-2">Emma Watson</div>
                                                </div>
                                            </td>
                                            <td class="align-middle text-nowrap">emma@example.com</td>
                                            <td class="w-auto">
                                                <div class="btn-group btn-group hover-actions end-0 me-4">
                                                    <button class="btn btn-light pe-2" type="button"
                                                        data-bs-toggle="tooltip" data-bs-placement="top"
                                                        title="Edit"><span class="fas fa-edit"></span></button>
                                                    <button class="btn btn-light ps-2" type="button"
                                                        data-bs-toggle="tooltip" data-bs-placement="top"
                                                        title="Delete"><span class="fas fa-trash-alt"></span></button>
                                                </div>
                                            </td>
                                            <td class="align-middle text-nowrap">11/07/2017</td>
                                        </tr>
                                        <tr class="hover-actions-trigger">
                                            <td class="align-middle text-nowrap">
                                                <div class="d-flex align-items-center">
                                                    <div class="avatar avatar-xl">
                                                        <div class="avatar-name rounded-circle"><span>RA</span></div>
                                                    </div>
                                                    <div class="ms-2">Rowen Atkinson</div>
                                                </div>
                                            </td>
                                            <td class="align-middle text-nowrap">rown@example.com</td>
                                            <td class="w-auto">
                                                <div class="btn-group btn-group hover-actions end-0 me-4">
                                                    <button class="btn btn-light pe-2" type="button"
                                                        data-bs-toggle="tooltip" data-bs-placement="top"
                                                        title="Edit"><span class="fas fa-edit"></span></button>
                                                    <button class="btn btn-light ps-2" type="button"
                                                        data-bs-toggle="tooltip" data-bs-placement="top"
                                                        title="Delete"><span class="fas fa-trash-alt"></span></button>
                                                </div>
                                            </td>
                                            <td class="align-middle text-nowrap">05/04/2016</td>
                                        </tr>
                                        <tr class="hover-actions-trigger">
                                            <td class="align-middle text-nowrap">
                                                <div class="d-flex align-items-center">
                                                    <div class="avatar avatar-xl">
                                                        <img class="rounded-circle" src="../../assets/img/team/2.jpg"
                                                            alt="" />
                                                    </div>
                                                    <div class="ms-2">Antony Hopkins</div>
                                                </div>
                                            </td>
                                            <td class="align-middle text-nowrap">antony@example.com</td>
                                            <td class="w-auto">
                                                <div class="btn-group btn-group hover-actions end-0 me-4">
                                                    <button class="btn btn-light pe-2" type="button"
                                                        data-bs-toggle="tooltip" data-bs-placement="top"
                                                        title="Edit"><span class="fas fa-edit"></span></button>
                                                    <button class="btn btn-light ps-2" type="button"
                                                        data-bs-toggle="tooltip" data-bs-placement="top"
                                                        title="Delete"><span class="fas fa-trash-alt"></span></button>
                                                </div>
                                            </td>
                                            <td class="align-middle text-nowrap">05/04/2018</td>
                                        </tr>
                                        <tr class="hover-actions-trigger">
                                            <td class="align-middle text-nowrap">
                                                <div class="d-flex align-items-center">
                                                    <div class="avatar avatar-xl">
                                                        <img class="rounded-circle" src="../../assets/img/team/3.jpg"
                                                            alt="" />
                                                    </div>
                                                    <div class="ms-2">Jennifer Schramm</div>
                                                </div>
                                            </td>
                                            <td class="align-middle text-nowrap">jennifer@example.com</td>
                                            <td class="w-auto">
                                                <div class="btn-group btn-group hover-actions end-0 me-4">
                                                    <button class="btn btn-light pe-2" type="button"
                                                        data-bs-toggle="tooltip" data-bs-placement="top"
                                                        title="Edit"><span class="fas fa-edit"></span></button>
                                                    <button class="btn btn-light ps-2" type="button"
                                                        data-bs-toggle="tooltip" data-bs-placement="top"
                                                        title="Delete"><span class="fas fa-trash-alt"></span></button>
                                                </div>
                                            </td>
                                            <td class="align-middle text-nowrap">17/03/2016</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
