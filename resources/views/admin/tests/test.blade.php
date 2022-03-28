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
                <form method="POST" action="{{ route("admin.tests.score") }}" enctype="multipart/form-data">
                    @csrf
                <tbody>
                    <td>
                        <input type="hidden" name="test_total" value="{{ $test_total }}">
                        <input type="hidden" name="test_id" value="{{ $value->test_id }}">
                        <input type="hidden" name="question_id[]" value="{{ $value->id }}">
                        {{ $value->id }}</td>
                    <td>{{ $value->question_text }}</td>
                    <td>@foreach (json_decode($value->answare) as $key => $value1)
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="answare[{{$value->id}}]" id="answare_a" value="a">{{ $value1->a }}
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="answare[{{$value->id}}]" id="answare_b" value="b">{{ $value1->b }}
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="answare[{{$value->id}}]" id="answare_c" value="c">{{ $value1->c }}
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="answare[{{$value->id}}]" id="answare_d" value="d">{{ $value1->d }}
                        </div>
                        @endforeach
                    </td>
                </tbody>

                @endforeach
            </table>
            <div class="row">
                <div class="col">
                    <div class="form-group">
                        <a class="btn btn-default" href="{{ route('admin.tests.index') }}">
                            {{ trans('global.back_to_list') }}
                        </a>
                    </div>
                </div>
                <div class="col text-right">
                    <div class="form-group">
                        <button class="btn btn-primary" type="submit">
                            {{ trans('global.finish') }}
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </form>
</div>



@endsection
