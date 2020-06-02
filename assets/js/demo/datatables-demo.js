// Call the dataTables jQuery plugin
// $('#tabelku').DataTable({
//   order: [
//     [3, 'desc']
//   ],
//   // dom: '<"top">rt<"bottom"lfp><"clear">',
//   pagingType: 'full_numbers',
//   responsive: true,

//   columnDefs: [{
//     orderable: false,
//     className: 'select-checkbox select-checkbox-all',
//     targets: 0
//   }],
//   select: {
//     style: 'multi',
//     selector: 'td:first-child'
//   },
//   initComplete: function () {
//     this.api().columns().every(function () {
//       var column = this;
//       var search = $(`<input class="form-control form-control-sm" type="text" placeholder="Search">`)
//         .appendTo($(column.footer()).empty())
//         .on('change input', function () {
//           var val = $(this).val()

//           column
//             .search(val ? val : '', true, false)
//             .draw();
//         });

//     });
//   }

  // footerCallback: function (row, data, start, end, display) {
  //   var api = this.api(), data;

  //   var intVal = function (i) {
  //     return typeof i === 'string' ?
  //       i.replace(/[\$,]/g, '') * 1 :
  //       typeof i === 'string' ?
  //         i : 0;
  //   };

  //   total = api
  //     .column(1)
  //     .data()
  //     .reduce(function (a, b) {
  //       return intVal(a) + intVal(b);
  //     }, 0);

  //   pageTotal = api
  //     .column(1, { page: 'current' })
  //     .data()
  //     .reduce(function (a, b) {
  //       return intVal(a) + intVal(b);
  //     }, 0);

  //   $(api.column(1).footer()).html(
  //     '$' + pageTotal + '($' + total + 'total)'
  //   );
  // }

});

$('#tabelmu').DataTable({
  // dom: '<"top">rt<"bottom"lfp><"clear">',
  pagingType: 'full_numbers',
  responsive: true,

  columnDefs: [{
    orderable: false,
    className: 'select-checkbox select-checkbox-all',
    targets: 0
  }],
  select: {
    style: 'multi',
    selector: 'td:first-child'
  },
  initComplete: function () {
    this.api().columns().every(function () {
      var column = this;
      var search = $(`<input class="form-control form-control-sm" type="text" placeholder="Search">`)
        .appendTo($(column.footer()).empty())
        .on('change input', function () {
          var val = $(this).val()

          column
            .search(val ? val : '', true, false)
            .draw();
        });

    });
  }

  // footerCallback: function (row, data, start, end, display) {
  //   var api = this.api(), data;

  //   var intVal = function (i) {
  //     return typeof i === 'string' ?
  //       i.replace(/[\$,]/g, '') * 1 :
  //       typeof i === 'string' ?
  //         i : 0;
  //   };

  //   total = api
  //     .column(1)
  //     .data()
  //     .reduce(function (a, b) {
  //       return intVal(a) + intVal(b);
  //     }, 0);

  //   pageTotal = api
  //     .column(1, { page: 'current' })
  //     .data()
  //     .reduce(function (a, b) {
  //       return intVal(a) + intVal(b);
  //     }, 0);

  //   $(api.column(1).footer()).html(
  //     '$' + pageTotal + '($' + total + 'total)'
  //   );
  // }

});
$('#tabelmenu').DataTable({
  // dom: '<"top">rt<"bottom"lfp><"clear">',
  pagingType: 'full_numbers',
  responsive: true,

  columnDefs: [{
    orderable: false,
    className: 'select-checkbox select-checkbox-all',
    targets: 0
  }],
  select: {
    style: 'multi',
    selector: 'td:first-child'
  },
  // initComplete: function () {
  //   this.api().columns().every(function () {
  //     var column = this;
  //     var search = $(`<input class="form-control form-control-sm" type="text" placeholder="Search">`)
  //       .appendTo($(column.footer()).empty())
  //       .on('change input', function () {
  //         var val = $(this).val()

  //         column
  //           .search(val ? val : '', true, false)
  //           .draw();
  //       });

  //   });
  // }

  // footerCallback: function (row, data, start, end, display) {
  //   var api = this.api(), data;

  //   var intVal = function (i) {
  //     return typeof i === 'string' ?
  //       i.replace(/[\$,]/g, '') * 1 :
  //       typeof i === 'string' ?
  //         i : 0;
  //   };

  //   total = api
  //     .column(1)
  //     .data()
  //     .reduce(function (a, b) {
  //       return intVal(a) + intVal(b);
  //     }, 0);

  //   pageTotal = api
  //     .column(1, { page: 'current' })
  //     .data()
  //     .reduce(function (a, b) {
  //       return intVal(a) + intVal(b);
  //     }, 0);

  //   $(api.column(1).footer()).html(
  //     '$' + pageTotal + '($' + total + 'total)'
  //   );
  // }

});
$('#tabelsub').DataTable({
  // dom: '<"top">rt<"bottom"lfp><"clear">',
  pagingType: 'full_numbers',
  responsive: true,

  columnDefs: [{
    orderable: false,
    className: 'select-checkbox select-checkbox-all',
    targets: 0
  }],
  select: {
    style: 'multi',
    selector: 'td:first-child'
  },
  initComplete: function () {
    this.api().columns().every(function () {
      var column = this;
      var search = $(`<input class="form-control form-control-sm" type="text" placeholder="Search">`)
        .appendTo($(column.footer()).empty())
        .on('change input', function () {
          var val = $(this).val()

          column
            .search(val ? val : '', true, false)
            .draw();
        });

    });
  }

  // footerCallback: function (row, data, start, end, display) {
  //   var api = this.api(), data;

  //   var intVal = function (i) {
  //     return typeof i === 'string' ?
  //       i.replace(/[\$,]/g, '') * 1 :
  //       typeof i === 'string' ?
  //         i : 0;
  //   };

  //   total = api
  //     .column(1)
  //     .data()
  //     .reduce(function (a, b) {
  //       return intVal(a) + intVal(b);
  //     }, 0);

  //   pageTotal = api
  //     .column(1, { page: 'current' })
  //     .data()
  //     .reduce(function (a, b) {
  //       return intVal(a) + intVal(b);
  //     }, 0);

  //   $(api.column(1).footer()).html(
  //     '$' + pageTotal + '($' + total + 'total)'
  //   );
  // }

});

$('#tabeluserlist').DataTable({
  // dom: '<"top">rt<"bottom"lfp><"clear">',
  pagingType: 'full_numbers',
  responsive: true,

  columnDefs: [{
    orderable: false,
    className: 'select-checkbox select-checkbox-all',
    targets: 0
  }],
  select: {
    style: 'multi',
    selector: 'td:first-child'
  },
  initComplete: function () {
    this.api().columns().every(function () {
      var column = this;
      var search = $(`<input class="form-control form-control-sm" type="text" placeholder="Search">`)
        .appendTo($(column.footer()).empty())
        .on('change input', function () {
          var val = $(this).val()

          column
            .search(val ? val : '', true, false)
            .draw();
        });

    });
  }

  // footerCallback: function (row, data, start, end, display) {
  //   var api = this.api(), data;

  //   var intVal = function (i) {
  //     return typeof i === 'string' ?
  //       i.replace(/[\$,]/g, '') * 1 :
  //       typeof i === 'string' ?
  //         i : 0;
  //   };

  //   total = api
  //     .column(1)
  //     .data()
  //     .reduce(function (a, b) {
  //       return intVal(a) + intVal(b);
  //     }, 0);

  //   pageTotal = api
  //     .column(1, { page: 'current' })
  //     .data()
  //     .reduce(function (a, b) {
  //       return intVal(a) + intVal(b);
  //     }, 0);

  //   $(api.column(1).footer()).html(
  //     '$' + pageTotal + '($' + total + 'total)'
  //   );
  // }

});
var ctx = document.getElementById("tabeltask");
$(ctx).DataTable({
  // dom: '<"top">rt<"bottom"lfp><"clear">',
  pagingType: 'full_numbers',
  responsive: true,

  columnDefs: [{
    orderable: false,
    className: 'select-checkbox select-checkbox-all',
    targets: 0
  }],
  select: {
    style: 'multi',
    selector: 'td:first-child'
  },
  initComplete: function () {
    this.api().columns().every(function () {
      var column = this;
      var search = $(`<input class="form-control form-control-sm" type="text" placeholder="Search">`)
        .appendTo($(column.footer()).empty())
        .on('change input', function () {
          var val = $(this).val()

          column
            .search(val ? val : '', true, false)
            .draw();
        });

    });
  }

  // footerCallback: function (row, data, start, end, display) {
  //   var api = this.api(), data;

  //   var intVal = function (i) {
  //     return typeof i === 'string' ?
  //       i.replace(/[\$,]/g, '') * 1 :
  //       typeof i === 'string' ?
  //         i : 0;
  //   };

  //   total = api
  //     .column(1)
  //     .data()
  //     .reduce(function (a, b) {
  //       return intVal(a) + intVal(b);
  //     }, 0);

  //   pageTotal = api
  //     .column(1, { page: 'current' })
  //     .data()
  //     .reduce(function (a, b) {
  //       return intVal(a) + intVal(b);
  //     }, 0);

  //   $(api.column(1).footer()).html(
  //     '$' + pageTotal + '($' + total + 'total)'
  //   );
  // }

});




