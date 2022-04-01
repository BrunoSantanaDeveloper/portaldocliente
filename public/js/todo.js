

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
    $('.ar-details-modal').modal('show');
    $.ajax({
      url: '/sales-order/' + iid,
      dataType: 'json',
      success: function (data) {
        console.log(data)

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
          cols += '<td> '+ val.Valor_Item + ' </td>';
      
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

