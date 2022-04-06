  <!-- Modal -->
  <div class="modal fade order-reject-modal" tabindex="-1" role="dialog" aria-labelledby="orderdetailsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="orderdetailsModalLabel">Motivo</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <h5 class="card-title">Motivo da rejeição do pedido</h5>
              <form method="POST" id="reject-order-form" action="{{ route('orders.reject-order') }}">
                @csrf

                <div class="form-floating mb-3">
                  <textarea id="note" name="note" type="text" class="form-control" rows="5" id="floatingnameInput" placeholder="Enter Name"></textarea>
                  <label for="floatingnameInput">Digite aqui:</label>
                  <x-input id="nf_reprove" name="nf" hidden />
                    <x-input id="erp_order_reprove" name="erp_order" hidden />
                </div>
    
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-success" >Rejeitar</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
            </div>
          </form>
        </div>
    </div>
</div>
<!-- end modal -->