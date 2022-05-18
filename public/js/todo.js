

jQuery(document).ready(function($){
  let text
  $(".cgc_register").on('change', function() {
    $.ajax({
      type: "POST",
      url: '/client-register-validate',
      data: $('#register-form').serialize(),
      dataType: 'json',
      success: function (data) {
        console.log(data)
        $("#name").val(data.cliente);
        $("#cli").val(data.codcli);
      },
      error: function (data) {
        console.log(data)
        text = 'Permissão negada para cadastro!'
        warningMessage(text)
      }
    });
  });

  $(".ar-details-button").on('click', function() {
    var iid = $(this).attr('data-id');
    var order = $(this).attr('order');
   
    $('.ar-details-modal').modal('show');
    $.ajax({
      url: '/sales-order/' + iid,
      dataType: 'json',
      success: function (data) {
        console.log(data)

        $("#order_modal").html(order);
        $("#nf_modal").html(iid);
        $("#items").html('');
        $.each( data, function( i, val ) {
          var newRow = $("<tr>");
          var cols = "";
      
          cols += '<th scope="row">'+ val.Numseq + '</td>';
          cols += '<td> '+ val.Cod_Fab + ' </td>';
          cols += '<td> '+ val.Descricao + ' </td>';
          cols += '<td> '+ val.Quantidade + ' </td>';
          cols += '<td> '+ val.Embalagem + ' </td>';
          cols += '<td> '+ val.Marca + ' </td>';
          cols += '<td> '+ val.Num_Lote + ' </td>';
          cols += '<td> '+ val.PERCIPI + '% </td>';
          cols += '<td> '+ val.PERCICM + '% </td>';
          cols += '<td> '+ val.NBM + ' </td>';
          cols += '<td> R$ '+ val.Valor_Item + ' </td>';
      
          newRow.append(cols);
          $("#items").append(newRow);
      
          //return false;
      });
        
      },
      error: function (data) {
        console.log(data)
      }
    });
  });

  

});


  // Aprove Order
$('.ar-approve-button').click(function () {
  var nota = $(this).attr('nf');
  var order = $(this).attr('order');
  var emitente = $(this).attr('emitente');
  var emitenteEmail = $(this).attr('emitenteEmail');
  Swal.fire({
    title: 'Confirme!',
    text: "Você quer mesmo aprovar este pedido?",
    icon: 'warning',
    showCancelButton: true,
    confirmButtonText: 'Sim, Aprovar!',
    cancelButtonText: 'Agora Não!',
    confirmButtonClass: 'btn btn-success mt-2',
    cancelButtonClass: 'btn btn-danger ms-2 mt-2',
    buttonsStyling: false,
}).then(function (result) {
    if (result.value) {

      $.ajax({
        url: '/approve_order/'+ nota + '/' + order + '/' + emitente + '/' + emitenteEmail,
        dataType: 'json',
        success: function (data) {
          console.log(data)
          Swal.fire({
            title: 'Aprovado!',
            text: 'O Pedido foi Aprovado.',
            icon: 'success',
          }).then(function (result) {
            location.reload(true);
          });
        },
        error: function (data) {
          console.log(data)
          Swal.fire({
            title: 'Opa!',
            text: 'Ocorreu algum problema. Tente novamente ou entre em contato com o suporte',
            icon: 'warning',
          })
        }
      });


        
      } else if (
        // Read more about handling dismissals
        result.dismiss === Swal.DismissReason.cancel
      ) {
        Swal.fire({
          title: 'Aprovação Cancelada',
          text: 'Este pedido ainda consta como PENDENTE :)',
          icon: 'error',
        })
      }
});
    });


      // Reject Order
$('.ar-reject-button').click(function () {
  var nota = $(this).attr('nf');
  var order = $(this).attr('order');
  Swal.fire({
    title: 'Confirme!',
    text: "Você quer mesmo reprovar este pedido?",
    icon: 'warning',
    showCancelButton: true,
    confirmButtonText: 'Sim, Rejeitar!',
    cancelButtonText: 'Agora Não!',
    confirmButtonClass: 'btn btn-success mt-2',
    cancelButtonClass: 'btn btn-danger ms-2 mt-2',
    buttonsStyling: false,
}).then(function (result) {
    if (result.value) {
      $('.order-reject-modal').modal('show');
      $('#nf_reprove').val(nota);
      $('#erp_order_reprove').val(order);
      $('#note').val('');
        
      } else if (
        // Read more about handling dismissals
        result.dismiss === Swal.DismissReason.cancel
      ) {
        Swal.fire({
          title: 'Reprovação Cancelada',
          text: 'Este pedido ainda consta como PENDENTE :)',
          icon: 'error',
        })
      }
});
    });

function warningMessage(text){
  //Warning Message
  Swal.fire({
    title: "Algo deu errado!",
    text: text,
    icon: "warning",
    confirmButtonColor: "#556ee6",
    confirmButtonText: "Ok"
  })
}

//CPF/CNPJ AUTO MASK
$("#cgc").keydown(function(){
  try {
      $("#cgc").unmask();
  } catch (e) {}

  var tamanho = $("#cgc").val().length;

  if(tamanho < 11){
      $("#cgc").mask("999.999.999-99");
  } else {
      $("#cgc").mask("99.999.999/9999-99");
  }

  // ajustando foco
  var elem = this;
  setTimeout(function(){
      // mudo a posição do seletor
      elem.selectionStart = elem.selectionEnd = 10000;
  }, 0);
  // reaplico o valor para mudar o foco
  var currentValue = $(this).val();
  $(this).val('');
  $(this).val(currentValue);
});

