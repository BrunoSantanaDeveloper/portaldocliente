<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __("A.R's") }}
        </h2>
    </x-slot>

    <div class="main-content">

        <div class="page-content">
            <div class="container-fluid">

                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title"></h4>
                                <p class="card-title-desc">
                                   
                                </p>

                                <div class="table-responsive">
                                    <table class="table mb-0 ">
                                        <thead class="text-center">
                                            <tr>
                                                <th>P. Compra</th>
                                                <th>P. Venda</th>
                                                <th>N.F.</th>
                                                <th>Data Fat</th>
                                                <th>Total</th>
                                                <th>Status</th>
                                                <th>XML</th>
                                                <th>Opções</th>
                                            </tr>
                                        </thead>
                                        <tbody class="text-center">
                                            @foreach($objects as $object)
                                            <tr>
                                                <th scope="row">{{$object->PEDIDO_CLIENTE}}</th>
                                                <th scope="row">{{$object->PEDIDO_VENDA}}</th>
                                                <td>{{$object->NOTA_FISCAL}}</td>
                                                <td>{{date('d/m/Y', strtotime($object->DATA_FATURAMENTO))}}</td>
                                                <td>{{$object->VALOR_NOTA}}</td>
                                                <td><span class="badge bg-{{$object->status_class}} font-size-12">{{$object->status}}</span></td>
                                                <td></td>
                                                <td class="text-center">
                                                    <div class="dropdown">
                                                        <a href="#" class="dropdown-toggle card-drop" data-bs-toggle="dropdown" aria-expanded="false">
                                                            <i class="mdi mdi-dots-horizontal font-size-18"></i>
                                                        </a>
                                                        <div class="dropdown-menu dropdown-menu-end" style="">
                                                            <a class="dropdown-item ar-details-button" type="button" data-id="{{$object->NOTA_FISCAL}}"><i class="bx bx-detail font-size-16 align-middle me-1"></i> <span>Mais Detalhes</span></a>
                                                            <div class="dropdown-divider"></div>
                                                            <a class="dropdown-item ar-approve-button" type="button" nf="{{$object->NOTA_FISCAL}}" order="{{$object->PEDIDO_VENDA}}"><i class="bx bx-check-circle font-size-16 align-middle text-success me-1"></i> <span>Aprovar</span></a>
                                                            <a class="dropdown-item ar-reject-button" type="button" nf="{{$object->NOTA_FISCAL}}" order="{{$object->PEDIDO_VENDA}}"><i class="bx bx-x-circle font-size-16 align-middle text-danger me-1"></i> <span>Rejeitar</span></a>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                            @endforeach
                                            
                                        </tbody>
                                    </table>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                <!-- end row -->
                {{-- {{dd($results['header'])}} --}}
                <div class="row">
                    <div class="col-lg-12">
                        <ul class="pagination pagination-rounded justify-content-center mt-2 mb-5">
                            <li class="page-item {{$PreviousPage}}">
                                <a href="{{$LinkPreviousPage}}" class="page-link"><i class="mdi mdi-chevron-left"></i></a>
                            </li>
                            <li class="page-item {{$FirstPage}}">
                                <a href="{{route('receivement.get-receivement',['page' => 1])}}" class="page-link"><b>1</b></a>
                            </li>
                            <li class="page-item {{$ActivePage}}">
                                <a href="{{$LinkAtualPage}}" class="page-link">{{$AtualPage}}</a>
                            </li>
                            <li class="page-item">
                                <a href="{{$LinkNextPage}}" class="page-link">{{$NextPage}}</a>
                            </li>
                            <li class="page-item">
                                <a href="{{route('receivement.get-receivement',['page' => $PageCount[0] ])}}" class="page-link text-bold"><b>{{$PageCount[0]}}</b></i></a>
                            </li>
                            <li class="page-item">
                                <a href="{{$LinkNextPage}}" class="page-link"><i class="mdi mdi-chevron-right"></i></a>
                            </li>
                        </ul>
                    </div>
                </div>

            </div> <!-- container-fluid -->
        </div>
        <!-- End Page-content -->
    </div>
</x-app-layout>
@include('modals.ar.details')
@include('modals.ar.reject-order')