@extends('layouts.authenticated')

@section('content')
    <div class="container">
        <div class="page-header">
            <h1 class="h2">@lang('content.users.users-title')</h1>
            <span>@lang('content.users.users-description')</span>
        </div>
        <div class="text-right add-entry">
            <a class="btn btn-sm btn-success" href="{{ route('showAddUserForm') }}" title="@lang('content.users.add-user-button')">
                <i class="fa fa-plus"></i> @lang('content.users.add-user-button')
            </a>
        </div>
        <div class="clearfix"></div><br>
        @if(count($users))
            <div class="table-responsive">
                <table class='table table-hover table-striped'>
                    <tr>
                        <th class="text-center">#</th>
                        <th class="text-center">@lang('content.users.first-name')</th>
                        <th class="text-center">@lang('content.users.last-name')</th>
                        <th class="text-center">@lang('content.users.username')</th>
                        <th class="text-center">@lang('content.users.last-login-date')</th>
                        <th class="text-center">@lang('content.table-headers.creation-date')</th>
                        <th class="text-center">@lang('content.table-headers.actions')</th>
                    </tr>

                    @foreach($users as $key => $user)
                        <tr class="text-center">
                            <td>@entryNo($key, $users->currentPage(), $users->perPage())</td>
                            <td>{{ $user->first_name }}</td>
                            <td>{{ $user->last_name }}</td>
                            <td>{{ $user->username }}</td>
                            <td>@if(!is_null($user->logged_at)) {{ $user->logged_at }} @else @lang('messages.users.never-signed-in') @endif</td>
                            <td>{{ $user->created_at }}</td>
                            <td class="action-buttons">
                                <a data-toggle="tooltip" data-placement="top" class="btn btn-xs btn-primary" href="{{ route('showEditUserForm', ['user' => $user->id]) }}" title="@lang('content.users.edit-user-button')">
                                    <i class="fa fa-pencil"></i>
                                </a>
                                <a data-toggle="tooltip" data-placement="top" class="btn btn-xs btn-danger delete" href="{{ route('deleteUser', ['user' => $user->id]) }}" title="@lang('content.users.delete-user-button')" data-message="@lang('messages.users.delete-user', ['name' => $user->getFullName()])">
                                    <i class="fa fa-trash"></i>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </table>
            </div>
            <div class="text-center">
                <ul class="pagination">
                    {{ $users->links() }}
                </ul>
            </div>
        @else
            <div class="alert alert-danger text-center" role="alert">
                <i class="fa fa-warning"></i> @lang('messages.users.no-users')
            </div>
        @endif
    </div>
@endsection