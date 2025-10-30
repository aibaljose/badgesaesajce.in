
    $(".datatable-select").each(function(){
        var buttonsArray = [];
        if($(this).attr('selection') == "true"){
            buttonsArray.push({
                extend: 'selectAll',
                className: 'btn-sm-success',
                text: 'Select all'
            },{
                extend: 'selectNone',
                className: 'btn-sm-danger',
                text: 'Select none'
            });
        }
        if($(this).attr('bulk-cert-issue') == "true"){
            buttonsArray.push({
                className: 'btn-sm-primary issue_allCertificate disabled',
                text: 'Issue Certificates',
                action: function () {
                    let _userList = [];
                    var selectedRows = dt.rows({ selected: true }).nodes();
                    selectedRows.each(function (e) {
                        _userList.push($(e).attr("cert-user"));
                    });
                    Swal.fire({
                      title: "Issue Bulk Certificates!",
                      text: "Choose certificate type",
                      input: "select",
                      inputOptions: _inputoptions,
                      showCancelButton: true,
                      confirmButtonText: "Issue Certificates!",
                      allowOutsideClick: false,
                    }).then((result) => {
                      if (result.isConfirmed) {
                        $.post('/api', {
                            method: "issueEventCertificateBulk",
                            cert_event: __certEvent,
                            cert_users: _userList,
                            cert_type: result.value
                        }, function (response) {
                            console.log(response)
                            let resp = JSON.parse(response);
                            if(resp.status){
                                Swal.fire({title:'Certificates issued!',text:'Great! '+resp.sCount+' of '+_userList.length+' certificates has been issued successfully.',icon:'success'}).then(()=>{
                                    document.location.reload();
                                })
                            }else{
                                Swal.fire({title:'Certificate not issued!',text:'Something went wrong!',icon:'error'}).then(()=>{
                                    document.location.reload();
                                })
                            }
                        });
                      }
                    });
                }
            });
        }
        
        var dt = $(this).DataTable({
            select: ($(this).attr('selection') == "true"),
            dom: 'Blfrtip',
            buttons: buttonsArray
            // columnDefs: [{
            //     targets: $(".no-selection").index(),
            //     selectable: false
            // }]
        });
        dt.on('select', function (e, dt, type, indexes) {
            var selectedRows = dt.rows({ selected: true }).count();
            if (selectedRows > 0) {
                $('.issue_allCertificate').removeClass('disabled');
                $('.issue_allCertificate').prop("disabled", false);
            }
        });

        dt.on('deselect', function (e, dt, type, indexes) {
            var selectedRows = dt.rows({ selected: true }).count();
            if (selectedRows === 0) {
                $('.issue_allCertificate').addClass('disabled');
                $('.issue_allCertificate').prop("disabled", true);
            }
        });
        
    });
    $('.issue_allCertificate').prop("disabled", true);
