@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.test.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.tests.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <thead>
                    <th>No</th>
                    <th>Question</th>
                    <th>Answere</th>
                </thead>

                @foreach($test as $value)
                <tbody>
                    <th>{{ $value->id }}</th>
                    <th>{{ $value->question_text }}</th>
                    <th>{{ $value->points }}</th>
                </tbody>

                @endforeach
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.tests.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection
