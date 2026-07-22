@php
    $course_progress = App\Models\Watch_history::join('users', 'watch_histories.student_id', '=', 'users.id')
        ->where('watch_histories.course_id', $course_details->id)
        ->where('users.role', 'student')
        ->select('watch_histories.student_id')
        ->distinct()
        ->orderBy('watch_histories.student_id', 'desc')
        ->get();

    $total_lessons = App\Models\Lesson::where('course_id', $course_details->id)->count();
@endphp

<div class="row">
    <div class="col-md-12">
        <div class="table-responsive">

            <table class="table eTable eTable-2 align-middle">

                <thead>
                    <tr>
                        <th class="text-start">{{ get_phrase('Student') }}</th>
                        <th>{{ get_phrase('Date') }}</th>
                        <th>{{ get_phrase('Progress') }}</th>
                        <th class="text-center">{{ get_phrase('Action') }}</th>
                    </tr>
                </thead>

                <tbody>

                    @foreach ($course_progress as $progress)
                        @php
                            $studentInfo = App\Models\User::where('id', $progress->student_id)->where('role', 'student')->first();
                            $watch_history = App\Models\Watch_history::where('course_id', $course_details->id)
                                ->where('student_id', $progress->student_id)
                                ->get();
                            /* completed lesson count */
                            $completed_lessons = 0;
                            foreach ($watch_history as $history) {
                                $lessons = json_decode($history->completed_lesson, true);

                                if (is_array($lessons)) {
                                    $completed_lessons += count($lessons);
                                }
                            }
                            /* completed date */
                            $completed_date = $watch_history->first()->completed_date ?? null;
                            /* percentage calculation */
                            if ($completed_date) {
                                $percentage = 100;
                            } else {
                                $percentage =
                                    $total_lessons > 0 ? round(($completed_lessons / $total_lessons) * 100) : 0;
                            }
                            /* watched duration from watch_durations table */
                            $total_watch = App\Models\WatchDuration::where('watched_course_id', $course_details->id)
                                ->where('watched_student_id', $progress->student_id)
                                ->sum('current_duration');
                            $watched_duration = gmdate('H:i:s', $total_watch);
                            /* last seen */
                            $last_seen = $watch_history->sortByDesc('updated_at')->first()?->updated_at;
                        @endphp

                        <tr>

                            <td>
                                <p>{{ $studentInfo->name ?? '' }}</p>
                                <small class="text-muted">{{ $studentInfo->email ?? '' }}</small>
                            </td>

                            <td>

                                <p>
                                    <strong>{{ get_phrase('Enrolled : ') }}</strong>
                                    {{ $studentInfo?->created_at?->format('d M Y') }}
                                </p>

                                <p>
                                    <b>{{ get_phrase('Last seen : ') }}</b>
                                    {{ $last_seen ? date('d M Y, h:i a', strtotime($last_seen)) : '---' }}
                                </p>

                                <p>
                                    <b>{{ get_phrase('Completed : ') }}</b>

                                    @if ($completed_date)
                                        {{ date('d M Y, h:i a', $completed_date) }}
                                    @else
                                        {{ get_phrase('Not completed yet') }}
                                    @endif

                                </p>

                            </td>

                            <td>

                                <div style="max-width:220px;margin:auto">

                                    <div class="progress mb-2" style="height:18px">

                                        <div class="progress-bar"
                                            style="width:{{ $percentage }}%; background:#1C84FE;">

                                            {{ $percentage }}%

                                        </div>

                                    </div>

                                    <small class="text-muted">

                                        {{ get_phrase('Completed lesson') }}
                                        {{ $completed_lessons }} / {{ $total_lessons }}

                                        <br>

                                        {{ get_phrase('Watched duration') }}
                                        <b>{{ $watched_duration }}</b>

                                    </small>

                                </div>

                            </td>

                            <td class="text-center">

                                <div class="d-flex justify-content-center gap-2">

                                    
                                   <a href="javascript:;" 
                                        data-bs-toggle="tooltip" 
                                        title="{{ get_phrase('Quiz Result') }}" 
                                        onclick="ajaxModal('{{ route('modal', ['admin.course.academic_progress_quiz_result', 'student_id' => $progress->student_id, 'course_id' => $course_details->id]) }}', '{{ get_phrase('Quiz Result') }}', 'modal-lg')" 
                                        class="edit-delete">

                                        <i class="fa fa-id-card"></i>

                                        </a>

                                </div>

                            </td>

                        </tr>
                    @endforeach

                </tbody>
            </table>

        </div>
         @if ($course_progress->count() > 0)
            <div class="admin-tInfo-pagi d-flex justify-content-md-between justify-content-center align-items-center gr-15 flex-wrap">
                <p class="admin-tInfo">
                    {{ get_phrase('Showing') }} {{ $course_progress->count() }}
                    {{ get_phrase('of') }} {{ method_exists($course_progress,'total') ? $course_progress->total() : $course_progress->count() }}
                    {{ get_phrase('data') }}
                </p>

                @if(method_exists($course_progress,'links'))
                    {{ $course_progress->links() }}
                @endif
            </div>
            @endif
    </div>
</div>
