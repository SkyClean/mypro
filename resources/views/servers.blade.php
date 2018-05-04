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

@section('content')
        <section role="main" class="content-body">
            <header class="page-header">
                <h2>Service management</h2>
            </header>
            <div class="panel-body" id="pageDocument">
                <div class="row">
                    <div class="col-sm-9">
                        <div class="mb-md">
                            <a href="/servers/new" id="addToTable" class="btn btn-primary">Add <i class="fa fa-plus"></i></a>
                        </div>
                    </div>
                    <div class="col-sm-3">
                      <form id="search-form" method="GET" action="">
      								<div class="input-group input-search">
      									<input type="text" class="form-control" name="query" id="query" placeholder="Search..." value="{{$search}}">
      									<span class="input-group-btn">
      										<button class="btn btn-default" type="submit"><i class="fa fa-search"></i></button>
      									</span>
      								</div>
                     </form>
      							</div>
                </div>
                <table class="table table-bordered table-striped mb-none" id="datatable-editable">
                    <thead>
                    <tr>
                        <th>SERVER NAME</th>
                        <th>HOST</th>
                        <th>USERNAME</th>
                        <th>Activity Count</th>
                        <th>Created At</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @if (count($servers) > 0)
                    @foreach ($servers as $server)
                        <tr id="{{$server->id}}">
                            <td>{{$server->name}}</td>
                            <td>{{$server->host}}</td>
                            <td>{{$server->username}}</td>
                            <td>{{$server->act_count}}</td>
                            <td>{{$server->created_at}}</td>
                            <td class="actions">
                                <a href="/servers/{{$server->id}}" class="on-default edit-row"><i class="fa fa-pencil"></i></a>
                                <a href="#" class="on-default remove-row" onclick="removeService({{$server->id}})"><i class="fa fa-trash-o"></i></a>
                            </td>
                        </tr>
                    @endforeach
                    @endif
                    </tbody>
                </table>
                {{ $servers->links() }}
            </div>
        </section>
    <script>

        function removeService(id) {
          res = confirm("Do you really want to delete this item?");
          if (res){
            $.ajax({
              url:'/servers/' + id,
              type:'delete'
            }).then(function(ret){
                console.log(ret);
                location.href = "{{$servers->url($servers->currentPage())}}"
            }, function(err){
                console.log(err);
            })
          }
        }

        $(function() {
        });
</script>
@endsection
