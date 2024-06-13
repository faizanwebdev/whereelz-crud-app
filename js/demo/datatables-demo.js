// Call the dataTables jQuery plugin
$(document).ready(function() {
  $('#dataTable').DataTable({
      initComplete: function () {
          var r = $('#dataTable tfoot tr');
          r.find('th').each(function(){
            $(this).css('padding', 5);
          });
          $('#dataTable thead').append(r);
            this.api().columns().every( function () {
                var column = this;
                var select = $('<select><option value=""></option></select>')
                    .appendTo( $(column.footer()).empty() )
                    .on( 'change', function () {
                        var val = $.fn.dataTable.util.escapeRegex(
                            $(this).val()
                        );
 
                        column
                            .search( val ? '^'+val+'$' : '', true, false )
                            .draw();
                    } );
 
                column.data().unique().sort().each( function ( d, j ) {
                    select.append( '<option value="'+d+'">'+d+'</option>' );
                } );
            } );
        },
//        pageLength: 10,
        
        order: [[ 0, 'desc']],
        dom: 'Bfrtip',
      buttons: [
            'pageLength',{
        extend: 'excel',
        text: 'Download Excel'
      }
        ],
      "bLengthChange": true,
    });
//   $('#dataTable').DataTable(
//       {
//         dom: 'Bfrtip',
//         buttons: [
//             'copy', 'csv', 'excel', 'pdf', 'print'
//         ]
//       });
});