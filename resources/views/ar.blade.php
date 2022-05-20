<x-app-layout>
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0 font-size-18">Pedidos</h4>

            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Pedidos</a></li>
                    <li class="breadcrumb-item active">Painel</li>
                </ol>
            </div>

        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title mb-4">Aprovar/Recusar Pedidos</h4>
                <div class="table-responsive">
                    <table class="table align-middle table-nowrap mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="align-middle">P. Compra</th>
                                <th class="align-middle">P. Venda</th>
                                <th class="align-middle">N.F.</th>
                                <th class="align-middle">Data Fat</th>
                                <th class="align-middle">Total</th>
                                <th class="align-middle">Status</th>
                                <th class="align-middle text-center">XML</th>
                                <th class="align-middle">Opções</th>
                            </tr>
                        </thead>
                        <tbody>

                            @foreach($objects as $object)
                            <tr>
                                <th class="text-body fw-bold">{{$object->PEDIDO_CLIENTE}}</th>
                                <th scope="row">{{$object->PEDIDO_VENDA}}</th>
                                <td>{{$object->NOTA_FISCAL}}</td>
                                <td>{{date('d/m/Y', strtotime($object->DATA_FATURAMENTO))}}</td>
                                <td>{{$object->VALOR_NOTA}}</td>
                                <td><span class="badge bg-{{$object->status_class}} font-size-12">{{$object->status}}</span></td>
                                <td>
                                    <div class="text-center">
                                        <a  class="text-dark" href="{{route('receivement.get-xml',['ntrans' => $object->TRANSACAO])}}" ><i class="bx bx-download h3 m-0"></i></a>
                                    </div>
                                </td>
                                <td class="text-center">
                                    <div class="dropdown">
                                        <a  type="button" class="dropdown-toggle card-drop" data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="mdi mdi-dots-horizontal font-size-18"></i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-end" style="">
                                            <a class="dropdown-item ar-details-button" type="button" data-id="{{$object->NOTA_FISCAL}}" order="{{$object->PEDIDO_VENDA}}"><i class="bx bx-detail font-size-16 align-middle me-1"></i> <span>Mais Detalhes</span></a>
                                            <div class="dropdown-divider"></div>
                                            @if($object->status == "PENDENTE")
                                            {{-- <a class="dropdown-item ar-approve-button" type="button"    nf="{{$object->NOTA_FISCAL}}" order="{{$object->PEDIDO_VENDA}}" emitente="{{$object->EMITENTE}}" emitenteEmail="{{$object->EMAIL}}"><i class="bx bx-check-circle font-size-16 align-middle text-success me-1"></i> <span>Aprovar</span></a>
                                            <a class="dropdown-item ar-reject-button" type="button"     nf="{{$object->NOTA_FISCAL}}" order="{{$object->PEDIDO_VENDA}}" emitente="{{$object->EMITENTE}}" emitenteEmail="{{$object->EMAIL}}"><i class="bx bx-x-circle font-size-16 align-middle text-danger me-1"></i> <span>Rejeitar</span></a> --}}
                                            <a class="dropdown-item ar-approve-button" type="button"    nf="{{$object->NOTA_FISCAL}}" order="{{$object->PEDIDO_VENDA}}" ><i class="bx bx-check-circle font-size-16 align-middle text-success me-1"></i> <span>Aprovar</span></a>
                                            <a class="dropdown-item ar-reject-button" type="button"     nf="{{$object->NOTA_FISCAL}}" order="{{$object->PEDIDO_VENDA}}" ><i class="bx bx-x-circle font-size-16 align-middle text-danger me-1"></i> <span>Rejeitar</span></a>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <!-- end table-responsive -->
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
            </div>
        </div>
    </div>
</div>

</x-app-layout>
@include('modals.ar.details')
@include('modals.ar.reject-order')
