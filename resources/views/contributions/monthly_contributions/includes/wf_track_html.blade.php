{{--['resource_id' => 1, 'wf_module_group_id'=> 2, 'type' => 2, 'workflowScriptAlreadyIncluded' => true]--}}
@php
    $workflowId = "workflow_track_table" . $resource_id;
    if (!isset($workflowScriptAlreadyIncluded)) {
        $workflowScriptAlreadyIncluded = false;
    }
@endphp

<div class="row">
    <div class="col-md-12">
        <div id="completed_workflow{{ $resource_id }}"></div>
    </div>
</div>
<div id="archive_content{{ $resource_id }}"></div>
<legend></legend>
@if(isset($incident))
@if ($incident->notification_staging_cv_id == (new App\Repositories\Backend\Sysdef\CodeValueRepository())->NTCREJNREC())
    @include("backend.operation.claim.notification_report.includes.progressive.recovery_summary")
@endif
@endif
<div class = "row">
    <div class="col-md-12">
        <div class="workflow-track-group">
            <div id="current_workflow{{ $resource_id }}"></div>
            <div id="wf_action_message{{ $resource_id }}"></div>
            <div id="wf_action_content{{ $resource_id }}" style="background: #f3f3f5;padding: 3px;border-radius: 3px;"></div>
        </div>
    </div>
</div>

@push('after-script-end')
@if(!$workflowScriptAlreadyIncluded)
@endif
<script type="text/javascript">
    @if(!$workflowScriptAlreadyIncluded)
        // let $body = $("body");
        function initTable($resourceId, $wfModuleGroupId, $type) {
            $.post( base_url + "/workflow/get_wf_tracks_html/" + $resourceId + "/" + $wfModuleGroupId + "/" + $type, {}, function( $data ) {
                $("#current_workflow" + $resourceId).empty().html($data.current_track);
                $("#completed_workflow" + $resourceId).empty().html($data.completed_tracks);
            }, "json").done(function() {
                /* When Done */
                /*CORE_TEMP.function.PanelCollapse();
                CORE_TEMP.function.PanelFullscreen();
                CORE_TEMP.function.Collapse();
                CORE_TEMP.function.Close();*/
                CORE_TEMP.function.Collapse();
                /*$(".print_letter").click(function() {*/
                $("body").off('click', "#completed_workflow" + $resourceId + " .print_workflow_track").on('click', "#completed_workflow" + $resourceId + " .print_workflow_track", function(e) {
                    let $url = $(this).attr('data-url');
                    let $wf_track_frame = $("#wf_track_frame" + $resourceId);
                    $wf_track_frame.find("iframe").remove();
                    let $iframe = $('<iframe src="' + $url + '" frameborder="0" name="wf_track_preview" width=\'100%\' height=\'600px\'></iframe>');
                    $wf_track_frame.append($iframe);
                    window.frames["wf_track_preview"].focus();
                    window.frames["wf_track_preview"].print();
                });
                $("body").off('click', '.wf_action').on('click', '.wf_action', function(e) {
                    e.preventDefault();
                    let $this = $(this);
                    let $trackid = $this.data('trackid');
                    let $resourceid = $this.data('resourceid');
                    let $incident_id = "{!! !empty($incident) ? $incident->id : null !!}"
                    // console.log($this.data())
                    $this.find('i.fa-circle-o-notch').removeClass("fa-circle-o-notch").addClass('fa-spinner fa-spin');
                    $.post("{!! route('workflow_model_content') !!}", {'wf_track_id': $trackid, 'incident_id' : $incident_id }, function (data) {
                        $("#wf_action_content"+$resourceid).empty();
                        $(data).prependTo("#wf_action_content"+$resourceid);
                    }, "html").done(function () {
                        autosize($("textarea.autosize"));

                        $("body").off("click", ".wf_action_close").on("click", ".wf_action_close", function (e) {
                            e.preventDefault();
                            let $this = $(this);
                            $this.closest("form[name=workflow_process_modal]").remove();
                            $("#wf_action_content"+$this.data('resourceid')).empty();
                        });

                        $("body").off("change", ".workflow_status_select").on("change", ".workflow_status_select", function (e) {
                            /*alert("Hi");*/
                            let $this = $(this);
                            let $status = $this.val();
                            /*alert($status);*/
                            let $form = $this.closest("form[name=workflow_process_modal]");
                            let $wf_track_id = $this.attr("data-track_id");
                            let $next_level_designation = $form.find(".next_level_designation");
                            let $reject_to_level = $form.find(".reject_to_level");
                            let $reject_to_level_select = $form.find(".reject_to_level_select");
                            let $is_optional = $form.find(".is_optional").val();
                            let $selective = $form.find(".selective");
                            let $selective_select = $form.find(".selective_select");
                            let $select_next_user = $form.find(".select_next_user");
                            let $select_next_user_select = $form.find(".select_next_user_select");
                            let $select_prev_user = $form.find(".select_prev_user");
                            let $select_prev_user_select = $form.find(".select_prev_user_select");
                            let $next_level_designation_content = $form.find(".next_level_designation_content");
                            let $next_level_description_content = $form.find(".next_level_description_content");
                            switch($status) {
                                case '1':
                                case '4':
                                    $reject_to_level.hide();
                                    if ($status === "1") {

                                        if ($is_optional !== '0') {
                                            $selective.show();
                                            $selective_select.prop( "disabled", false );
                                        } else {
                                            $selective.hide();
                                            $selective_select.prop( "disabled", true );
                                        }
                                        $select_next_user.show();
                                        $select_next_user_select.prop( "disabled", false );
                                        $select_prev_user.hide();
                                        $select_prev_user_select.prop( "disabled", true );

                                        $.post( base_url + "/workflow/next_level_designation/" + $wf_track_id + "/" + $status , {}, function( $data ) {
                                            /*alert($data.skip);*/
                                            if ($data.next_level_designation !== "") {
                                                $next_level_designation.show();
                                                $next_level_designation_content.empty();
                                                $next_level_designation_content.html( $data.next_level_designation );
                                                $next_level_description_content.html( $data.next_level_description );
                                            } else {
                                                $next_level_designation.hide();
                                            }
                                        }, "json").done(function($data) {});
                                    }
                                    else {
                                        /*status = 4*/
                                        console.log($(this).val())
                                        $selective.show();
                                        $selective_select.prop( "disabled", false );
                                        $select_next_user.hide();
                                        $select_next_user_select.prop( "disabled", true );
                                        $select_prev_user.hide();
                                        $select_prev_user_select.prop( "disabled", true );
                                        $('.selective_select').change(function(e){
                                            console.log(1)
                                            $.ajax({
                                                    dataType : "json",
                                                    method : "POST",
                                                    url : "{!! url('workflow/next_advice_level')!!}/" + $(this).val(),
                                                    success : function (data) {
                                                        console.log(data.next_level_description)
                                                        $next_level_designation.show();
                                                        $next_level_designation_content.empty();
                                                        $next_level_designation_content.html(data.next_level_designation);
                                                        $next_level_description_content.html(data.next_level_description);
                                                    },
                                                    error: function (data) {
                                                    },
                                                });
                                        })
                                    }
                                    break;
                                case '2':
                                    $selective.hide();
                                    $selective_select.prop( "disabled", true );
                                    $next_level_designation.hide();
                                    $reject_to_level.show();
                                    $reject_to_level_select.prop( "disabled", false );
                                    $select_next_user.hide();
                                    $select_next_user_select.prop( "disabled", true );
                                    $select_prev_user.show();
                                    $select_prev_user_select.prop( "disabled", false );

                                    $('.reject_to_level_select').change(function(e){
                                        // console.log($resourceid)
                                        $select_prev_user.empty();
                                        reverseUsers($(this).val(), $resourceid, $select_prev_user);
                                    })
                                    break;
                                case '8':
                                    $("#doc_suspend_cms_modal").val($trackid);
                                    $("#doc_suspend_cms_modal").modal('show');
                                    $module = NULL;
                                    // if($module == 126)       //seeder changes reengineering
                                    if ($module == 161)
                                    {
                                        $('#vendor-title').text('Choose Vendor Form to Suspend');
                                    }
                                    break;
                                default:
                                    $selective.hide();
                                    $select_next_user.hide();
                                    $select_next_user_select.prop( "disabled", true );
                                    $select_prev_user.hide();
                                    $select_prev_user_select.prop( "disabled", true );
                                    $selective_select.prop( "disabled", true );
                                    $next_level_designation.hide();
                                    $reject_to_level.hide();
                                    $reject_to_level_select.prop( "disabled", true );
                                    break;
                            }
                        });
                        $("body").off('submit', 'form[name=workflow_process_modal]').on('submit', 'form[name=workflow_process_modal]', function(e) {
                            e.preventDefault();
                            let $form = $(this);
                            let $data = $form.serialize();
                            /* start: remove any printed error message in the input controls */
                            $form.find(':input').each(function () {
                                $(this).closest(".form-group").removeClass("has-danger").find(".tag-danger").remove();
                            });
                            /* end: remove any printed error message in the input controls */
                            $.ajax({
                                data : $data,
                                dataType : "json",
                                method : "POST",
                                url : $form.attr("action"),
                                beforeSend : function (e) {
                                    $form.find(".btn-submit").prop('disabled', true);
                                },
                                success : function ($data) {
                                    if ($data.success) {
                                        let $wf_action_message = $("#wf_action_message"+$data.resource_id);
                                        $wf_action_message.prepend('<div class="alert alert-success general_error" role="alert">' + $data.message + '</div>'); $wf_action_message.find('.general_error').fadeOut(11000);
                                        $("#wf_action_content"+$data.resource_id).empty();
                                        initTable($data.resource_id, $data.wf_module_group_id, $data.type);
                                    } else {
                                        $form.append('<div class="alert alert-danger general_error" role="alert">' + $data.message + '</div>'); $form.find('.general_error').fadeOut(121000);
                                    }
                                },
                                error: function (data) {
                                    let errors = $.parseJSON(data.responseText);
                                    /* console.log(data); */
                                    $.each(errors, function($index, $value) {
                                        $form.find(':input[name^="' + $index + '"]').closest(".form-group").addClass("has-danger").find(".help-block").append("<small class='tag tag-danger'>" + $value + "</small>");
                                        if ($index === 'general_error') { $form.prepend('<div class="alert alert-danger general_error" role="alert">' + $value + '</div>'); $('.general_error').fadeOut(41000); }
                                    });
                                },
                            }).done(function() {
                            }).fail(function() {
                            }).always(function() {
                                $form.find(".btn-submit").prop('disabled', false);
                            });
                        });
                        $('.workflow_status_select').trigger('change');
                        $this.find('i.fa-spinner').removeClass("fa-spinner fa-spin").addClass('fa-circle-o-notch');
                    });
                });
            });
        }


        function reverseUsers($level, $resourceid, $select_prev_user){
            // console.log($resourceId)
            $.ajax({
                dataType : "json",
                method : "POST",
                url : "{!! url('workflow/get_prev_users')!!}/" + $level + "/" + $resourceid,
                success : function (data) {
                    let html = "<label class='required' for='select_user'>Assign User</label><select name='select_user' class='select_prev_user_select' style='width:100%;border-radius:3px;height:32px;'>"
                    for(let k in data){
                        console.log(data[k])
                        html += "<option value='"+ data[k].id +"'>"+ data[k].name+"</option>"
                    }

                    if(data != null){
                        // console.log(data)
                        // console.log(html)
                        $select_prev_user.append(html)
                    }else{
                        // console.log(1)
                    }


                },
                error: function (data) {
                },
            });
        }

        function adviceLevel($wf_definition_id, $next_level_designation_content, $next_level_description_content){
            // console.log($wf_definition_id)
            $.ajax({
                dataType : "json",
                method : "POST",
                url : "{!! url('workflow/next_advice_level')!!}/" + $wf_definition_id,
                success : function (data) {

                    return data;
                },
                error: function (data) {
                },
            });
        }

        $(function() {

        });

    /*
        There was an error caused by initTable which leads to menu in notification process tab to misbehave...
        putting the within the if statement caused the error to stop and system to behave well...
    */
    $(function() {
        initTable("{{ $resource_id }}", "{{ $wf_module_group_id }}", "{{ $type }}");
        let $archive_content = $('#archive_content{{ $resource_id }}');
        $.post( base_url + "/workflow/can_archive_workflow/{{ $resource_id }}/{{ $wf_module_group_id }}/{{ $type }}", {}, function( $data ) {
            if ($data.success) {
                $archive_content.empty();
                $archive_content.html($data.view);
            }
        }, "json").done(function($data) {
            if ($data.success) {
                addConfirmPostForms();
            }
        });
    });
    @endif
</script>
@endpush
