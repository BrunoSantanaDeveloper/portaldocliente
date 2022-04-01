  <!-- Modal -->
  <div class="modal fade ar-details-modal" tabindex="-1" role="dialog" aria-labelledby="orderdetailsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="orderdetailsModalLabel">Detalhes do Pedido</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p class="mb-2">Nº Pedido de Venda: <span class="text-primary">#SK2540</span></p>
                <p class="mb-4">NF: <span class="text-primary">000000</span></p>

                <div class="table-responsive">
                    <table class="table align-middle table-nowrap">
                        <thead>
                            <tr>
                                <th scope="col">Produto</th>
                                <th scope="col">Cod. Fab.</th>
                                <th scope="col">Descrição</th>
                                <th scope="col">Quantidade</th>
                                <th scope="col">Embalagem</th>
                                <th scope="col">Marca</th>
                                <th scope="col">Nº Lote</th>
                                <th scope="col">% IPI</th>
                                <th scope="col">% ICM</th>
                                <th scope="col">NBM</th>
                                <th scope="col">Valor</th>
                            </tr>
                        </thead>
                        <tbody id="items">
                            
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<!-- end modal -->