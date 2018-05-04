
<?php
/******************************************************
* IM - Vocabulary Builder
* Version : 1.0.2
* Copyright© 2016 Imprevo Ltd. All Rights Reversed.
* This file may not be redistributed.
* Author URL:http://imprevo.net
******************************************************/
?>
@extends('layouts.app')
<style>
.terminal{
  background-color: #000;
  color:#fff;
}

</style>
@section('content')
<section role="main" class="content-body">
  <header class="page-header">
    <h2>Server: {{$server->name}} @if($server->is_connected) Connected @endif</h2>
  </header>
  <div class="row" id="pageDocument">
    <div class="col-sm-6" style="text-align:center">
      <!-- <div class="row">
        <div class="col-sm-6" style="text-align:left">
            <h3 class="disconnect">@if ($server->is_connected && $activity) Current Activity:{{$activity->name}} @endif</h3>
        </div>
      </div>
      <div class="row">
        <div class="col-sm-10" style="text-align:right">
          <input type="text" class="form-control" name="cmd" id="cmd" />
        </div>
        <div class="col-sm-2" style="text-align:right">

          <button class="disconnect btn btn-primary" onclick="disconnect()" style="@if (!$server->is_connected) display:none @endif">Disconnect</button>

          <button class="connect btn btn-primary" data-target="#add_activity" data-toggle="modal" style="@if ($server->is_connected) display:none @endif">Connect</button>

        </div>
      </div> -->
      <div id="terminal_area_div" class="row" style="padding-top:10px;height:700px">
        <!-- <textarea id="terminal_area" class="terminal" style="width:100%;height:70%;overflow-y:visible" value="{{$server->session_log}}" readonly>
          {{$server->session_log}}
        </textarea> -->
        <iframe src="https://webssh.bartlweb.net" style="width:100%;height:100%;background-color:#fff"></iframe>
      </div>
    </div>
    <div class="col-sm-6" style="text-align:center">
      <h4>Work history</h4>
      <table class="table table-bordered table-striped mb-none" id="datatable-editable">
        <thead>
          <tr>
            <th>Activity</th>
            <th>Created_at</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($activities as $item)
          <tr id="{{$item->id}}">
            <td>{{$item->name}}</td>
            <td>{{$item->created_at}}</td>
          </tr>
          @endforeach
        </tbody>
      </table>
      {{ $activities->links() }}
    </div>
  </div>
</section>
<form id="cmd-form">
  <input type="hidden" id="cmd_input" name="cmd"/>
</form>
<div class="modal fade" id="add_activity" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal_body">
        <button class="model_close" type="button" class="close" data-dismiss="modal" style="position:absolute; right:20px; top:10px"><i class="fa fa-close"></i></button>
        <div class="row">
          <div class="col-md-12 col-sm-12" style="padding:50px">
            <h2>Add Activity</h2>
            <form class="activity_form" id="form_new" action="" method="post" />
            <input type="hidden" id="server_id" name="server_id" value="{{$server->id}}" />
            <div class="row" style="padding-top:10px">
              <input class="form-control" type="text" name="act_name" placeholder="Name of the activity" required>
            </div>
            <div class="row" style="padding-top:10px">
              <textarea id="act_description" class="form-control" type="text" name="act_description" placeholder="Description of the activity">
              </textarea>
            </div>
            <div class="row" style="padding-top:10px">
              <div class="col-md-6 col-sm-6 col-xs-12">
                <button class="btn btn-primary" type="submit">Save</button>
              </div>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <button class="btn btn-primary" href="#" data-dismiss="modal" style="color:#fff; cursor:pointer">Cancel</a>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<script src="/assets/novnc/core/rfb.js"></script>
<script>
var cmd_id = 0;
$('.activity_form').submit(function(e){
  console.log('submit');
  e.preventDefault();
  e.stopPropagation();
  id = $('#server_id').val();
  console.log(id);
  var formData = new FormData($(this)[0]);
  $.ajax({
    url: '/server/makeconnect/' + id,
    type: 'POST',
    data: formData,
    processData: false,
    contentType: false,
    async: true,
    success: function (ret) {
      console.log(ret);
      $('#terminal_area').html('connecting...');
      updatesessionlog();
      cmd_id = ret;
    },
    error: function (ret){
      $('#terminal_area').html('connect failed!');
      console.log(ret);
    }
  });
  $('.modal').modal('hide');
});

$('#cmd').on('keyup', function(e){
  console.log('key up');
  if (e.keyCode == 13){
    console.log('key up 13');
    id = "{{$server->id}}";
    host = "{{$server->host}}";
    console.log(id);
    cmd = $(this).val();
    $('#cmd_input').val(cmd);
    var formData = new FormData($('#cmd-form')[0]);

    $(this).prop('disabled', true);

    $.ajax({
      url: '/servers/cmd/' + id,
      type: 'POST',
      data: formData,
      processData: false,
      contentType: false,
      async: true,
      success: function (ret) {
        console.log(ret);
        cmd_id = ret;
        html = $('#terminal_area').html();
        html = html + '\n';
        html = html + 'root@' + host + '>' + cmd;
        $('#terminal_area').html(html);
        updatesessionlog();
      },
      error: function (ret){
        //$('#terminal_area').html('cmd failed!');
        console.log(ret);
        $(this).prop('disabled', false);
      }
    });
    $(this).val('');
  }
});

function updatesessionlog(){
  content  =  $('#terminal_area').html();
  id = "{{$server->id}}";
  $.ajax({
    url: '/server/sessionlog/update/' + id,
    type: 'POST',
    data: {'content':content},
    async: true,
    success: function (ret) {
      console.log(ret);
    },
    error: function (ret){
      console.log(ret);
    }
  });
}

function disconnect(){
  id = "{{$server->id}}";
  $.ajax({
    url: '/server/disconnect/' + id,
    type: 'POST',
    data: {},
    processData: false,
    contentType: false,
    async: true,
    success: function (ret) {
      console.log(ret);
      $('.disconnect').hide();
      $('.connect').show();
      $('#terminal_area').html('');
      updatesessionlog();
    },
    error: function (ret){
      //$('#terminal_area').html('disconnect failed!');
      console.log(ret);
    }
  });
}

$(document).ready(function(){
  // id = "{{$server->id}}";
  // setInterval(function(){
  //   console.log('cmd',cmd_id);
  //   $.ajax({
  //     url: '/server/getcmd/' + id,
  //     type: 'POST',
  //     data: {'cmd_id':cmd_id},
  //     async: true,
  //     success: function (ret) {
  //       console.log('getcmd', ret);
  //       console.log('getcmd', cmd_id);
  //       if (ret == 'wait'){
  //
  //       } else {
  //         $('#cmd').prop('disabled', false);
  //         $('#cmd').focus();
  //         html = $('#terminal_area').html();
  //         html = html + '\n';
  //         if (ret != 'nothing'){
  //           html = html + ret;
  //         }
  //         $('#terminal_area').html(html);
  //         updatesessionlog();
  //         cmd_id = 0;
  //       }
  //     },
  //     error: function (ret){
  //       console.log('getcmd', ret);
  //       $(this).prop('disabled', false);
  //     }
  //   });
  // }, 1000);
  target = document.getElementById('terminal_area_div');
  var rfb = new RFB(target, '142.44.241.179:22');

});
</script>

@endsection
