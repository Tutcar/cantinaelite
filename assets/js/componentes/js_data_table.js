$(function () {
    // DATATABLES
    $('#dataTable').DataTable({	    	
        responsive: true,
        columnDefs: [
            { type: 'date-br', targets: coluOr }
   
          ],
        "pageLength": 10,
        "language": {
            "sEmptyTable": "Nenhum registro encontrado",
            "sInfo": "Mostrando de _START_ até _END_ de _TOTAL_ registros",
            "sInfoEmpty": "Mostrando 0 até 0 de 0 registros",
            "sInfoFiltered": "(Filtrados de _MAX_ registros)",
            "sInfoPostFix": "",
            "sInfoThousands": ".",
            "sLengthMenu": "_MENU_ resultados por página",
            "sLoadingRecords": "Carregando...",
            "sProcessing": "Processando...",
            "sZeroRecords": "Nenhum registro encontrado",
            "sSearch": "Pesquisar",
            "oPaginate": {
                "sNext": "Próximo",
                "sPrevious": "Anterior",
                "sFirst": "Primeiro",
                "sLast": "Último"
            },
            "oAria": {
                "sSortAscending":  ": Ordenar colunas de forma ascendente",
                "sSortDescending": ": Ordenar colunas de forma descendente"
            }
        },
    });
    
    });	
    jQuery.extend( jQuery.fn.dataTableExt.oSort, {
        "date-br-pre": function ( a ) {
         if (a == null || a == "") {
          return 0;
         }
         var brDatea = a.split('/');
         return (brDatea[2] + brDatea[1] + brDatea[0]) * 1;
        },
       
        "date-br-asc": function ( a, b ) {
         return ((a < b) ? -1 : ((a > b) ? 1 : 0));
        },
       
        "date-br-desc": function ( a, b ) {
         return ((a < b) ? 1 : ((a > b) ? -1 : 0));
        }
       } );