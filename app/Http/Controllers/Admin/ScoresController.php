<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyTestRequest;
use App\Http\Requests\StoreTestRequest;
use App\Http\Requests\UpdateTestRequest;
use App\Models\Course;
use App\Models\Lesson;
use App\Models\Question;
use App\Models\Test;
use App\Models\MScoreSiswa;
use Illuminate\Support\Facades\Auth;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection;

class ScoresController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('test_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $scores = MScoreSiswa::with(['test'])->get();

        return view('admin.scores.index', compact('scores'));
    }

    public function create()
    {
        abort_if(Gate::denies('test_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $courses = Course::all()->pluck('title', 'id')->prepend(trans('global.pleaseSelect'), '');

        $lessons = Lesson::all()->pluck('title', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.tests.create', compact('courses', 'lessons'));
    }

    public function store(StoreTestRequest $request)
    {
        $test = Test::create($request->all());

        return redirect()->route('admin.tests.index');
    }

    public function edit(Test $test)
    {
        abort_if(Gate::denies('test_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $courses = Course::all()->pluck('title', 'id')->prepend(trans('global.pleaseSelect'), '');

        $lessons = Lesson::all()->pluck('title', 'id')->prepend(trans('global.pleaseSelect'), '');

        $test->load('course', 'lesson');

        return view('admin.tests.edit', compact('courses', 'lessons', 'test'));
    }

    public function test($id)
    {
        abort_if(Gate::denies('question_test_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $test = Question::where('test_id',$id)->get();
        $test_total = Question::where('test_id',$id)->count();

        return view('admin.tests.test', compact('test','test_total'));
    }

    public function update(UpdateTestRequest $request, Test $test)
    {
        $test->update($request->all());

        return redirect()->route('admin.tests.index');
    }

    public function show(Test $test)
    {
        abort_if(Gate::denies('test_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $test->load('course', 'lesson');

        return view('admin.tests.show', compact('test'));
    }

    public function destroy(Test $test)
    {
        abort_if(Gate::denies('test_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $test->delete();

        return back();
    }

    public function massDestroy(MassDestroyTestRequest $request)
    {
        Test::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function score(Request $request)
    {
        $answare        = $request->post('answare');
        $question_id    = $request->post('question_id');
        $test_total     = $request->post('test_total');
        $test_id        = $request->post('test_id');
        $score    =0;
        $true     =0;
        $false    =0;
        $null     =0;
        for($i=0;$i<$test_total;$i++){
            $nomor    =$question_id[$i];
            if(empty($answare[$nomor])){
                $null++;
            }else{
                $ans    =$answare[$nomor];
                $users_count = DB::table('questions')
                ->where('id', '=', $nomor)
                ->where('answare_option', '=', $ans)
                ->count();
                $users_count1 = Question::where('id', '=', $nomor)
                ->where('answare_option', '=', $ans)
                ->sum('points');


                if($users_count){
                    $true++;
                }
                else {
                    $false++;
                }
            }
        }

        $total = Question::where('test_id',$test_id)->get();
        $collection = new Collection($total);
        $totalScore = $collection->sum('id');
        $score    = number_format(100 / $totalScore * $true);

        $benarSiswa = $true;
        $salahSiswa = $false;
        $nilaiSiswa = $score;
        $scoreSiswa = new MScoreSiswa;
        $scoreSiswa->siswa_id = Auth::user()->id;
        $scoreSiswa->test_id = $test_id;
        $scoreSiswa->score = $score;
        $scoreSiswa->save();
        return view('admin.tests.score', compact('score'));

    }
}
