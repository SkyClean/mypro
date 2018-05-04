
<?php
/******************************************************
* IM - Vocabulary Builder
* Version : 1.0.2
* Copyright© 2016 Imprevo Ltd. All Rights Reversed.
* This file may not be redistributed.
* Author URL:http://imprevo.net
******************************************************/
?>
@extends('layouts.app0')
<style>
.terminal{
  background-color: #000;
  color:#fff;
}
</style>
@section('content')
@foreach ($servers as $item)
<section role="main" class="server-div content-body" id="server-div-{{$item->id}}" style="display:none; @if ($item->id == $server->id) display:block; @endif">
  <header class="page-header">
    <h2>Server: {{$item->name}},    UserName: {{$item->username}},     Password: {{$item->password}}</h2>
  </header>
  <div class="row">
    <div class="connect-div-{{$item->id}}" style="text-align:center;position:absolute; left:50%; top:350px; width:150px; margin-left:-75px">
      <button class="connect btn btn-primary" data-target="#add_activity_{{$item->id}}" data-toggle="modal" style="width:100%">Connect</button>
    </div>
    <div class="connecting-div-{{$item->id}} col-sm-6" style="text-align:center;display:none">
      <div id="terminal_area_div" class="row" style="padding-top:10px;">
        <iframe id="iframe-{{$item->id}}" src="https://webssh.bartlweb.net" style="width:100%;height:600px;background-color:#fff"></iframe>
      </div>
    </div>
    <div class="connecting-div-{{$item->id}} col-sm-6" style="text-align:center;display:none">
      <h4>Work history</h4>
      <table class="table table-bordered table-striped mb-none" id="datatable-editable">
        <thead>
          <tr>
            <th>Activity</th>
            <th>Created_at</th>
          </tr>
        </thead>
        <tbody id="tbody-{{$item->id}}">
          @foreach ($activities as $act)
          @if ($act->server_id == $item->id)
          <tr id="{{$act->id}}">
            <td>{{$act->name}}</td>
            <td>{{$act->created_at}}</td>
          </tr>
          @endif
          @endforeach
        </tbody>
      </table>
      {{ $activities->links() }}
    </div>
  </div>
  <div class="modal fade add_activity" id="add_activity_{{$item->id}}" role="dialog">
    <div class="modal-dialog">
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal_body">
          <button class="model_close" type="button" data-dismiss="modal" style="position:absolute; right:20px; top:10px; z-index:500"><i class="fa fa-close"></i></button>
          <div class="row">
            <div class="col-md-12 col-sm-12" style="padding:50px">
              <h2>Add Activity</h2>
              <form class="activity_form" id="form_new" action="" method="post" />
              <input type="hidden" id="server_id" name="server_id" value="{{$item->id}}" />
              <div class="row" style="padding-top:10px">
                <input class="form-control" type="text" name="act_name" placeholder="Name of the activity" required>
              </div>
              <div class="row" style="padding-top:10px">
                <textarea id="act_description" class="form-control" type="text" name="act_description" placeholder="Description of the activity" value=""></textarea>
              </div>
              <div class="row" style="padding-top:10px">
                <div class="col-md-2 col-sm-6 col-xs-12" style="padding-left:0px">
                  <button class="btn btn-primary" type="submit">Save</button>
                </div>
                <div class="col-md-2 col-sm-6 col-xs-12">
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
  </section>
  @endforeach

<form id="cmd-form">
  <input type="hidden" id="cmd_input" name="cmd"/>
</form>

<script>
var cmd_id = 0;
$('.activity_form').submit(function(e){
  console.log('submit');
  e.preventDefault();
  e.stopPropagation();
  id = $(this).find('#server_id').val();
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
      $('#tbody-' + ret.server_id).prepend('<tr id="' + ret.act.id +'">\
                  <td>' + ret.act.name +'</td>\
                  <td>' + ret.act.created_at +'</td>\
                </tr>');

    $('.connect-div-' + ret.server_id).hide();
    $('#iframe-'+ret.server_id).attr('src', $('#iframe-'+ret.server_id).attr('src'));
    $('.connecting-div-' + ret.server_id).show();
    },
    error: function (ret){
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

$('.close').click(function(){
  $('.model_close').modal('hide');
});

$('.server-link').click(function(e){
  e.preventDefault();
  e.stopPropagation();
  console.log('server link clicked');
  server_id = $(this).data('server');
  $('.server-div').hide();
  $('#server-div-'+server_id).show();
})

</script>

@endsection
