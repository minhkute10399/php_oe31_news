@extends('website.backend.layouts.main')

@section('content')
    <div class="col-md-12 col-sm-12 ">
        <div class="x_panel">
            <div class="x_title">
                <h2>{{ trans('message.request_post') }}</h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="card-box table-responsive">
                            <div id="datatable-responsive_wrapper"
                                class="dataTables_wrapper container-fluid dt-bootstrap no-footer">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div id="datatable-responsive_filter" class="dataTables_filter">
                                            <label>{{ trans('message.search') }}
                                                <input type="search" class="form-control input-sm" placeholder=""
                                                    aria-controls="datatable-responsive">
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <table id="datatable-responsive"
                                            class="table table-striped table-bordered dt-responsive nowrap dataTable no-footer dtr-inline"
                                            cellspacing="0" width="100%" role="grid"
                                            aria-describedby="datatable-responsive_info">
                                            <thead>
                                                <tr role="row">
                                                    <th class="sorting_asc" tabindex="0"
                                                        aria-controls="datatable-responsive" rowspan="1" colspan="1"
                                                        aria-sort="ascending"
                                                        aria-label="First name: activate to sort column descending">
                                                        {{ trans('message.stt') }}
                                                    </th>
                                                    <th class="sorting_asc" tabindex="0"
                                                        aria-controls="datatable-responsive" rowspan="1" colspan="1"
                                                        aria-sort="ascending"
                                                        aria-label="First name: activate to sort column descending">
                                                        {{ trans('message.user') }}
                                                    </th>
                                                    <th class="sorting" tabindex="0" aria-controls="datatable-responsive"
                                                        rowspan="1" colspan="1"
                                                        aria-label="Last name: activate to sort column ascending">
                                                        {{ trans('message.created_at') }}
                                                    </th>
                                                    <th class="sorting" tabindex="0" aria-controls="datatable-responsive"
                                                        rowspan="1" colspan="1"
                                                        aria-label="Last name: activate to sort column ascending">
                                                        {{ trans('message.action') }}
                                                    </th>
                                                </tr>
                                            </thead>
                                            @php
                                                $index = config('number_status_post.status_request');
                                            @endphp
                                            <tbody>
                                                @foreach ($requestWriter as $item)
                                                    <tr role="row" class="odd">
                                                        <td>{{ $index++ }}</td>
                                                        <td>{{ $item->author->name }}</td>
                                                        <td>{{  date('M d ,Y', strtotime($item->created_at))}} {{ trans('message.at')}} {{ date('g:ia', strtotime($item->created_at)) }}</td>
                                                        <td class="d-flex">
                                                            <button type="button" class="btn btn-primary"
                                                                data-toggle="modal" data-target="#post{{ $item->id }}">
                                                                {{ trans('message.preview') }}
                                                            </button>

                                                            <form action="{{ route('requests.update', [$item->id]) }}"
                                                                method="POST">
                                                                @csrf
                                                                @method('PUT')
                                                                <input type="hidden" name="role_id" value="2">
                                                                <button type="submit" class="btn btn-success">
                                                                    {{ trans('message.accept') }}
                                                                </button>
                                                            </form>

                                                            <form action="{{ route('authors.update', [$item->id]) }}"method="POST">
                                                                @csrf
                                                                @method('PUT')
                                                                <input type="hidden" name="status"
                                                                    value="{{ config('number_status_post.status_block') }}">
                                                                <button type="button" class="btn btn-danger"
                                                                    data-toggle="modal"
                                                                    data-target="#reject{{ $item->id }}">
                                                                    {{ trans('message.reject') }}
                                                                </button>
                                                            </form>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @foreach ($requestWriter as $post)
        <div class="modal fade" id="post{{ $post->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">{{ $post->author->name }}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row mb-50">
                            <div class="col-lg-8 col-md-12">
                                <div class="bt-1 border-color-1 mb-30"></div>
                                <div class="entry-main-content">
                                    {!! $post->note !!}
                                </div>
                                <div class="entry-bottom mt-50 mb-30">
                                    <div class="font-weight-500 entry-meta meta-1 font-x-small color-grey">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ trans('message.close') }}</button>
                    </div>
                </div>
            </div>
        </div>
    @endforeach

    @foreach ($requestWriter as $post)
        <form action="{{ route('requests.destroy', [$post->id]) }}" method="POST">
            @csrf
            @method('DELETE')
            <input type="hidden" name="status" value="{{ config('number_status_post.status_block') }}">
            <div class="modal fade" id="reject{{ $post->id }}" tabindex="-1" role="dialog"
                aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">{{ trans('message.reject') }}</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            {{ trans('message.want_reject') }}
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary"
                                data-dismiss="modal">{{ trans('message.close') }}</button>
                            <button type="submit" class="btn btn-danger">{{ trans('message.reject') }}</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    @endforeach
@endsection
