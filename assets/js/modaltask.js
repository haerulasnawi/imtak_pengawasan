// $(function () {

//     $(document).on('click', '.tombolTambahtask', function (e) {
//         $('#newTaskModalLabel').html('Create a New Task');
//         $('.modal-footer button[type=submit]').html('Add');
//         $('#task_type').val("");
//         $('#source_lang').val("");
//         $('#target_lang').val("");
//         $('#name').val("");
//         $('#id_freelance').val("");
//         $('#email').val("");
//         $('#deadline').val("");
//         $('#job_value').val("");
//         $('#task_files').val("");
//         $('#status').val("");
//         $('#date_created').val("");

//     });

//     $(document).on('click', '.tampilModalTask', function (e) {
//         $('#newTaskModalLabel').html('Change Task');
//         $('.modal-footer button[type=submit]').html('Change');
//         $('.modal-body form').attr('action', 'http://localhost/wpu-login/admin/editTask');

//         const id = $(this).data('id');

//         $.ajax({
//             url: 'http://localhost/wpu-login/admin/getubahtask',
//             data: { id: id },
//             method: 'post',
//             dataType: 'json',
//             success: function (data) {
//                 $('#task_type').val(data.task_type);
//                 $('#deadline').val(data.deadline);
//                 $('#source_lang').val(data.source_lang);
//                 $('#name').val(data.name);
//                 $('#email').val(data.email);
//                 $('#task_files').val(data.task_files);
//                 $('#job_value').val(data.job_value);
//                 $('#target_lang').val(data.target_lang);
//                 $('#status').val(data.status);
//                 $('#date_created').val(data.date_created);
//                 // $('#id_freelance').val(data.id_freelance);
//                 $('#id').val(data.id);
//             }
//         });
//     });
// });