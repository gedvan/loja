$(document).ready(function() {
   
   $("#lista-usuarios td.nome").click(function(){
       var id = $.trim($(this).prev().text());
       $.get(baseUrl + '/usuarios/detalhes', {'id': id}, function(dados) {
           $('#detalhes').html(dados);
       });
   })
   
   $('#form-consulta #nome').autocomplete({
       source: baseUrl + '/usuarios/autocomplete',
       minLength: 2,
       select: function(event, ui) {
           alert(ui.item.value);
       }
   });
   
   $("#lista-usuarios td.ativo a").click(function(){
       var id = $(this).attr('id').substr(6);
       var link = $(this);
       $.post(baseUrl + '/usuarios/muda-status', {'id': id}, function(data, textStatus, jqXHR) {
          if (data.ativo == '1')
              link.text('Sim');
          else
              link.text('Não');
       });
       return false;
   })
});
